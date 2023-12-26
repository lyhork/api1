<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;


     
    protected function isValidDate($date){
        //echo $date; die;
        if (false === strtotime($date)) {
            return false;
        }else {
            return true;
        }
    }

    protected function isValidDateTime($dateTime){
        $format = 'Y-m-d H:i:s'; 
        $d = DateTime::createFromFormat($format, $dateTime);
        return $d && $d->format($format) == $dateTime;
    }
}
