<?php

namespace App\Http\Controllers\core;

use App\Http\Controllers\Controller;
use App\Models\core\esn;
use App\Models\setting\vendor;
use App\Models\stock;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Reader\Exception;
use PhpOffice\PhpSpreadsheet\Writer\Xls;
use PhpOffice\PhpSpreadsheet\IOFactory;
use RealRashid\SweetAlert\Facades\Alert;

class ExcelUploadController extends Controller
{
    public function index()
    {
        return view('excel.excel_upload', [
            'vendors' => vendor::query()->get()
        ]);
    }

    public function store(Request $request)
    {
        DB::beginTransaction();
        $request->validate(['file'=>'required']);
        $the_file = $request->file('file');
        try {
            $spreadsheet = IOFactory::load($the_file->getRealPath());
            $sheet        = $spreadsheet->getActiveSheet();
            $row_limit    = $sheet->getHighestDataRow();
            $row_range    = range(2, $row_limit);

            foreach ($row_range as $key => $row) {
                $data[$key]['sku'] = $sheet->getCell('A' . $row)->getValue();
                $data[$key]['esn'] = $sheet->getCell('B' . $row)->getValue();
                $data[$key]['cost_price'] = $sheet->getCell('C' . $row)->getValue();
                $data[$key]['selling_price'] = $sheet->getCell('D' . $row)->getValue();
            }

            $data_collection = collect($data);
            $data_collection_group = $data_collection->groupBy('sku')->values();
            foreach ($data_collection_group as $key =>  $group) {
                foreach ($group as $index => $single_item) {
                    if ($group[0]['selling_price'] != $single_item['selling_price'] || $group[0]['cost_price'] != $single_item['cost_price']) {
                        Alert::warning("Selling price / Cost price is different for sku : " . $single_item['sku']);
                        return redirect()->back();
                    }
                }
            }

            $batch = esn::query()->max('batch');
            foreach ($data_collection_group as $key =>  $group) {
                foreach ($group as $index => $single_item) {
                    $stock = stock::query()
                        ->where('sku', $single_item['sku'])
                        ->with('Esns')
                        ->first();
                    $stock->update(['vendor_id' => $request->vendor_id, 'cost_price' => $single_item['cost_price'], 'price' => $single_item['selling_price']]);
                    if (esn::query()->where('esn', $single_item['esn'])->first() != null) {
                        Alert::error("ESN \ IMEI already exist");
                    }
                    esn::create(['stock_id' => $stock->id, 'sku' => $stock->sku, 'esn' => $single_item['esn'], 'status' => false, 'batch' => ($batch == null ? 1 : $batch + 1)]);
                }
            }

            toast('Excel uploaded successfully', 'success');
            DB::commit();
        } catch (Exception $e) {
            DB::rollback();
            toast("something went wrong");
            return redirect()->back();
        }
        return redirect()->back();
    }

    public function report()
    {
        return response()->json(stock::query()
            ->where('vendor_id', request('vendor_id'))
            ->with('Esns', function ($query) {
                $query->whereNotNull('batch');
            })
            ->get());
    }

    public function changeStatus(esn $esn): RedirectResponse
    {
        // abort_if($esn->status, 404);
        $esn->update(['status' => true]);
        toast("Esn updated successfully", "success");
        return redirect()->back();
    }
}
