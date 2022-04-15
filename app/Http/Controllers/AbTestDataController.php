<?php

namespace App\Http\Controllers;

use App\Models\AbTestData;
use Illuminate\Http\Request;

class  AbTestDataController extends Controller
{
    public function testMethod() {
        foreach(AbTestData::query()->select()->get() as $item) {
            echo $item->id . ", " . $item->ab_testname . "<br>";
        }
    }
}
