<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LkeController extends Controller
{
    //
    const FOLDER = 'pages.lke.';

    public function index()
    {
        return view(self::FOLDER . 'index.main');
    }

    public function predikat()
    {
        return view(self::FOLDER . 'predikat.main');
    }

    public function setting()
    {
        return view(self::FOLDER . 'setting.main');
    }

    public function pengusulan()
    {
        return view(self::FOLDER . 'pengusulan.main');
    }

    public function pengisian()
    {
        return view(self::FOLDER . 'pengisian.main');
    }
}
