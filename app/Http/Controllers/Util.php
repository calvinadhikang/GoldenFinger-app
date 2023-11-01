<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use stdClass;

class Util extends Controller
{
    static public function getDiffDays($timestamp, $currentDate = null){
        // Get the current date and time
        if ($currentDate == null) {
            $currentDate = Carbon::now();
        }
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

        $code = "PO/GWI/{$month}/{$year}";

        return $code;
    }

    static function getCompanyProfile(){
        $obj = new stdClass();
        $obj->nama = "PT. GOLDFINGER WHEELS INDONESIA";
        $obj->alamat = "Jl. Soekarno Hatta RT.019, Graha Indah, Balikpapan Utara 76123-East Kalimantan";
        $obj->email = "pt.goldfingerwheelsindonesia@gmail.com";
        $obj->telp = "082157118887/08125309669";
        $obj->NPWP = "40.388.380.4-721.000";

        return $obj;
    }
}
