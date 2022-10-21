<?php

namespace App\Mail;

use App\Models\core\offer;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class OfferMail extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $offer;
    public $offer_price;
    public $item_name;
    public $flag;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($user, $offer, $offer_price, $item_name, $flag)
    {
        $this->offer = $offer;
        $this->offer_price = $offer_price;
        $this->flag = $flag;
        $this->item_name = $item_name;
        $this->user = $user;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('mail.offer_mail', [
            'offer' => $this->offer,
            'offer_price' => $this->offer_price,
            'flag' => $this->flag,
            'user' => $this->user,
            'item_name' => $this->item_name
        ]);
    }
}
