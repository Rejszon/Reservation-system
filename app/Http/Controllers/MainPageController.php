<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MainPageController extends Controller
{
    public function getIndex(){
        
        return view('main_pages.index');
    }

    public function getServices(){
        
        return view('main_pages.services');
    }

    public function getContact(){
        
        return view('main_pages.contact');
    }
}
