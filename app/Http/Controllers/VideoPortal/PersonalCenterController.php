<?php

namespace App\Http\Controllers\VideoPortal;


use App\Http\Controllers\Controller;

class PersonalCenterController extends Controller
{
    public function index(){
        return view('VideoSystem.personalcenter');
    }
}
