<?php

use App\Models\Agency;
use App\Models\Branch;
use App\Models\Permission;
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
        'excellent' => __('words.excellent'),
        'not_mentioned' => __('words.not_mentioned'),
        'good' => __('words.good'),
        'very_good' => __('words.very_good'),
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
        return __('message.date_is_not_available');
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

function createdAtFormat($model)
{
    return date('d/m/Y - h:i A', strtotime($model));
}

function updatedAtFormat($model)
{
    return date('d/m/Y - h:i A', strtotime($model));
}

function phoneCodes()
{
    return [
        "+376" => __("words.Andorra (+376)"),
        "+244" => __("words.Angola (+244)"),
        "+1264" => __("words.Anguilla (+1264)"),
        "+1268" => __("words.Antigua &amp; Barbuda (+1268)"),
        "+54" => __("words.Argentina (+54)"),
        "+374" => __("words.Armenia (+374)"),
        "+297" => __("words.Aruba (+297)"),
        "+61" => __("words.Australia (+61)"),
        "+43" => __("words.Austria (+43)"),
        "+994" => __("words.Azerbaijan (+994)"),
        "+1242" => __("words.Bahamas (+1242)"),
        "+973" => __("words.Bahrain (+973)"),
        "+880" => __("words.Bangladesh (+880)"),
        "+1246" => __("words.Barbados (+1246)"),
        "+375" => __("words.Belarus (+375)"),
        "+32" => __("words.Belgium (+32)"),
        "+501" => __("words.Belize (+501)"),
        "+229" => __("words.Benin (+229)"),
        "+1441" => __("words.Bermuda (+1441)"),
        "+975" => __("words.Bhutan (+975)"),
        "+591" => __("words.Bolivia (+591)"),
        "+387" => __("words.Bosnia Herzegovina (+387)"),
        "+267" => __("words.Botswana (+267)"),
        "+55" => __("words.Brazil (+55)"),
        "+673" => __("words.Brunei (+673)"),
        "+359" => __("words.Bulgaria (+359)"),
        "+226" => __("words.Burkina Faso (+226)"),
        "+257" => __("words.Burundi (+257)"),
        "+855" => __("words.Cambodia (+855)"),
        "+237" => __("words.Cameroon (+237)"),
        "+1" => __("words.Canada (+1)") .' & '. __("words.USA (+1)"),
        "+238" => __("words.Cape Verde Islands (+238)"),
        "+1345" => __("words.Cayman Islands (+1345)"),
        "+236" => __("words.Central African Republic (+236)"),
        "+56" => __("words.Chile (+56)"),
        "+86" => __("words.China (+86)"),
        "+57" => __("words.Colombia (+57)"),
        "+269" => __("words.Comoros (+269)") .' & '.__("words.Mayotte (+269)"),
        "+242" => __("words.Congo (+242)"),
        "+682" => __("words.Cook Islands (+682)"),
        "+506" => __("words.Costa Rica (+506)"),
        "+385" => __("words.Croatia (+385)"),
        "+53" => __("words.Cuba (+53)"),
        "+90392" => __("words.Cyprus North (+90392)"),
        "+357" => __("words.Cyprus South (+357)"),
        "+42" => __("words.Czech Republic (+42)"),
        "+45" => __("words.Denmark (+45)"),
        "+253" => __("words.Djibouti (+253)"),
        "+1809" => __("words.Dominica (+1809)").' & '.__("words.Dominican Republic (+1809)"),
//        "+1809" => __("words.Dominican Republic (+1809)"),
        "+593" => __("words.Ecuador (+593)"),
        "+20" => __("words.Egypt (+20)"),
        "+503" => __("words.El Salvador (+503)"),
        "+240" => __("words.Equatorial Guinea (+240)"),
        "+291" => __("words.Eritrea (+291)"),
        "+372" => __("words.Estonia (+372)"),
        "+251" => __("words.Ethiopia (+251)"),
        "+500" => __("words.Falkland Islands (+500)"),
        "+298" => __("words.Faroe Islands (+298)"),
        "+679" => __("words.Fiji (+679)"),
        "+358" => __("words.Finland (+358)"),
        "+33" => __("words.France (+33)"),
        "+594" => __("words.French Guiana (+594)"),
        "+689" => __("words.French Polynesia (+689)"),
        "+241" => __("words.Gabon (+241)"),
        "+220" => __("words.Gambia (+220)"),
        "+7880" => __("words.Georgia (+7880)"),
        "+49" => __("words.Germany (+49)"),
        "+233" => __("words.Ghana (+233)"),
        "+350" => __("words.Gibraltar (+350)"),
        "+30" => __("words.Greece (+30)"),
        "+299" => __("words.Greenland (+299)"),
        "+1473" => __("words.Grenada (+1473)"),
        "+590" => __("words.Guadeloupe (+590)"),
        "+671" => __("words.Guam (+671)"),
        "+502" => __("words.Guatemala (+502)"),
        "+224" => __("words.Guinea (+224)"),
        "+245" => __("words.Guinea - Bissau (+245)"),
        "+592" => __("words.Guyana (+592)"),
        "+509" => __("words.Haiti (+509)"),
        "+504" => __("words.Honduras (+504)"),
        "+852" => __("words.Hong Kong (+852)"),
        "+36" => __("words.Hungary (+36)"),
        "+354" => __("words.Iceland (+354)"),
        "+91" => __("words.India (+91)"),
        "+62" => __("words.Indonesia (+62)"),
        "+98" => __("words.Iran (+98)"),
        "+964" => __("words.Iraq (+964)"),
        "+353" => __("words.Ireland (+353)"),
        "+972" => __("words.Israel (+972)"),
        "+39" => __("words.Italy (+39)"),
        "+1876" => __("words.Jamaica (+1876)"),
        "+81" => __("words.Japan (+81)"),
        "+962" => __("words.Jordan (+962)"),
        "+7" => __("words.Kazakhstan (+7)").' & '.__("words.Uzbekistan (+7)").' & '.__("words.Russia (+7)").' & '.__("words.Tajikstan (+7)").' & '. __("words.Turkmenistan (+7)"),
        "+254" => __("words.Kenya (+254)"),
        "+686" => __("words.Kiribati (+686)"),
        "+850" => __("words.Korea North (+850)"),
        "+82" => __("words.Korea South (+82)"),
        "+965" => __("words.Kuwait (+965)"),
        "+996" => __("words.Kyrgyzstan (+996)"),
        "+856" => __("words.Laos (+856)"),
        "+371" => __("words.Latvia (+371)"),
        "+961" => __("words.Lebanon (+961)"),
        "+266" => __("words.Lesotho (+266)"),
        "+231" => __("words.Liberia (+231)"),
        "+218" => __("words.Libya (+218)"),
        "+417" => __("words.Liechtenstein (+417)"),
        "+370" => __("words.Lithuania (+370)"),
        "+352" => __("words.Luxembourg (+352)"),
        "+853" => __("words.Macao (+853)"),
        "+389" => __("words.Macedonia (+389)"),
        "+261" => __("words.Madagascar (+261)"),
        "+265" => __("words.Malawi (+265)"),
        "+60" => __("words.Malaysia (+60)"),
        "+960" => __("words.Maldives (+960)"),
        "+223" => __("words.Mali (+223)"),
        "+356" => __("words.Malta (+356)"),
        "+692" => __("words.Marshall Islands (+692)"),
        "+596" => __("words.Martinique (+596)"),
        "+222" => __("words.Mauritania (+222)"),
//        "+269" => __("words.Mayotte (+269)"),
        "+52" => __("words.Mexico (+52)"),
        "+691" => __("words.Micronesia (+691)"),
        "+373" => __("words.Moldova (+373)"),
        "+377" => __("words.Monaco (+377)"),
        "+976" => __("words.Mongolia (+976)"),
        "+1664" => __("words.Montserrat (+1664)"),
        "+212" => __("words.Morocco (+212)"),
        "+258" => __("words.Mozambique (+258)"),
        "+95" => __("words.Myanmar (+95)"),
        "+264" => __("words.Namibia (+264)"),
        "+674" => __("words.Nauru (+674)"),
        "+977" => __("words.Nepal (+977)"),
        "+31" => __("words.Netherlands (+31)"),
        "+687" => __("words.New Caledonia (+687)"),
        "+64" => __("words.New Zealand (+64)"),
        "+505" => __("words.Nicaragua (+505)"),
        "+227" => __("words.Niger (+227)"),
        "+234" => __("words.Nigeria (+234)"),
        "+683" => __("words.Niue (+683)"),
        "+672" => __("words.Norfolk Islands (+672)"),
        "+670" => __("words.Northern Marianas (+670)"),
        "+47" => __("words.Norway (+47)"),
        "+968" => __("words.Oman (+968)"),
        "+680" => __("words.Palau (+680)"),
        "+507" => __("words.Panama (+507)"),
        "+675" => __("words.Papua New Guinea (+675)"),
        "+595" => __("words.Paraguay (+595)"),
        "+51" => __("words.Peru (+51)"),
        "+63" => __("words.Philippines (+63)"),
        "+48" => __("words.Poland (+48)"),
        "+351" => __("words.Portugal (+351)"),
        "+1787" => __("words.Puerto Rico (+1787)"),
        "+974" => __("words.Qatar (+974)"),
        "+262" => __("words.Reunion (+262)"),
        "+40" => __("words.Romania (+40)"),
//        "+7" => __("words.Russia (+7)"),
        "+250" => __("words.Rwanda (+250)"),
        "+378" => __("words.San Marino (+378)"),
        "+239" => __("words.Sao Tome &amp; Principe (+239)"),
        "+966" => __("words.Saudi Arabia (+966)"),
        "+221" => __("words.Senegal (+221)"),
        "+381" => __("words.Serbia (+381)"),
        "+248" => __("words.Seychelles (+248)"),
        "+232" => __("words.Sierra Leone (+232)"),
        "+65" => __("words.Singapore (+65)"),
        "+421" => __("words.Slovak Republic (+421)"),
        "+386" => __("words.Slovenia (+386)"),
        "+677" => __("words.Solomon Islands (+677)"),
        "+252" => __("words.Somalia (+252)"),
        "+27" => __("words.South Africa (+27)"),
        "+34" => __("words.Spain (+34)"),
        "+94" => __("words.Sri Lanka (+94)"),
        "+290" => __("words.St. Helena (+290)"),
        "+1869" => __("words.St. Kitts (+1869)"),
        "+1758" => __("words.St. Lucia (+1758)"),
        "+249" => __("words.Sudan (+249)"),
        "+597" => __("words.Suriname (+597)"),
        "+268" => __("words.Swaziland (+268)"),
        "+46" => __("words.Sweden (+46)"),
        "+41" => __("words.Switzerland (+41)"),
        "+963" => __("words.Syria (+963)"),
        "+886" => __("words.Taiwan (+886)"),
//        "+7" => __("words.Tajikstan (+7)"),
        "+66" => __("words.Thailand (+66)"),
        "+228" => __("words.Togo (+228)"),
        "+676" => __("words.Tonga (+676)"),
        "+1868" => __("words.Trinidad &amp; Tobago (+1868)"),
        "+216" => __("words.Tunisia (+216)"),
        "+90" => __("words.Turkey (+90)"),
//        "+7" => __("words.Turkmenistan (+7)"),
        "+993" => __("words.Turkmenistan (+993)"),
        "+1649" => __("words.Turks &amp; Caicos Islands (+1649)"),
        "+688" => __("words.Tuvalu (+688)"),
        "+256" => __("words.Uganda (+256)"),
        "+44" => __("words.UK (+44)"),
        "+380" => __("words.Ukraine (+380)"),
        "+971" => __("words.United Arab Emirates (+971)"),
        "+598" => __("words.Uruguay (+598)"),
//        "+1" => __("words.USA (+1)"),
//        "+7" => __("words.Uzbekistan (+7)"),
        "+678" => __("words.Vanuatu (+678)"),
        "+379" => __("words.Vatican City (+379)"),
        "+58" => __("words.Venezuela (+58)"),
        "+84" => __("words.Vietnam (+84)").' & '.__("words.Virgin Islands - British (+1284)").' & '.__("words.Virgin Islands - US (+1340)"),
//        "+84" => __("words.Virgin Islands - British (+1284)"),
        "+84" => __("words.Virgin Islands - US (+1340)"),
        "+681" => __("words.Wallis &amp; Futuna (+681)"),
        "+969" => __("words.Yemen (North)(+969)"),
        "+967" => __("words.Yemen (South)(+967)"),
        "+260" => __("words.Zambia (+260)"),
        "+263" => __("words.Zimbabwe (+263)"),
    ];
}

function ad_status()
{
    $status = array_keys(ad_status_arr());
    return implode(',', $status);
}

function ad_status_arr()
{
    return array(
        'pending' => __('words.pending'),
        'approved' => __('words.approved'),
        'rejected' => __('words.rejected'),
    );
}

function getModelData()
{
    $user = auth()->guard('web')->user();
    $model_type = $user->organizable_type;
    $model_id = $user->organizable_id;
    $model = new $model_type;
    $record = $model->find($model_id);
    return $record;
}

function createMasterOrgUser($model){
    $user = $model->organization_users()->create([
        'user_name' => request()->user_name,
        'email' => request()->email,
        'password' => request()->password,
    ]);

    $org_role = $model->roles()->create([
        'name_en' => 'Organization super admin' .' '. $model->name_en,
        'name_ar' => 'صلاحية المدير المتميز' .' '. $model->name_ar,
        'display_name_ar' => 'صلاحية المدير المتميز' .' '. $model->name_ar,
        'display_name_en' => 'Organization super admin' .' '. $model->name_en,
        'description_ar' => 'له جميع الصلاحيات',
        'description_en' => 'has all permissions',
        'is_super' => 1,
    ]);

    foreach (\config('laratrust_seeder.org_roles') as $key => $values) {
        foreach ($values as $value) {
            $permission = Permission::create([
                'name' => $value . '-' . $key.'-'. $model->name_en,
                'display_name_ar' => __('words.' . $value) . ' ' . __('words.' . $key) . ' ' . $model->name_ar,
                'display_name_en' => $value . ' ' . $key . ' ' . $model->name_en,
                'description_ar' => __('words.' . $value) . ' ' . __('words.' . $key) . ' ' . $model->name_ar,
                'description_en' => $value . ' ' . $key . ' ' . $model->name_en,
            ]);
            $org_role->attachPermissions([$permission]);
        }
    }

    $user->attachRole($org_role);
}

function createMasterBranchUser($branch){
    $user = $branch->organization_users()->create([
        'user_name' => request()->user_name,
        'email' => request()->email,
        'password' => request()->password,
    ]);

    $branch_role = $branch->roles()->create([
        'name_en' => 'Branch super admin' .' '. $branch->name_en,
        'name_ar' => 'صلاحية المدير المتميز' .' '. $branch->name_ar,
        'display_name_ar' => 'صلاحية المدير المتميز' .' '. $branch->name_ar,
        'display_name_en' => 'Branch super admin' .' '. $branch->name_en,
        'description_ar' => 'له جميع الصلاحيات',
        'description_en' => 'has all permissions',
        'is_super' => 1,
    ]);

    foreach (\config('laratrust_seeder.org_roles') as $key => $values) {
        foreach ($values as $value) {
            $permission = Permission::create([
                'name' => $value . '-' . $key.'-'. $branch->name_en,
                'display_name_ar' => __('words.' . $value) . ' ' . __('words.' . $key) . ' ' . $branch->name_ar,
                'display_name_en' => $value . ' ' . $key . ' ' . $branch->name_en,
                'description_ar' => __('words.' . $value) . ' ' . __('words.' . $key) . ' ' . $branch->name_ar,
                'description_en' => $value . ' ' . $key . ' ' . $branch->name_en,
            ]);
            $branch_role->attachPermissions([$permission]);
        }
    }

    $user->attachRole($branch_role);
}
