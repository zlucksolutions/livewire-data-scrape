<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;

class LivewireController extends Controller
{
    public function index()
    {
        Artisan::call("Url:Crawl",["url" => "https://datatables.net/examples/data_sources/dom"]);
        
        return redirect()->to('/product');
        // return view('welcome');
    }

    public function scrape()
    {
        return view('scrape');
    }
}
