<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class StaticController extends Controller
{
    public function privacyPolicy(){
        return view('static.privacy-policy');
    }

    public function termsOfService(){
        return view('static.terms-of-service');
    }

   
    
}
