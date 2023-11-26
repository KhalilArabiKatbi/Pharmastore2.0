<?php

namespace App\Listeners;

use App\Events\sent;
use App\Events\OrderShipped;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class UpdateMedicineQuantities implements ShouldQueue
{
    use InteractsWithQueue;

    /**
     * Handle the event.
     */
    public function handle(sent $event)
    {
        // Retrieve the order from the event and update the quantities of medicines
        $order = $event->order;
        
        // Assuming you have a relationship between Order and OrderItem
        $order->items->each(function ($item) {
            $medicine = $item->medicine;
            $medicine->decrement('quantity_in_stock', $item->quantity_requested);
        });
    }
}
