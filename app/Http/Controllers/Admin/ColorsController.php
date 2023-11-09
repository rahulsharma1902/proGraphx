<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use App\Models\Colors;
class ColorsController extends Controller
{
    public function index(){
        $colors = Colors::all();
        return view('admin.colors.index',compact('colors'));
    }
    public function addColor(){
        return view('admin.colors.addColors');
    }
    public function addColorProcc(Request $request){
        $request->validate([
            'name' => 'required|unique:colors',
            'slug' => 'required|unique:colors',
            'color_code' => 'required',
        ]);
        $color = new Colors;
        $color->name = $request->name;
        $color->slug = $request->slug;
        $color->color_code = $request->color_code;
        $color->save();
        return redirect()->back()->with('success','Your Color has been added.');
    }
    public function updateColor($slug){
        if($slug){
            $color = Colors::where('slug',$slug)->first();
            if($color){
                return view('admin.colors.updateColor',compact('color'));
            }
            return redirect()->back()->with('error','Invalid color.');
        }
    }
    public function updateColorProcc(Request $request){
        if($request->id){
            $request->validate([
                'name' => 'required|unique:colors,name,'.$request->id,
                'slug' => 'required|unique:colors,slug,'.$request->id,
                'color_code' => 'required',
            ]);
            
            $color = Colors::where('id',$request->id)->first();
            if($color){
                $color->name = $request->name;
                $color->slug = $request->slug;
                $color->color_code = $request->color_code;
                
                $color->save();
                return redirect('admin-dashboard/color-edit/'.$color->slug)->with('success','successfully updated your Color');

            }
        }else{
            return redirect()->back()->with('error','Ooops, failed to find your Color...');
        }
    }

    public function removeColor(Request $request, $slug){
        if ($slug) {
            $color = Colors::where('slug', $slug)->first();
            if ($color) {
                $color->delete();
                return redirect()->back()->with('success', 'Color has been removed');
            } else {
                return redirect()->back()->with('error', 'Invalid Request.');
            }
        }
    }
}
