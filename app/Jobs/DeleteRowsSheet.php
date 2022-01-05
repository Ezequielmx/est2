<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Services\GoogleSheet;

class DeleteRowsSheet implements ShouldQueue
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
        
        $form1 = "=COINCIDIR($this->values;G:G;0)-1";
        $arr = [];
        $arr2 =[];
        array_push($arr, $form1);
        array_push($arr2, $arr);

        $startIndex = $sheet->saveinCell($arr2, 'Hoja 1!Z1');

        $form2= "=CONTAR.SI(G:G;$this->values)";
        $arr = [];
        $arr2 =[];
        array_push($arr, $form2);
        array_push($arr2, $arr);

        $endIndex = $startIndex + $sheet->saveinCell($arr2, 'Hoja 1!Z1');

        $sheet->deleteRows($startIndex, $endIndex);
    }
}
