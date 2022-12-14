<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PostbackController extends Controller
{
    public function postback(Request $request)
    {
        //TODO::implement postback validation and update data in db
        file_put_contents(storage_path('postback.txt'), json_encode($request->all()));
    }
}
