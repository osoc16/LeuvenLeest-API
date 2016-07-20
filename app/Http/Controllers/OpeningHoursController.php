<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\OpeningHours;

class OpeningHoursController extends Controller
{

    
    const MINUTES_PER_HOUR = 60;
    const DIVISION_UNIT = 15; //quarters of hours
    const HOURS_IN_A_DAY = 24;

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
                        $begin = sprintf("%'.02d:%'.02d",intdiv(($charnum)*self::DIVISION_UNIT,self::MINUTES_PER_HOUR),(($charnum)*self::DIVISION_UNIT)%self::MINUTES_PER_HOUR);
                        $open = TRUE;
                    } else if($open && ($character === '0' || $charnum == strlen($hourString)-1)){
                        $charnum = $charnum == strlen($hourString)-1 ? $charnum+1 : $charnum;
                        $end = sprintf("%'.02d:%'.02d",intdiv(($charnum)*self::DIVISION_UNIT,self::MINUTES_PER_HOUR),(($charnum)*self::DIVISION_UNIT)%self::MINUTES_PER_HOUR);
                        array_push($hoursThisDay, $begin.' - '.$end);
                        $open = FALSE;
                    }
                }
            }
            $hours[$dayOfWeek] = $hoursThisDay;
        }
        return $hours;
    }

    public function addOpeningHours($id, Request $request){
        if(property_exists($requesst, 'timeframes')){
            try{
                foreach($request->timeframes as $timeframe){
                    foreach($timeframe->days as $day){
                        $openinghours = new OpeningHours();
                        $openinghours->placeId = $place->id;
                        $openinghours->dayOfWeek = $day;
                        $hourstring = '';
                        foreach($timeframe->open as $open){
                            $starthour =  intdiv(intval($open->start),100);
                            $startminutes = intval($open->start)%100;
                            $bitstart = (($starthour*self::MINUTES_PER_HOUR)+$startminutes)/self::DIVISION_UNIT;
                            $hourstring .= str_repeat('0', $bitstart-strlen($hourstring));
                            $endhour = intdiv(intval($open->end),100);
                            $endminutes = intval($open->end)%100;
                            if($endhour == 0 && $endminutes == 0){
                                $endhour = 24;
                            }
                            $bitend = (($endhour*self::MINUTES_PER_HOUR)+$endminutes)/self::DIVISION_UNIT;
                            $hourstring .= str_repeat('1', $bitend-$bitstart);
                        }
                        $remainder = $totalHourStringLength-strlen($hourstring);
                        $hourstring .= str_repeat('0', $remainder);
                        $openinghours->hours = $hourstring;
                        $openinghours->save();
                    }
                }
                return new Response('openingHours added.',201);
            } catch(Exception $ex){
                return new Response('We could not add the openinghours.',500);
            }
        } else {
            return new Response('No timeframes received.',400);
        }
    }
}
