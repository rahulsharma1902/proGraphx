<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Brand;
use App\Models\Graphics;
use App\Models\Colors;
use App\Models\Modals;
use App\Models\BodyParts;
use App\Models\Accent;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class ModalsController extends Controller
{
    public function index(Request $request){
        $modals = Modals::all();
        return view('admin.modals.index',compact('modals'));
    }
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
        return redirect('admin-dashboard/add-model/'.$request->slug)->with('success', 'Your Graphics has been added.');

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

    // public function addModalBodyPartProcc(Request $request)
    // {
    //     //  echo '<pre>';
    //     // print_r($request->all());
    //     // die();
    //     if ($request->has('updatedSVG') || $request->has('model_id')) {
    //         $svgContent = $request->input('updatedSVG');
    //         if (is_string($svgContent)) {
    //             $filename = 'svg_' . uniqid() . '.svg';
    //             file_put_contents(public_path().'/modals_images/'.$filename, $svgContent);
    //             $model = Modals::where('id', $request->model_id)->update(['updatedImage' => $filename]);
    //         } else {
    //             return redirect()->back()->with('error','Invalid SVG content');
    //         }
    //     } else {
    //         return redirect()->back()->with('error','No SVG content provided');
    //     }
        
    //     // die();
    //     // $Accentkey = 1;
    //     foreach ($request->brandTitle as $brandKey => $brandTitle) {
    //         $bodyPart = new BodyParts;
    //         $bodyPart->model_id = $request->model_id;
    //         $bodyPart->name = $brandTitle;
    //         $bodyPart->slug = $request->slug[$brandKey];
    
    //         if ($request->hasFile('brandImage.' . $brandKey)) {
    //             $file = $request->file('brandImage.' . $brandKey);
    //             $filename = $bodyPart->slug . rand(0, 100) . '.' . $file->extension();
    //             $file->move(public_path().'/modals_images/', $filename);
    //             $bodyPart->partImage = $filename;
    //         }
    //         $bodyPart->save();
    
    //         if (isset($request->accentTitle[$bodyPart->slug]) && is_array($request->accentTitle[$bodyPart->slug])) {
    //             foreach ($request->accentTitle[$bodyPart->slug] as $key => $accentTitle) {
    //                 $accent = new Accent;
    //                 $accent->name = $accentTitle;
    //                 $accent->slug = strtolower(str_replace(' ', '', $accentTitle));
    //                 $accent->body_part_id = $bodyPart->id;
    
    //                 // Initialize $brandsData as an empty array before the loop
    //                 $brandsData = [];
    
    //                 // Update $brandArrayKey
    //                 // $brandArrayKey = $brandTitle . $Accentkey;
    //                 $brandArrayKey = $brandTitle;
    
    //                 if (isset($request->brand[$brandArrayKey]) && is_array($request->brand[$brandArrayKey])) {
    //                     foreach ($request->brand[$brandArrayKey] as $brandData) {
    //                         // Update $brandsData[] = $brandData;
    //                         $brandsData[] = $brandData;
    //                     }
    //                 }
    //                 // echo  $Accentkey;
    //                 // echo $accentTitle;
    //                 // print_r($brandsData);
    //                 $accent->colors = json_encode($brandsData);
    
    //                 $accent->save();
    //             }
    //         }
    
    //     }
    //     $model = Modals::where('id', $request->model_id)->update(['status' => 1]);
    //     return redirect()->back()->with('success', 'Your Model has been created.');
    // }

    public function addModalBodyPartProcc(Request $request)
    {
        echo '<pre>';
        print_r($request->all());
        die();
        try {
            if ($request->has('updatedSVG') && $request->has('model_id')) {
                $svgContent = $request->input('updatedSVG');

                if (is_string($svgContent)) {
                    $filename = 'svg_' . uniqid() . '.svg';
                    file_put_contents(public_path('/modals_images/') . $filename, $svgContent);

                    Modals::where('id', $request->model_id)->update(['updatedImage' => $filename]);
                } else {
                    return redirect()->back()->with('error', 'Invalid SVG content');
                }
            } else {
                return redirect()->back()->with('error', 'No SVG content provided');
            }

            foreach ($request->brandTitle as $brandKey => $brandTitle) {
                $bodyPart = new BodyParts;
                $bodyPart->model_id = $request->model_id;
                $bodyPart->name = $brandTitle;
                $bodyPart->slug = $request->slug[$brandKey];

                if ($request->hasFile('brandImage.' . $brandKey)) {
                    $file = $request->file('brandImage.' . $brandKey);
                    $filename = $bodyPart->slug . '_' . uniqid() . '.' . $file->extension();
                    $file->move(public_path('/modals_images/'), $filename);
                    $bodyPart->partImage = $filename;
                }

                $bodyPart->save();

                if (isset($request->accentTitle[$bodyPart->slug]) && is_array($request->accentTitle[$bodyPart->slug])) {
                    foreach ($request->accentTitle[$bodyPart->slug] as $key => $accentTitle) {
                        $accent = new Accent;
                        $accent->name = $accentTitle;
                        $accent->slug = strtolower(str_replace(' ', '', $accentTitle));
                        $accent->body_part_id = $bodyPart->id;

                        $brandsData = [];

                        $brandArrayKey = $brandTitle;
                        // Here is a problem :: Failed to add data in color in array because of undefined array key .
                        // $brandArrayKey = $accent->slug;

                        if (isset($request->brand[$brandArrayKey]) && is_array($request->brand[$brandArrayKey])) {
                            foreach ($request->brand[$brandArrayKey] as $brandData) {
                                $brandsData[] = $brandData;
                            }
                        }

                        $accent->colors = json_encode($brandsData);

                        $accent->save();
                    }
                }
            }

            Modals::where('id', $request->model_id)->update(['status' => 1]);

            return redirect('admin-dashboard/models')->with('success', 'Your Model has been created.');
        } catch (\Exception $e) {
            Log::error('Error in addModalBodyPartProcc: ' . $e->getMessage());
            return redirect()->back()->with('error', 'An unexpected error occurred.');
        }
    }

    
    public function viewModel(Request $request,$slug){
        if($slug){
            $model = Modals::where('slug',$slug)->first();
            // $model = Modals::where('slug',$slug)->with('bodyParts','bodyParts.accents')->first()->toArray();
            if($model){
                // echo '<pre>';
                // print_r($model);
                // die();
                return view('admin.modals.viewModel',compact('model'));;
            }
        }
        return abort(404);
    }


}

