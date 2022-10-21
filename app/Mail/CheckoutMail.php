<?php

namespace App\Mail;

use App\Models\core\order_log;
use App\Models\setting\shipping;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class CheckoutMail extends Mailable
{
    use Queueable, SerializesModels;
    public $token;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($token)
    {
        $this->token = $token;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $order_logs = order_log::query()
            ->where('token', $this->token)
            ->with('User.userDetail', 'Stock.Product.Manufacturer', 'Stock.Status', 'Stock.GradingScale', 'Stock.Color', 'Stock.Esns', 'shippingMethod', 'insurance', 'Shipping')
            ->get();

        $insurance_cost = 0;
        $shipping_costs = 0;
        $total_cost = 0;

        $shipping = shipping::query()
            ->where('id', $order_logs[0]->shipping_id)
            ->first();

        if ($order_logs->sum('quantity') >= $shipping->quantity) {
            $shipping_costs = 0;
        } else {
            $shipping_costs = $shipping->cost;
        }

        foreach ($order_logs as $key => $order_log) {
            $total_cost += $order_log->quantity * $order_log->price;
            $insurance_cost += (($order_log->insurance->percent / 100) * $order_log->quantity * $order_log->price);
        }
        return $this->view('mail.checkoutmail', [
            'token' => $this->token,
            'order_logs' => $order_logs,
            'user' => User::query()->where('id', $order_logs[0]->user_id)->first(),
            'insurance_cost' => round($insurance_cost, config('CONSTANT.DECIMAL_PLACE')),
            'shipping_cost' => round($shipping_costs, config('CONSTANT.DECIMAL_PLACE')),
            'total_cost' => round(($total_cost + $insurance_cost + $shipping_costs), config('CONSTANT.DECIMAL_PLACE'))
        ]);
    }
}
