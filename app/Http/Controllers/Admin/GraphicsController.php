<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use App\Models\Graphics;

class GraphicsController extends Controller
{
    public function addGraphic(){
        return view('admin.graphics.addGraphics');
    }
    public function addGraphicProcc(Request $request){
        $request->validate([
            'name' => 'required|unique:graphics',
            'slug' => 'required|unique:graphics',
            'material' => 'required',
        ]);
        $graphics = new Graphics;
        $graphics->name = $request->name;
        $graphics->slug = $request->slug;
        $graphics->material = $request->material;
        $graphics->save();
        return redirect()->back()->with('success','Your Graphics has been added.');
    }
}
