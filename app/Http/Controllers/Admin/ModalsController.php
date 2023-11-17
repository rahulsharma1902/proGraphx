<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Brand;
use App\Models\Graphics;
use App\Models\Colors;
use App\Models\Modals;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;
class ModalsController extends Controller
{
    public function addModal(){
        $brands = Brand::all();
        $graphics = Graphics::all();
        return view('admin.modals.addModals',compact('brands','graphics'));
    }
    public function addModalProcc(Request $request){
        $request->validate([
            'name' => 'required|unique:graphics',
            'slug' => 'required|unique:graphics',
            'brand' => 'required',
            'available_graphics' => 'required',
            'description' => 'required',
            'side_image' => 'required|file|mimes:svg',
            'front_image' => 'required|file|mimes:svg',
            'top_image' => 'required|file|mimes:svg',
        ]);
    
        $modals = new Modals;
        $modals->name = $request->name;
        $modals->slug = $request->slug;
        $modals->brand = json_encode($request->brand);
        $modals->available_graphics = json_encode($request->available_graphics);
        $modals->description = $request->description;
    
        if ($request->hasFile('side_image')) {
            $imageNames = $this->uploadImages($request, 'side_image');
            $modals->side_image = $imageNames;
        } else {
            return redirect()->back()->with('error', 'Failed to find image.');
        }
        if ($request->hasFile('top_image')) {
            $imageNames = $this->uploadImages($request, 'top_image');
            $modals->top_image = $imageNames;
        } else {
            return redirect()->back()->with('error', 'Failed to find image.');
        }
        if ($request->hasFile('front_image')) {
            $imageNames = $this->uploadImages($request, 'front_image');
            $modals->front_image = $imageNames;
        } else {
            return redirect()->back()->with('error', 'Failed to find image.');
        }
    
        $modals->save();
        return redirect('admin-dashboard/add-modal/'.$request->slug)->with('success', 'Your Graphics has been added.');

    }

    public function addModalBodyPart($slug){
        if($slug){
            $modal = Modals::where('slug',$slug)->where('status',0)->first();
            $colors = Colors::all();
            $brands = Brand::all();
            $graphics = Graphics::all();
            if($modal){
                return view('admin.modals.addModalBodyPart',compact('modal','colors','brands','graphics'));
            }
        }
        return redirect()->back()->with('error','Failed to Find your Model..');
    }



    
    public function uploadImages($request,$variable){
        if($request->hasFile($variable)){
            $file = $request->file($variable);
            $filename = $request->slug.rand(0,100).'.'.$file->extension();
            $file->move(public_path().'/modals_images/', $filename);
            return $filename;  
        }
        return null;
    }

    public function addModalBodyPartProcc(Request $request){
        print_r($request->all());
        echo '<pre>';
    }
}

