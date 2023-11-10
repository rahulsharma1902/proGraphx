<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    // public function uploadImage($request,$folderName){
    //     if($request->hasFile('image')){
    //         $file = $request->file('image');
    //         $filename = $request->title.rand(0,100).'.'.$file->extension();
    //         $file->move(public_path().'/'.$folderName.'/', $filename);
    //         return $filename;  
    //     }
    // }
}
