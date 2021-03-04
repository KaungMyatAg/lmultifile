<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Gallery;

class GalleryController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth','verified']);
    }
    public function index()
    {
        $galleries = Gallery::all();
        return view('index',['galleries'=>$galleries]);
    }
    public function show($id)
    {
        $gallery = Gallery::findOrFail($id);
        return Storage::download("images/" . $gallery->name);
    }
    public function store(Request $request)
    {
        $request->validate([
            'image' => 'required',
            'image.*' => 'image | mimes:jpg,jpeg,png,svg',
        ]);
        if($request->hasFile('image'))
        {
            foreach($request->file('image') as $image)
            {
                $fileName = time(). '_' . $image->getClientOriginalName();
                $uploaded = $image->storeAs('images',$fileName);
                $gallery = new Gallery();
                $gallery->name = $fileName;
                $gallery->save();
            }
        }
        return redirect('home')->with('Success','Created Successfully!');
    }
    public function destroy($id)
    {
        $gallery = Gallery::findOrFail($id);
        Storage::delete("images/" . $gallery->name);
        $gallery->delete();
        return redirect('home')->with('Success','Deleted Successfully!');
    }
}
