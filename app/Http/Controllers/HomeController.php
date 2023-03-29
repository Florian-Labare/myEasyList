<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\ShoppingList;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function home(){
        $categories = Category::all();
        $lists = ShoppingList::all();

        return view('home', [
            'categories' => $categories,
            'lists' => $lists
        ]);
    }
}
