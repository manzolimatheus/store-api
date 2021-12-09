<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tag;

class TagController extends Controller
{
    public $key;

    function __construct()
    {
        $this->key = "laravel";
    }

    public function get($key)
    {

        switch ($key) {
            case $this->key:
                $tags = Tag::all();

                return response()->json($tags);
                break;

            default:
                return response()->json('Acesso negado!');
                break;
        }
    }
}
