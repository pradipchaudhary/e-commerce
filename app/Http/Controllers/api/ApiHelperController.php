<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\core\cart;
use App\Models\core\esn;
use App\Models\core\offer;
use App\Models\setting\carrier;
use App\Models\setting\city;
use App\Models\setting\color;
use App\Models\setting\grading_scale;
use App\Models\setting\product;
use App\Models\setting\state;
use App\Models\setting\vendor;
use App\Models\stock;
use App\Models\stock_log;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;

class ApiHelperController extends Controller
{
    public function getGradeScaleDetailById()
    {
        return response()->json(grading_scale::query()
            ->where('id', request('grade_scale_id'))
            ->with('images')
            ->first());
    }

    public function stockReport()
    {
        $stocks = stock::query()
            ->when(request('product_id'), function ($query) {
                $query->where('product_id', request('product_id'));
            })
            ->when(request('grading_scale_id'), function ($query) {
                $query->where('grading_scale_id', request('grading_scale_id'));
            })
            ->when(request('color_id'), function ($query) {
                $query->where('color_id', request('color_id'));
            })
            ->when(request('carrier_id'), function ($query) {
                $query->where('carrier_id', request('carrier_id'));
            })
            ->with('Product', 'Color', 'Carrier', 'GradingScale')
            ->paginate(10);

        return response()->json($stocks);
    }

    public function stockLogReport()
    {
        $stocks = stock_log::query()
            ->whereHas('Stock', function ($query) {
                $query->when(request('product_id'), function ($q) {
                    $q->where('product_id', request('product_id'));
                })
                    ->when(request('grading_scale_id'), function ($q) {
                        $q->where('grading_scale_id', request('grading_scale_id'));
                    });
            })
            ->with('Stock', function ($query) {
                $query->when(request('product_id'), function ($q) {
                    $q->where('product_id', request('product_id'));
                })
                    ->when(request('grading_scale_id'), function ($q) {
                        $q->where('grading_scale_id', request('grading_scale_id'));
                    });
            })
            ->with('Stock.Product', 'Stock.Color', 'Stock.Carrier', 'Stock.GradingScale')
            ->when(request('from') && request('to'), function ($q) {
                $q->whereBetween('created_at', [request('from'), request('to')]);
            })
            ->paginate(10);

        return response()->json($stocks);
    }

    public function loadStockSetting()
    {
        $data['colors'] = color::query()->get();
        $data['carriers'] = carrier::query()->get();
        $data['grading_scales'] = grading_scale::query()->get();
        $data['products'] = product::query()->get();

        return response()->json($data);
    }

    public function getStateByCountry()
    {
        return response()->json(state::query()
            ->where('country_id', request('country_id'))
            ->get());
    }

    public function getCityByState()
    {
        return response()->json(city::query()->where('state_id', request('state_id'))->get());
    }

    public function checkEmail()
    {
        $user = User::query()->where('email', request('email'))->first();
        if ($user != null) {
            $msg = 'We already have an account associated with this email address';
        } else {
            $msg = '';
        }
        return response()->json($msg);
    }

    public function getUniqueSku()
    {
        return getUniqueSku();
    }

    public function checkSku()
    {
        if (stock::query()->where('sku', request('sku'))->first() != null) {
            $msg = 'SKU already exist';
        } else {
            $msg = '';
        }
        return response()->json($msg);
    }

    public function getStockById()
    {
        return response()->json(stock::query()
            ->where('id', request('stock_id'))
            ->with('Product', 'Product.Manufacturer', 'Carrier', 'Status', 'GradingScale')
            ->first());
    }

    public function getCartById()
    {
        return response()->json(cart::query()
            ->where('id', request('cart_id'))
            ->with('Stock.Product.Manufacturer', 'Stock.Status', 'Stock.GradingScale', 'Stock.Color', 'Stock.Carrier')
            ->first());
    }

    public function getDataByOfferId()
    {
        return response()->json(offer::query()
            ->where('id', request('offer_id'))
            ->with('Stock.Product.Manufacturer', 'Stock.Status', 'Stock.GradingScale', 'Stock.Color', 'Stock.Carrier')
            ->get());
    }

    public function getOfferSettingData()
    {
        $data['users'] = user::query()
            ->where('id', '!=', config('CONSTANT.SUPERADMIN_ID'))
            ->where('status', 1)
            ->get();
        $data['products'] = product::query()->get();
        $data['grading_scales'] = grading_scale::query()->get();
        return response()->json($data);
    }

    public function checkEsn()
    {
        try {
            $esn = esn::query()->where('esn', request('esn'))->where('status', 1)->whereNull('user_id')->first();
        } catch (Exception $e) {
            return response()->json($e->getMessage());
        }
        return response()->json($esn == null ? true : false);
    }

    public function getUserDetail()
    {
        return response()->json(
            User::query()
                ->where('id', request('user_id'))
                ->whereHas('userDetail')
                ->with('userDetail.State', 'userDetail.Country','userDetail.City')
                ->first()
        );
    }
}
