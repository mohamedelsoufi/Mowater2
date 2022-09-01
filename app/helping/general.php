<?php

use App\Models\Agency;
use App\Models\Branch;
use App\Models\Reservation;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

function slider_type()
{
    $slider_type = ['videos_home', 'images_home', 'section'];
    return implode(',', $slider_type);
}

function special_number_main_category()
{
    $main_category = array_keys(special_number_main_category_arr());

    return implode(',', $main_category);
}

function special_number_main_category_arr()
{
    return [
        'private_car_numbers' => __('words.private_car_numbers'),
        'shared_car_numbers' => __('words.shared_car_numbers'),
        'motorcycle_numbers' => __('words.motorcycle_numbers'),
    ];
}


function currency_code()
{
    $currency_code = array_keys(currency_code_arr());
    return implode(',', $currency_code);
}

function currency_code_arr()
{
    return [
        "ALL" => "Albania - ALL - lek",
        "DZD" => "Algeria - DZD - dinar",
        "AOA" => "Angola - AOA - kwanza",
        "ARS" => "Argentina - ARS - peso",
        "AMD" => "Armenia - AMD - dram",
        "AUD" => "Australia - AUD - dollar",
        "EUR" => "Europe Union - EUR - euro",
        "AZN" => "Azerbaijan - AZN - manat",
        "BHD" => "Bahrain - BHD - dinar",
        "BBD" => "Barbados - BBD - dollar",
        "BYN" => "Belarus - BYN - rouble",
        "BMD" => "Bermuda - BMD - dollar",
        "BOB" => "Bolivia - BOB - boliviano",
        "BAM" => "Bosnia and Herzegovina - BAM - konvertibilna marka",
        "BWP" => "Botswana - BWP - pula",
        "BRL" => "Brazil - BRL - real",
        "BGN" => "Bulgaria - BGN - lev",
        "CVE" => "Cabo Verde - CVE - escudo",
        "KHR" => "Cambodia - KHR - riel",
        "XAF" => "Cameroon,Chad,Congo,Equatorial Guinea,Gabon - XAF - CFA franc BEAC",
        "CAD" => "Canada - CAD - dollar",
        "KYD" => "Cayman Islands - KYD - dollar",
        "CLP" => "Chile - CLP - peso",
        "CNY" => "China, People’s Republic of - CNY - yuan",
        "COP" => "Colombia - COP - peso",
        "CDF" => "Congo, Democratic Republic of the - CDF - franc",
        "CRC" => "Costa Rica - CRC - colon",
        "HRK" => "Croatia - HRK - kuna",
        "CZK" => "Czech Republic - CZK - koruna",
        "DKK" => "Denmark,Greenland - DKK - kroner",
        "DOP" => "Dominican Republic - DOP - peso",
        "EGP" => "Egypt - EGP - pound",
        "FJD" => "Fiji - FJD - dollar",
        "GEL" => "Georgia - GEL - lari",
        "GHS" => "Ghana - GHS - cedi",
        "GIP" => "Gibraltar - GIP - pound",
        "GTQ" => "Guatemala - GTQ - quetzal",
        "GBP" => "United Kingdom - GBP - British pound sterling",
        "GYD" => "Guyana - GYD - dollar",
        "HNL" => "Honduras - HNL - lempira",
        "HKD" => "Hong Kong SAR - HKD - dollar",
        "HUF" => "Hungary - HUF - forint",
        "ISK" => "Iceland - ISK - krona",
        "INR" => "India - INR - rupee",
        "IDR" => "Indonesia - IDR - rupiah",
        "IQD" => "Iraq - IQD - dinar",
        "IMP" => "Isle of Man - IMP - pound",
        "ILS" => "Israel - ILS - shekel",
        "XOF" => "Ivory Coast (Cote d'Ivoire),Senegal - XOF - CFA franc BCEAO",
        "JMD" => "Jamaica - JMD - dollar",
        "JPY" => "Japan - JPY - yen",
        "JOD" => "Jordan - JOD - dinar",
        "KZT" => "Kazakhstan - KZT - tenge",
        "KES" => "Kenya - KES - shilling",
        "KRW" => "Korea, Republic of - KRW - won",
        "KWD" => "Kuwait - KWD - dinar",
        "KGS" => "Kyrgyzstan - KGS - som",
        "LAK" => "Lao PDR - LAK - kip",
        "LBP" => "Lebanon - LBP - pound",
        "LYD" => "Libya - LYD - dinar",
        "CHF" => "Liechtenstein,Switzerland - CHF - franc",
        "MOP" => "Macau SAR - MOP - pataca",
        "MGA" => "Madagascar - MGA - ariary",
        "MWK" => "Malawi - MWK - kwacha",
        "MYR" => "Malaysia - MYR - ringgit",
        "MVR" => "Maldives - MVR - rufiyaa",
        "MRU" => "Mauritania - MRU - ouguiya",
        "MUR" => "Mauritius - MUR - rupee",
        "MXN" => "Mexico - MXN - peso",
        "MDL" => "Moldova - MDL - leu",
        "MNT" => "Mongolia - MNT - tugrik",
        "MAD" => "Morocco - MAD - dirham",
        "MZN" => "Mozambique - MZN - metical",
        "MMK" => "Myanmar - MMK - kyat",
        "NAD" => "Namibia, Republic of - NAD - dollar",
        "NZD" => "new-Zealand - NZD - dollar",
        "NIO" => "Nicaragua - NIO - cordoba oro",
        "NGN" => "Nigeria - NGN - naira",
        "MKD" => "North Macedonia - MKD - denar",
        "NOK" => "Norway - NOK - kroner",
        "OMR" => "Oman - OMR - rial",
        "PKR" => "Pakistan - PKR - rupee",
        "PAB" => "Panama - PAB - balboa",
        "PGK" => "Papua New Guinea - PGK - kina",
        "PYG" => "Paraguay - PYG - guarani",
        "PEN" => "Peru - PEN - nuevo sol",
        "PHP" => "Philippines - PHP - peso",
        "PLN" => "Poland - PLN - zloty",
        "QAR" => "Qatar - QAR - riyal",
        "RON" => "Romania - RON - leu",
        "RUB" => "Russian Federation - RUB - ruble",
        "RWF" => "Rwanda - RWF - franc",
        "XCD" => "Saint Lucia - XCD - dollar",
        "SAR" => "Saudi Arabia - SAR - riyal",
        "RSD" => "Serbia - RSD - dinar",
        "SGD" => "Singapore - SGD - dollar",
        "ZAR" => "South Africa - ZAR - rand",
        "LKR" => "Sri Lanka - LKR - rupee",
        "SZL" => "Swaziland - SZL - lilangeni",
        "SEK" => "Sweden - SEK - krona",
        "TWD" => "Taiwan - TWD - dollar",
        "TJS" => "Tajikistan - TJS - somoni",
        "TZS" => "Tanzania - TZS - shilling",
        "THB" => "Thailand - THB - baht",
        "TTD" => "Trinidad And Tobago - TTD - dollar",
        "TND" => "Tunisia - TND - dinar",
        "TRY" => "Turkey - TRY - lira",
        "TMT" => "Turkmenistan - TMT - manat",
        "UGX" => "Uganda - UGX - shilling",
        "UAH" => "Ukraine - UAH - hryvnia",
        "AED" => "United Arab Emirates - AED - dirham",
        "USD" => "United States - USD - dollar",
        "UYU" => "Uruguay - UYU - peso",
        "UZS" => "Uzbekistan, Republic of - UZS - sum",
        "VEF" => "Venezuela - VEF - bolivar",
        "VND" => "Vietnam - VND - dong",
        "ZMW" => "Zambia - ZMW - kwacha",
        "ZWD" => "Zimbabwe - ZWD - dollar",

    ];
}


function discount_card_status()
{
    $status = array_keys(discount_card_status_arr());
    return implode(',', $status);
}

function discount_card_status_arr()
{
    return [
        'not_started' => __('words.not_started'),
        'started' => __('words.started'),
        'finished' => __('words.finished'),
    ];
}

function number_of_uses_times()
{
    $number_of_uses_times_arr = array_keys(number_of_uses_times_arr());
    return implode(',', $number_of_uses_times_arr);
}

function number_of_uses_times_arr()
{
    return [
        'one_time' => __('words.one_time'),
        'endless' => __('words.endless'),
        'specific_number' => __('words.specific_number'),
    ];
}

function g_status()
{
    $status_arr = array_keys(g_status_arr());

    return implode(',', $status_arr);
}

function g_status_arr()
{
    return [
        'not_mentioned' => __('words.not_mentioned'),
        'good' => __('words.good'),
        'very_good' => __('words.very_good'),
        'excellent' => __('words.excellent'),
    ];
}

function useWallet($module)
{
    $user = auth('api')->user();
    $wallet = $user->wallet;
    if (empty($wallet)) {
        return responseJson(0, __('message.user_not_have_wallet'));
    } else {
        if ($wallet->amount < $module) {
            return responseJson(0, __('message.wallet_not_enough_amount'));
        }
        $wallet->update([
            'amount' => $wallet->amount - $module
        ]);
    }
}

function updateNumberOfViews($module)
{
    $module->update([
        'number_of_views' => $module->number_of_views + 1
    ]);
}

function getAuthAPIUser()
{
    $user = \auth('api')->user();
    if (!$user)
        return responseJson(0, __('message.user_not_registered'));
    return $user;
}

function service_available_reservation($id, $date, $service_id, $module)
{
    try {

        $day = date("D", strtotime($date));

        $module = $module->with(['work_time', 'day_offs'])->find($id);

        $day_offs = $module->day_offs()->where('date', $date)->get();
        foreach ($day_offs as $day_off) {
            if ($day_off)
//                return [];
                return $date . __('message.is_day_off');
        }

        $service = \App\Models\Service::with('work_time')->find($service_id);

        $service_work_time = $service->work_time;

        if (!$service_work_time)
            return __('message.no_result');
        if (date('Y-m-d', strtotime($date)) <= \Carbon\Carbon::yesterday()->format('Y-m-d')) {
            return __('message.requested_date') . $date . ' ' . __('message.date_is_old');
        }
        $find_day = array_search($day, $service_work_time->days);


        if ($find_day !== false) {

            $available_times = [];

            $from = date("H:i", strtotime($service_work_time->from));
            $to = date("H:i", strtotime($service_work_time->to));


            if (!in_array(date("h:i a", strtotime($from)), $available_times)) {
                array_push($available_times, date("h:i a", strtotime($from)));
            }

            $time_from = strtotime($from);

            $new_time = date("H:i", strtotime($service_work_time->duration . ' minutes', $time_from));
            if (!in_array(date("h:i a", strtotime($new_time)), $available_times)) {
                array_push($available_times, date("h:i a", strtotime($new_time)));
            }

            while ($new_time < $to) {
                $time = strtotime($new_time);
                $new_time = date("H:i", strtotime($service_work_time->duration . ' minutes', $time));
                if ($new_time . ':00' >= $to) {
                    break;
                }

                if (!in_array(date("h:i a", strtotime($new_time)), $available_times)) {
                    array_push($available_times, date("h:i a", strtotime($new_time)));
                }


                $reservations = $service->reservations;
                if (!$reservations == null) {
                    foreach ($reservations as $key => $reservation) {
                        if ($reservation->pivot->service_id == $service_id) {
                            if ($reservation->date == $date) {
                                $formated = date("h:i a", strtotime($reservation->time));

                                if (($key = array_search($formated, $available_times)) !== false) {
                                    unset($available_times[$key]);
                                }
                            }
                        }


                    }
                }
            }

            return array_values($available_times);
        }
        return  __('message.date_is_not_available');
    } catch (\Exception $e) {
        return array('error : ' . $e->getMessage());
    }
}

function branchAvailableTimeForTestDrive($date, $id, $vehicle_id)
{
    try {

        $day = date("D", strtotime($date));

        $branch = Branch::with(['work_time', 'day_offs'])->find($id);


        $day_offs = $branch->day_offs()->where('date', $date)->get();
        foreach ($day_offs as $day_off) {
            if ($day_off)
                return responseJson(0, __('message.requested_date' . $date) . __('message.is_day_off'));
        }
        if (!$branch->work_time) {
            return responseJson(0, __('message.no_result'));
        }
        if (date('Y-m-d', strtotime($date)) <= \Carbon\Carbon::yesterday()->format('Y-m-d')) {
            return __('message.requested_date') . $date . ' ' . __('message.date_is_old');
        }
        $find_day = array_search($day, $branch->work_time->days);


        if ($find_day !== false) {

            $module = $branch->work_time;

            $available_times = [];

            $from = date("H:i", strtotime($module->from));
            $to = date("H:i", strtotime($module->to));


            if (!in_array(date("h:i a", strtotime($from)), $available_times)) {
                array_push($available_times, date("h:i a", strtotime($from)));
            }

            $time_from = strtotime($from);

            $new_time = date("H:i", strtotime($module->duration . ' minutes', $time_from));
            if (!in_array(date("h:i a", strtotime($new_time)), $available_times)) {
                array_push($available_times, date("h:i a", strtotime($new_time)));
            }

            while ($new_time < $to) {
                $time = strtotime($new_time);
                $new_time = date("H:i", strtotime($module->duration . ' minutes', $time));
                if ($new_time . ':00' >= $to) {
                    break;
                }

                if (!in_array(date("h:i a", strtotime($new_time)), $available_times)) {
                    array_push($available_times, date("h:i a", strtotime($new_time)));
                }

                $tests = $branch->tests;
                if (!$tests == null) {
                    foreach ($tests as $key => $test) {
                        if ($test->vehicle_id == $vehicle_id) {
                            if ($test->date == $date) {
                                $formated = date("h:i a", strtotime($test->time));

                                if (($key = array_search($formated, $available_times)) !== false) {
                                    unset($available_times[$key]);
                                }
                            }
                        }


                    }
                }

            }

            return array_values($available_times);
        }
        return __('message.date_is_not_available');
    } catch (\Exception $e) {
        return responseJson(0, 'error');
    }
}

function branchInUse($module, $usable_type, $id)
{
    $class = 'App\\Models\\' . $module;
    $model = new $class;
    $module = $model->find(request()->id);
    $branch_Ids = $module->branches()->pluck('id');

    $branch_use = DB::table('branch_use')->where('usable_type', $usable_type)
        ->where('usable_id', $id)
        ->whereIn('branch_id', $branch_Ids)->pluck('branch_id');
    $in_branches = Branch::whereIn('id', $branch_use)->with('contact')->get();
    return $in_branches;
}

function getNearestLocation($table)
{
    $lat = request()->latitude;
    $lon = request()->longitude;

    $data = DB::table($table)
        ->select("id", "name_en", "name_ar", "available", "active", "latitude", "longitude"
            , DB::raw("6371 * acos(cos(radians(" . $lat . "))
                * cos(radians(" . $table . ".latitude))
                * cos(radians(" . $table . ".longitude) - radians(" . $lon . "))
                + sin(radians(" . $lat . "))
                * sin(radians(" . $table . ".latitude))) AS distance_in_km"))
        ->groupBy($table . ".id")->whereNotNull(['latitude', 'longitude'])->orderBy('distance_in_km')
        ->where('active', 1)->where('available', 1)->paginate(PAGINATION_COUNT);
    return $data;
}

function userReservations($model)
{
    $user = getAuthAPIUser();
    $data = $user->reservations()->where('reservable_type', $model)->paginate(PAGINATION_COUNT);
    return $data;
}

function userReservation($model)
{
    $data = Reservation::where('reservable_type', $model)->find(request()->id);
    return $data;
}
