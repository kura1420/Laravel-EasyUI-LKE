<?php

namespace App\Http\Controllers\Rest;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AppController extends Controller
{
    //
    public function menu()
    {
        $rows = [
            [
                'id' => uniqid(),
                'text' => 'Master',
                'title' => 'Master',
                'url' => null,
                'children' => [
                    [
                        'id' => uniqid(),
                        'text' => 'Satker',
                        'title' => 'Satker',
                        'url' => 'satker',
                    ]
                ],
            ],
            [
                'id' => uniqid(),
                'text' => 'Setting',
                'title' => 'Setting',
                'url' => null,
                'children' => [
                    [
                        'id' => uniqid(),
                        'text' => 'User',
                        'title' => 'User',
                        'url' => 'user',
                    ]
                ],
            ],
        ];

        return response()->json($rows, 200);
    }
}