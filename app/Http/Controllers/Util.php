<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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

    static function generateInvoiceCode(){
        $year = date('y');
        $month = date('m');

        $lastStoredYear = DB::table('invoice_setting')->value('last_year');
        $lastStoredMonth = DB::table('invoice_setting')->value('last_month');

        // Check if the month has changed
        if ($year != $lastStoredYear || $month != $lastStoredMonth) {
            // If the month has changed, reset the count to 1
            DB::table('invoice_setting')->update([
                'last_year' => $year,
                'last_month' => $month,
                'data_count' => 0,
            ]);
        } else {
            // If it's the same month, increment the count
            DB::table('invoice_setting')->increment('data_count');
        }

        // Get the total data count in 3 digits
        $totalDataCount = DB::table('invoice_setting')->value('data_count');
        $totalDataCountFormatted = sprintf('%03d', $totalDataCount);

        // Generate the code
        $code = "GLVM/INV/{$year}{$month}/{$totalDataCountFormatted}";

        return $code;
    }

    static function generatePurchaseCode(){
        $year = date('y');
        $month = date('m');

        $code = "PO/GWI/{$year}/{$month}";

        return $code;
    }
}
