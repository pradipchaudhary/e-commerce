<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class DeliveryMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */

    public $user;
    public $order_log;
    public $shipping_method;
    public $track_id;
    public $esnArray;

    public function __construct($user, $order_log, $shipping_method, $track_id,$esnArray)
    {
        $this->user = $user;
        $this->order_log = $order_log;
        $this->shipping_method = $shipping_method;
        $this->track_id = $track_id;
        $this->esnArray = $esnArray;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('mail.delivery_mail', [
            'user' => $this->user,
            'order_log' => $this->order_log,
            'shipping_method' => $this->shipping_method,
            'track_id' => $this->track_id,
            'esnArray' => $this->esnArray
        ]);
    }
}
