<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;

class Util extends Controller
{
    static public function getDiffDays($timestamp){
        // Get the current date and time
        $currentDate = Carbon::now();
        // Calculate the difference in days
        return $currentDate->diffInDays($timestamp);
    }

    static function parseNumericValue($value){
        $rawValue = str_replace(',', '', $value);
        $numeric = (float)$rawValue;
        return $numeric;
    }
}
