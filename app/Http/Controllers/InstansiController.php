<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class InstansiController extends Controller
{
    //
    const FOLDER = 'pages.instansi.';

    public function satker()
    {
        return view(self::FOLDER . 'satker.main');
    }
}
