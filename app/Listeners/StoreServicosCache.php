<?php

namespace App\Listeners;

use App\Events\ServicosRetrieved;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class StoreServicosCache
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
    public function handle(ServicosRetrieved $event): void
    {
        cache()->set('servicos',$event->data);
    }
}
