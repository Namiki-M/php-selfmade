<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class OrderedMail extends Mailable
{
    use Queueable, SerializesModels;

    public $product;
    public $user;
    public $place;

    public function __construct($product, $user, $place)
    {
        $this->product = $product;
        $this->user = $user;
        $this->place = $place;

    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        
        return $this->view('emails.ordered')
        ->subject('商品が注文されました。/ The item has been ordered.');
    }
}
