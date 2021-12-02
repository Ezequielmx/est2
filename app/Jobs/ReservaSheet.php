<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Services\GoogleSheet;

class ReservaSheet implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $values;

    public function __construct($values)
    {
        $this->values = $values;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $sheet = new GoogleSheet;

        $sheet->saveDataToSheet($this->values);
    }
}
