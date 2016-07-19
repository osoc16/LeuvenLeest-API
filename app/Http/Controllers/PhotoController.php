<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Place;
use App\Photo;
use Auth;

class PhotoController extends Controller
{
    public function uploadPhoto($id, Request $request){
        try{
            $this->validate($request, [
                'photo' => 'required|image',
            ]);

            $place = Place::find($id);
            $destinationPath = 'pictures';
            $file = $request->file('photo');
            if($file->isValid()){
            	$lastUploaded = Photo::where('placeId',$place->id)->orderBy('id','desc')->first();
            	$picNumber = $lastUploaded ? $lastUploaded->id : 0;
            	$picNumber++;
                $filename = $place->name.'_'.$picNumber.'.'.$file->getClientOriginalExtension();
                $filename = str_replace(' ','_',$filename);
                $file->move($destinationPath, $filename);
                $photo = new Photo();
                $photo->name = $filename;
                $photo->placeId = $id;
                $photo->userId = 1;//Auth::user()->id;
                $photo->save();
            }
            return 'Succesfully uploaded';
        } catch (Exception $ex){
            Log::error($ex);
            return new Response('Couldn\'t upload the picture.',500);
        }
    }
}
