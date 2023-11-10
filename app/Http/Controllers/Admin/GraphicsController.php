<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use App\Models\Graphics;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;
class GraphicsController extends Controller
{
    public function index(){
        $graphics = Graphics::all();
        return view('admin.graphics.index',compact('graphics'));
    }
    public function addGraphic(){
        return view('admin.graphics.addGraphics');
    }
    public function addGraphicProcc(Request $request){
        $request->validate([
            'name' => 'required|unique:graphics',
            'slug' => 'required|unique:graphics',
            'material' => 'required',
            'image' => 'required',
        ]);
        $graphics = new Graphics;
        $graphics->name = $request->name;
        $graphics->slug = $request->slug;
        $graphics->material = $request->material;
        if($request->hasFile('image')){
            $file = $request->file('image');
            $filename = $request->name.rand(0,100).'.'.$file->extension();
            $file->move(public_path().'/graphics_images/', $filename);
            $graphics->image = $filename;  
        }else{
            return redirect()->back()->with('error','Failed to find image.');
        }
 
        $graphics->save();
        return redirect()->back()->with('success','Your Graphics has been added.');
    }
    public function updateGraphic($slug){
        if($slug){
            $graphic = Graphics::where('slug',$slug)->first();
            if($graphic){
                return view('admin.graphics.updateGraphic',compact('graphic'));
            }
            return redirect()->back()->with('error','Invalid graphic.');
        }
    }

    public function updateGraphicProcc(Request $request){
        if($request->id){
            $request->validate([
                'name' => 'required|unique:graphics,name,'.$request->id,
                'slug' => 'required|unique:graphics,slug,'.$request->id,
            ]);
            
            $graphic = Graphics::where('id',$request->id)->first();
            if($graphic){
                $graphic->name = $request->name;
                $graphic->slug = $request->slug;
                if($request->hasFile('image')){
                    $file = $request->file('image');
                    $filename = $request->title.rand(0,100).'.'.$file->extension();
                    $file->move(public_path().'/graphics_images/', $filename);
                    $graphic->image = $filename;  
                }
                $graphic->material = $request->material;
        
                $graphic->save();
                return redirect('admin-dashboard/graphic-edit/'.$graphic->slug)->with('success','successfully updated your graphic');

            }
        }else{
            return redirect()->back()->with('error','Ooops, failed to find your Graphic...');
        }
    }

    public function removeGraphic(Request $request, $slug){
        if ($slug) {
            $graphic = Graphics::where('slug', $slug)->first();
            if ($graphic) {
                
                $image_path = public_path('graphics_images/' . $graphic->image);
                if (File::exists($image_path)) {
                    File::delete($image_path);
                }
                $graphic->delete();
                
                return redirect()->back()->with('success', 'Graphic has been removed');
            } else {
                return redirect()->back()->with('error', 'Invalid Request.');
            }
        }
    }
}
