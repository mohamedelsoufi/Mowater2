<?php

namespace App\Http\Controllers\API\Organizations;

use App\Http\Controllers\Controller;
use App\Models\Garage;
use Illuminate\Http\Request;

class AvailableTimesController extends Controller
{
    public function index(Request $request)
    {
        try {
            $day = date("D", strtotime($request->date));

            $garage = Garage::with(['work_time', 'day_offs'])->find($request->id);


            $day_offs = $garage->day_offs()->where('date', $request->date)->get();
            foreach ($day_offs as $day_off) {
                if ($day_off)
                    return responseJson(0, 'requested date: ' . $request->date . ' is day off');
            }
            $find_day = array_search($day, $garage->work_time->days);


            if ($find_day !== false) {

                $module = $garage->work_time;

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

                    $reservations = $garage->reservations;
                    foreach ($reservations as $key => $reservation) {
                        $formated = date("h:i a", strtotime($reservation->time));

                        if (($key = array_search($formated, $available_times)) !== false) {
                            unset($available_times[$key]);
                        }
                    }
                }

                return responseJson(1, 'success', $available_times);
            }
        } catch (\Exception $e) {
            return responseJson(0, 'error');
        }
    }
}
