<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Menu;
use Illuminate\Http\Request;

class MenuController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $menus = Menu::paginate(5);
       return view('management.menu.index' , compact('menus'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        $categories = Category::all();
        return view('management.menu.create' ,compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:menus|max:255',
            'description' => 'required',
            'price' => 'required|numeric',
            'category' => 'required|numeric'
        ]);
       $imgName = 'no-image.png';
        if ($request->hasFile('img')) {
            $request->validate([
                'img' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            ]);
            $image = $request->file('img');
            $imgName = time().'.'.$image->getClientOriginalExtension();
            $destinationPath = public_path('/menueImages');
            $image->move($destinationPath, $imgName);
        }

        Menu::create([
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'image' => $imgName,
            'category_id' => $request->category
        ]);
        return redirect()->route('menu.index')->with('success',$request->name . ' is added successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $menu = Menu::findOrFail($id);
        $categories = Category::all();
        return view('management.menu.edit' , compact('menu' , 'categories'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
       $request->validate([
            'name' => 'required|max:255',
            'description' => 'required',
            'price' => 'required|numeric',
            'category' => 'required|numeric'
       ]);

         $menu = Menu::findOrFail($id);

         //validate image
       if ($request->hasFile('img')) {
            $request->validate([
                'img' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            ]);
            if ($menu->image != 'no-image.png') {
                unlink(public_path('menueImages/'.$menu->image));
            }
            $image = $request->file('img');
            $imgName = time().'.'.$image->getClientOriginalExtension();
            $destinationPath = public_path('/menueImages');
            $image->move($destinationPath, $imgName);
            //save image name in database
            $menu->image = $imgName;
       }
        $menu->name = $request->name;
        $menu->description = $request->description;
        $menu->price = $request->price;
        $menu->category_id = $request->category;
        $menu->save();
        return redirect()->route('menu.index')->with('success',$request->name . ' is updated successfully');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
         Menu::findOrFail($id)->delete();
        return redirect()->route('menu.index')->with('success','Menu is deleted successfully');
    }
}
