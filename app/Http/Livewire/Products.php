<?php

namespace App\Http\Livewire;

use Exception;
use App\Product;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Log;
use Symfony\Component\Panther\Client;
use Symfony\Component\Panther\DomCrawler\Crawler;

class Products extends Component
{
    use WithPagination;

    // public $products = [];
    // public $readyToLoad = false;

    // protected $listeners = ['fetchStock' => 'fetch'];
    // protected $listeners = ['refreshProducts'];

    public function render()
    {
        // $_SERVER['PANTHER_NO_HEADLESS'] = false;
        // $_SERVER['PANTHER_NO_SANDBOX'] = true;
        
        // try {
        //     $url = 'https://datatables.net/examples/data_sources/dom';
        //     $client = Client::createChromeClient(base_path("drivers/chromedriver"), null, ["port" => 9558]);
        //     Log::info("Start processing");
        //     $client->request('GET', $url);
        //     $client->waitFor('.demo-html')->filter('.dataTables_wrapper > #example_paginate > span > a')->each(function(Crawler $firstCrawler, $k) use ($client) {
        //         $client->clickLink($k+1);
        //         $second = $client->waitFor('.demo-html');
        //         $second->filter('.dataTables_wrapper > #example > tbody > tr')->each(function (Crawler $parentCrawler, $i) {
        //             $product = new Product();
        //             $parentCrawler->filter('.dataTables_wrapper > #example > tbody > tr > td')->each(function (Crawler $child, $j) use ($product) {
                        
        //                 if($j == 0) {
        //                     $product->name = $child->text(); 
        //                 } else if($j == 1) {
        //                     $product->position = $child->text(); 
        //                 } else if ($j == 2) {
        //                     $product->office = $child->text(); 
        //                 } else if ($j == 3) {
        //                     $product->age = $child->text(); 
        //                 } else if($j == 4) {
        //                     $product->start_date = $child->text(); 
        //                 } else if ($j == 5) {
        //                     $product->salary = $child->text(); 
        //                 }
        //             });
        //             $product->save();
        //             Log::info("Item retrieved and saved");
        //         });
        //     });
        //     $client->quit();
        //     // Log::debug($client);
        // } catch (Exception $th) {
        //     Log::error($th->getMessage());
        //     // $this->error($th->getMessage());
        // } finally {
        //     // $this->info("Finished Received");
        //     Log::info("Finished Received");
        // }
        return view('livewire.products',[
            'products' => Product::orderBy("id","ASC")->paginate(10)
        ]);
    }
}
