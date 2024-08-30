<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{
    public function store(Request $request){
        $validator = Validator::make($request->all(), [             //Validates the request data to ensure 'name' and 'desc' fields are present.
            'name' => 'required',
            'desc' => 'required',
        ]);                             
        if ($validator->fails()) {
            return response()->json(                                //Return error response once the validator fails
                $validator->errors(),
                422
            );
        }           
        $category = Category::create([
            'name' => $request->name,                               //Creates a new Category instance and saves it to the database using Eloquent's create method.
            'desc' => $request->desc,
        ]);         
        return response()->json(['kategori' => $category]);
    }
    public function create() {

    }
    public function show(Category $category)
    {
        return response()->json(['kategori' => $category]);
    }
    public function edit(Category $category)
    {
        return response()->json(['kategori' => $category]);
    }
    public function update(Request $request, Category $category){
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'desc' => 'required',
        ]); //Validates the request data to ensure 'name' and 'desc' fields are present.
        if ($validator->fails()) {
            return response()->json(
                $validator->errors(),
                422
            );
        } //Return error response once the validator fails
        $category = new Category([
            'name' => $request->name,
            'desc' => $request->desc,
        ]); //Creates a new Category instance with data from the current request.
        $category->save();
        return response()->json(['kategori' => $category]);
    }
    public function delete(Category $category){
        if($category){
            $category->delete();
            return response()->json(['message' => 'Kategori berhasil dihapus']);
        } else {
            return response()->json(['error'=> 'Produk tidak ditemukan'], 404);
        }
    }
}
