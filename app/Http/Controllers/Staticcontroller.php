<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class Staticcontroller extends Controller
{
    public function PrivacyPolicy(){
        return view('static.privacy-policy');
    }

    public function TermsOfService(){
        return view('static.terms-of-service');
    }

   
    
}
