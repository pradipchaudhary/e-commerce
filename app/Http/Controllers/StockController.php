<?php

namespace App\Http\Controllers;

use App\Helper\SettingHelper;
use App\Http\Requests\ProductRequest;
use App\Models\setting\product;
use App\Models\stock;
use App\Models\stock_log;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;

class StockController extends Controller
{
    public function index(): View
    {
        return view('stock.stock');
    }

    public function create(SettingHelper $helper): View
    {
        $data = $helper->getSetting(['warehouse', 'status', 'manufacturer', 'grading_scale', 'color', 'carrier']);
        
        return view('stock.create_stock', [
            'warehouses' => $data['warehouse'] ?? collect([]),
            'statuses' => $data['status'] ?? collect([]),
            'manufacturers' => $data['manufacturer'] ?? collect([]),
            'grading_scales' => $data['grading_scale'] ?? collect([]),
            'colors' => $data['color'] ?? collect([]),
            'carriers' => $data['carrier'] ?? collect([]),
            'products' => product::query()->get()
        ]);
    }

    public function store(ProductRequest $request): RedirectResponse
    {
        DB::transaction(function () use ($request) {
    
            $stock = stock::create($request->all() +
                [
                    'user_id' => auth()->user()->id,
                    'product_no' => getRandomNumber()
                ]);

            stock_log::create(
                [
                    'stock_id' => $stock->id,
                    'quantity' => $request->quantity,
                    'price' => $request->price,
                ]
            );
        });

        toast('stock added successfully', 'success');
        return redirect()->route('stock.index');
    }

    public function addMore(Request $request): RedirectResponse
    {
        if ($request->price == '' || $request->quantity == '') {
            Alert::error("Quantity and price field is required");
        } else {
            DB::transaction(function () use ($request) {
                stock_log::create($request->all());

                $stock = stock::query()
                    ->where('id', $request->stock_id)
                    ->first();

                $stock->update(['quantity' => $stock->quantity + $request->quantity, 'price' => $request->price]);
            });

            toast("stock added successfully", "success");
        }
        return redirect()->back();
    }

    public function showStockLog(): View
    {
        return view('stock.stock-log');
    }
}
