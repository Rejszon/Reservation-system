<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MainPageController extends Controller
{
    public function getIndex(){
        
        return view('main_pages.index');
    }
}
