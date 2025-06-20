<?php

namespace App\Mail;

use App\Models\TriggerStock;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class StockOrderNotification extends Mailable
{
    use Queueable, SerializesModels;

    public $trigger;

    public function __construct(TriggerStock $trigger)
    {
        $this->trigger = $trigger;
    }

    public function build()
    {
        return $this->subject('🚨 Commande Automatisée - Doctopet')
            ->view('emails.stock_order_notification');
    }
}
