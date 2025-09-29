<?php

namespace App\Http\Controllers\Cliente;

use App\Http\Controllers\Controller;

class HomeController extends Controller
{
    public function inicio()
    {
        return view('cliente.home');
    }
}
