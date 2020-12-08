<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class GHTKControler extends Controller
{
    //
    public function fee(Request $request){
        return view("ghtk");
    }
}
