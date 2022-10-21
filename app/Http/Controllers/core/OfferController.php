<?php

namespace App\Http\Controllers\core;

use App\Http\Controllers\Controller;
use App\Mail\OfferMail;
use App\Models\core\offer;
use App\Models\core\offer_price_prev_log;
use App\Models\core\order_log;
use App\Models\stock;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class OfferController extends Controller
{
    public function index(): View
    {
        return view('offer.offer');
    }

    public function returnAllOfferData()
    {
        $data = offer::query()
            ->with(
                [
                    'Stock',
                    'Stock.Product.Manufacturer',
                    'Stock.Status',
                    'Stock.GradingScale',
                    'Stock.Color',
                    'User',
                ]
            )
            ->when(request('user_id'), function ($q) {
                $q->where('user_id', request('user_id'));
            })
            ->when(request('product_id'), function ($q) {
                $q->whereHas('Stock.Product', function ($q) {
                    $q->where('id', request('product_id'));
                });
            })
            ->when(request('grading_scale_id'), function ($q) {
                $q->whereHas('Stock.GradingScale', function ($q) {
                    $q->where('id', request('grading_scale_id'));
                });
            })
            ->where('status', '!=', offer::STATUS_REJECT)
            ->latest()
            ->paginate(25);

        return response()->json($data);
    }


    public function reviewOffer(Request $request)
    {
        $msg = '';

        $offer = offer::query()
            ->where('id', $request->offer_id)
            ->with('Stock.Product.Manufacturer', 'Stock.Status', 'Stock.GradingScale', 'Stock.Color', 'Stock.Carrier')
            ->first();

        $item_name = $offer->Stock->Product->name . ' ' . $offer->Stock->Color->name . ' ' . $offer->Stock->Status->name . ' ' . $offer->Stock->Carrier->name . ' ' . $offer->Stock->GradingScale->name;

        try {

            $user = User::query()
                ->where('id', $offer->user_id)
                ->first();

            $flag = 1;

            if ($request->is_accept) {

                Mail::to($user->email)->send(new OfferMail($user, $offer, $request->offer_price, $item_name, $flag));

                offer_price_prev_log::create([
                    'offer_id' => $offer->id,
                    'price' => $offer->price
                ]);

                $offer->update(['price' => $request->offer_price, 'status' => offer::STATUS_COUNTERED, 'accepted_at' => now()]);
                $msg = "Feedback sent successfully";
            } else {
                $flag = 0;
                Mail::to($user->email)->send(new OfferMail($user, $offer, $request->offer_price, $item_name, $flag));
                $offer->update(['status' => offer::STATUS_REJECT, 'rejected_at' => now()]);
                $msg = 'Offer rejected';
            }
        } catch (\Exception $e) {
            return response()->json($e->getMessage());
        }
        return response()->json($msg);
    }

    public function accept(offer $offer)
    {
        $offer->update(['status'=>offer::STATUS_ACCEPT]);
        toast("Offer accepted successfully","success");
        return redirect()->back();
    }

    public function reject(offer $offer)
    {
        $offer->update(['status'=>offer::STATUS_REJECT]);
        toast("Offer Rejected successfully","success");
        return redirect()->back();
    }
}
