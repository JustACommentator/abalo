<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AbaloController extends Controller
{
    public function search() {

        $results = array();
        return view('searchView', ["search" => $_GET['search']??Null, "results" => $results]);
    }
}
