<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\OpeningHours;

class OpeningHoursController extends Controller
{

    const MINUTES_PER_HOUR = 60;
    const MINUTES_PER_TIMESLOT = 15;

    public function getOpeningHours($id){
        $hours = [];
        for($dayOfWeek = 0; $dayOfWeek < 7; $dayOfWeek++){
            //0 is Sunday like in the Carbon-class, Monday = 1, ...
            $hoursThisDay = [];
            $hourString = OpeningHours::where('placeId',$id)
                                ->where('dayOfWeek',$dayOfWeek)->first();
            if($hourString){
                $hourString = $hourString->hours;

                $open = FALSE;
                $begin = '';
                $end = '';
                for($charnum = 0; $charnum < strlen($hourString); $charnum++){
                    $character = substr($hourString,$charnum,1);
                    if(!$open && $character === '1'){
                        $begin = sprintf("%'.02d:%'.02d",intdiv(($charnum)*self::MINUTES_PER_TIMESLOT,self::MINUTES_PER_HOUR),(($charnum)*self::MINUTES_PER_TIMESLOT)%self::MINUTES_PER_HOUR);
                        $open = TRUE;
                    } else if($open && ($character === '0' || $charnum == strlen($hourString)-1)){
                        $charnum = $charnum == strlen($hourString)-1 ? $charnum+1 : $charnum;
                        $end = sprintf("%'.02d:%'.02d",intdiv(($charnum)*self::MINUTES_PER_TIMESLOT,self::MINUTES_PER_HOUR),(($charnum)*self::MINUTES_PER_TIMESLOT)%self::MINUTES_PER_HOUR);
                        array_push($hoursThisDay, $begin.' - '.$end);
                        $open = FALSE;
                    }
                }
            }
            $hours[$dayOfWeek] = $hoursThisDay;
        }
        return $hours;
    }

    public function addOpeningHours($id){

    }
}
