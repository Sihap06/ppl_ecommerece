<?php

namespace App\Http\Controllers;

use App\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function ajaxSearch(Request $request){
        $keyword = $request->get('q');
        $categories = \App\Category::where("name", "LIKE", "%$keyword%")->get();
        return $categories;
    }
    
    /**
    * Display a listing of the resource.
    *
    * @return \Illuminate\Http\Response
    */
    public function index()
    {
        return view('admin.categories.index')->with('categories', Category::all());
    }
    
    /**
    * Show the form for creating a new resource.
    *
    * @return \Illuminate\Http\Response
    */
    public function create()
    {
        return view('admin.categories.create');
    }
    
    /**
    * Store a newly created resource in storage.
    *
    * @param  \Illuminate\Http\Request  $request
    * @return \Illuminate\Http\Response
    */
    public function store(Request $request)
    {
        $validation = \Validator::make($request->all(),[
            'name'      => 'required'
        ])->validate();

        $new_category = new \App\Category;
        
        $new_category->name = $request->get('name');
        $new_category->slug = str_slug($request->get('name'), '-');
        $new_category->created_by = \Auth::user()->name;
        
        $new_category->save();
        
        return redirect('/categories')->with('success', 'Category successfully created');
    }
    
    /**
    * Display the specified resource.
    *
    * @param  \App\Category  $category
    * @return \Illuminate\Http\Response
    */
    public function show(Category $category)
    {
        //
    }
    
    /**
    * Show the form for editing the specified resource.
    *
    * @param  \App\Category  $category
    * @return \Illuminate\Http\Response
    */
    public function edit(Category $category)
    {
        return view('admin.categories.edit', compact('category'));
    }
    
    /**
    * Update the specified resource in storage.
    *
    * @param  \Illuminate\Http\Request  $request
    * @param  \App\Category  $category
    * @return \Illuminate\Http\Response
    */
    public function update(Request $request, Category $category)
    {
        $validation = \Validator::make($request->all(),[
            'name'      => 'required'
        ])->validate();

        Category::where('id', $category->id)->update([
            'name' => $request->name,
            'updated_by' => \Auth::user()->name
            ]);
            
            return redirect('/categories')->with('success', 'Category Successfully Upadte');
            
    }
        
    /**
    * Remove the specified resource from storage.
    *
    * @param  \App\Category  $category
    * @return \Illuminate\Http\Response
    */
    public function destroy(Category $category)
    {
        Category::destroy($category->id);
        return redirect('/categories')->with('success', 'Category Succesfully Deleted');
    }
}
    