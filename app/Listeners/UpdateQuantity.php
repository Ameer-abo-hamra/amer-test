<?php

namespace App\Listeners;

use App\Events\UpdateState;
use App\Models\Medication;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class UpdateQuantity
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(UpdateState $event): void
    {
        $req = $event->req;

        foreach ($req->medications as $re) {
        $med = Medication::find($re->pivot->medication_id);
            $med->update([
                "quantity" => $med->quantity - $re->pivot->quantity
            ]);
        }
    }
}
