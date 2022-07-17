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
                    ],
                    [
                        'id' => uniqid(),
                        'text' => 'Predikat',
                        'title' => 'Predikat',
                        'url' => 'predikat',
                    ],
                ],
            ],
            [
                'id' => uniqid(),
                'text' => 'Lke',
                'title' => 'Lke',
                'url' => null,
                'children' => [
                    [
                        'id' => uniqid(),
                        'text' => 'List',
                        'title' => 'List',
                        'url' => 'lke',
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
