<?php

namespace App\Http\Controllers;

use App\Http\Resources\CategoryCollection;
use App\Models\Category;

class CategoryController extends Controller
{
    // Return categories collection
    public function index()
    {
        return new CategoryCollection(Category::all());

        // return response()->json(['categories' => Category::all()]);
    }
}
