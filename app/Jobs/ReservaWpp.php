<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Mike4ip\ChatApi;
use App\Models\Reserva;





class ReservaWpp implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $cel;
    public $mens;
    public $reserva_id;

    public function __construct($reserva_id, $cel, $mens)
    {
        $this->cel = $cel;
        $this->mens = $mens;
        $this->reserva_id = $reserva_id;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $api = new ChatApi(
            'yb7lq7jpotu31kgq', 
            'https://api.chat-api.com/instance361534' ); 

        $api->sendPhoneMessage($this->cel, $this->mens);
        
        $res = Reserva::find($this->reserva_id);
        $res->wppconf=1;
        $res->save();
    }
}
