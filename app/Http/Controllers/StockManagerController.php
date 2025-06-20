<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class StockManagerController extends Controller
{
    public function index()
    {
        return view("stock.index");
    }
}
