<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use App\Models\Brand;
class BrandsController extends Controller
{
    public function index(){
        $brands = Brand::all();
        return view('admin.brands.index',compact('brands'));
    }
    public function addBrand(){
        return view('admin.brands.addBrands');
    }
    public function addBrandProcc(Request $request){
        $request->validate([
            'name' => 'required|unique:brands',
            'slug' => 'required|unique:brands',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
        $brand = new Brand;
        $brand->name = $request->name;
        $brand->slug = $request->slug;
        if($request->hasFile('image')){
            $file = $request->file('image');
            $filename = $request->title.rand(0,100).'.'.$file->extension();
            $file->move(public_path().'/brands_images/', $filename);
            $brand->image = $filename;  
        }else{
            return redirect()->back()->with('error','Failed to find image.');
        }
 
        $brand->save();
        return redirect()->back()->with('success','Your Brand has been added.');
    }

    public function updateBrand($slug){
        if($slug){
            $brand = Brand::where('slug',$slug)->first();
            if($brand){
                return view('admin.brands.updateBrand',compact('brand'));
            }
            return redirect()->back()->with('error','Invalid brand.');
        }
    }
    public function updateBrandProcc(Request $request){
        if($request->id){
            $request->validate([
                'name' => 'required|unique:brands,name,'.$request->id,
                'slug' => 'required|unique:brands,slug,'.$request->id,
            ]);
            
            $brand = Brand::where('id',$request->id)->first();
            if($brand){
                $brand->name = $request->name;
                $brand->slug = $request->slug;
                if($request->hasFile('image')){
                    $file = $request->file('image');
                    $filename = $request->title.rand(0,100).'.'.$file->extension();
                    $file->move(public_path().'/brands_images/', $filename);
                    $brand->image = $filename;  
                }
        
                $brand->save();
                return redirect('admin-dashboard/brand-edit/'.$brand->slug)->with('success','successfully updated your brand');

            }
        }else{
            return redirect()->back()->with('error','Ooops, failed to find your Brand...');
        }
    }

    public function removeBrand(Request $request, $slug){
        if ($slug) {
            $brand = Brand::where('slug', $slug)->first();
            if ($brand) {
                
                $image_path = public_path('brands_images/' . $brand->image);
                if (File::exists($image_path)) {
                    File::delete($image_path);
                }
                $brand->delete();
                
                return redirect()->back()->with('success', 'Brand has been removed');
            } else {
                return redirect()->back()->with('error', 'Invalid Request.');
            }
        }
    }
    
}
