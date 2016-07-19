<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

class PhotoController extends Controller
{
    public function uploadPhoto($id, Request $request){
        try{
            $place = Place::find($id);
            $destinationPath = 'pictures';
            $file = $request->file('photo');
            if($file->isValid()){
                $pictureCount = $place->photos()->count();
                $pictureCount++;
                $filename = $place->name.'_'.$pictureCount.'.'.$file->getClientOriginalExtension();
                $file->move($destinationPath, $filename);
                $photo = new Photo();
                $photo->name = $filename;
                $photo->placeId = $id;
                $photo->userId = Auth::user()->id;
                $photo->save();
            }
            return 'Succesfully uploaded';
        } catch (Exception $ex){
            Log::error($ex);
            return 'Couldn\'t upload the picture.';
        }
    }
}
