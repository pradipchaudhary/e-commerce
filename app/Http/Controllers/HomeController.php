<?php

namespace App\Http\Controllers;

use App\Models\core\cart;
use App\Models\core\offer;
use App\Models\setting\grade;
use App\Models\setting\grading_scale;
use App\Models\setting\manufacturer;
use App\Models\setting\product;
use App\Models\setting\status;
use App\Models\stock;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function index(): View
    {
        return view('home', [
            'users' => User::query()->get()
        ]);
    }

    public function stockList(): View
    {
        return view('user.stock-list');
    }

    public function home(): View
    {
        return view('welcome', [
            'grades' => grade::query()
                ->with('gradingScale.images')
                ->get()
        ]);
    }

    public function returnAllData()
    {
        $user = auth()->user();
        
        $data['data'] = DB::table('stocks')
            ->selectRaw('
        CONCAT(prod.name, "|", gs.name) AS product_grade_scale,
        stocks.product_id as product_id,
        stocks.id as id,
        stocks.grading_scale_id as grading_scale_id,
        prod.name as product_name, 
        carrier.name as carrier_name,
        man.name as manufacturer_name, 
        gs.name as grading_name,
        color.name as color_name,
        st.name as status_name,
        stocks.product_no as item_number,
        stocks.quantity as quantity,
        stocks.price as price')
            ->join('grading_scales as gs', 'stocks.grading_scale_id', '=', 'gs.id')
            ->join('carriers as carrier', 'stocks.carrier_id', '=', 'carrier.id')
            ->join('colors as color', 'stocks.color_id', '=', 'color.id')
            ->join('statuses as st', 'stocks.status_id', '=', 'st.id')
            ->join('products as prod', 'stocks.product_id', '=', 'prod.id')
            ->join('manufacturers as man', 'prod.manufacturer_id', '=', 'man.id')
            ->where('stocks.quantity', '!=', 0)
            ->orderBy('gs.name')
            ->get()
            ->groupBy('product_grade_scale')
            ->skip(0)
            ->take(10);

        $data['statuses'] = status::query()
            ->select('id', 'name')
            ->withCount('Stock as statusCount')
            ->get();

        $data['manufacturers'] = manufacturer::query()
            ->withCount('Stock as manufacturerCount')
            ->get();

        $data['grade_scales'] = grading_scale::query()
            ->select('id', 'name', 'grade_id')
            ->withCount('Stock as gardeScaleCount')
            ->get()
            ->groupBy('grade_id');

        $data['cart_count'] = cart::query()
            ->where('user_id', $user->id)
            ->count();

        $data['cart_count'] += offer::query()
            ->where('user_id', $user->id)
            ->count();

        $data['carts'] = cart::query()
            ->where('user_id', $user->id)
            ->get();

        $data['offers'] = offer::query()
            ->where('user_id', $user->id)
            ->get();

        $data['cart_offers'] = $data['carts']->merge($data['offers']);

        // repeating query for pagination
        $data['total_data_count'] = DB::table('stocks')
            ->selectRaw('CONCAT(prod.name, "|", gs.name) AS product_grade_scale')
            ->join('grading_scales as gs', 'stocks.grading_scale_id', '=', 'gs.id')
            ->join('products as prod', 'stocks.product_id', '=', 'prod.id')
            ->join('manufacturers as man', 'prod.manufacturer_id', '=', 'man.id')
            ->where('stocks.quantity', '!=', 0)
            ->get()
            ->groupBy('product_grade_scale')->count();

        $data['total_pages'] = ($data['total_data_count']) % 10 == 0 ? ($data['total_data_count']) / 10 : (int)($data['total_data_count'] / 10) + 1;
    
        return response()->json($data);
    }

    public function returnAllDataViaPost(Request $request)
    {
        // thats a messy query right ? but it worths because everything thing is done in single query :)
        $user = auth()->user();
        try {
            $data['data'] = DB::table('stocks')
                ->selectRaw('
            CONCAT(prod.name, "|", gs.name) AS product_grade_scale,
            stocks.product_id as product_id,
            stocks.grading_scale_id as grading_scale_id,
            stocks.id as id,
            prod.name as product_name, 
            carrier.name as carrier_name,
            man.name as manufacturer_name, 
            gs.name as grading_name,
            color.name as color_name,
            st.name as status_name,
            stocks.product_no as item_number,
            stocks.quantity as quantity,
            stocks.price as price')
                ->join('grading_scales as gs', 'stocks.grading_scale_id', '=', 'gs.id')
                ->join('carriers as carrier', 'stocks.carrier_id', '=', 'carrier.id')
                ->join('colors as color', 'stocks.color_id', '=', 'color.id')
                ->join('statuses as st', 'stocks.status_id', '=', 'st.id')
                ->join('products as prod', 'stocks.product_id', '=', 'prod.id')
                ->join('manufacturers as man', 'prod.manufacturer_id', '=', 'man.id')
                ->where('stocks.quantity', '!=', 0)
                ->when(count($request->status_id), function ($query) use ($request) {
                    $query->whereIn('stocks.status_id', $request->status_id);
                })
                ->when(count($request->manufacturer_id), function ($query) use ($request) {
                    $query->whereIn('prod.manufacturer_id', $request->manufacturer_id);
                })
                ->when(count($request->grading_scale_id), function ($query) use ($request) {
                    $query->whereIn('stocks.grading_scale_id', $request->grading_scale_id);
                })
                ->orderBy('gs.name')
                ->get()
                ->groupBy('product_grade_scale')
                ->skip(request('requested_page') * 10)
                ->take(10);
        } catch (\Exception $e) {
            return response()->json($e->getMessage());
        }

       
        $data['cart_count'] = cart::query()
            ->where('user_id', $user->id)
            ->count();

        $data['cart_count'] += offer::query()
            ->where('user_id',  $user->id)
            ->count();

        $data['carts'] = cart::query()
            ->where('user_id',  $user->id)
            ->get();

        $data['offers'] = offer::query()
            ->where('user_id',  $user->id)
            ->get();

        $data['cart_offers'] = $data['carts']->merge($data['offers']);
        
        // repeating query for pagination
        $data['total_data_count'] = DB::table('stocks')
            ->selectRaw('CONCAT(prod.name, "|", gs.name) AS product_grade_scale')
            ->join('grading_scales as gs', 'stocks.grading_scale_id', '=', 'gs.id')
            ->join('products as prod', 'stocks.product_id', '=', 'prod.id')
            ->join('manufacturers as man', 'prod.manufacturer_id', '=', 'man.id')
            ->where('stocks.quantity', '!=', 0)
            ->when(count($request->status_id), function ($query) use ($request) {
                $query->whereIn('stocks.status_id', $request->status_id);
            })
            ->when(count($request->manufacturer_id), function ($query) use ($request) {
                $query->whereIn('prod.manufacturer_id', $request->manufacturer_id);
            })
            ->when(count($request->grading_scale_id), function ($query) use ($request) {
                $query->whereIn('stocks.grading_scale_id', $request->grading_scale_id);
            })
            ->get()
            ->groupBy('product_grade_scale')->count();

        $data['total_pages'] = ($data['total_data_count']) % 10 == 0 ? ($data['total_data_count']) / 10 : (int)($data['total_data_count'] / 10) + 1;

        $data['current_page'] = request('requested_page') + 1;
        return response()->json($data);
    }
}
