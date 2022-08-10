<?php

namespace App\Http\Livewire;

use App\Product;
use Livewire\Component;
use Livewire\WithPagination;
use App\Events\ProductReceived;
use Illuminate\Support\Facades\Log;
use Symfony\Component\Panther\Client;
use Illuminate\Support\Facades\Artisan;
use Symfony\Component\Panther\DomCrawler\Crawler;

class ScraperForm extends Component
{
    use WithPagination;
    
    public $url;
    public $startScrape = false;
    
    protected $paginationTheme = 'bootstrap';
    protected $rules = [
        'url' => 'required|url'
    ];
    protected $listeners = ['ProductReceived' => 'onProductFetch'];

    // public function mount() {
    //     $this->products = Product::all();
    // }

    public function scrape()
    {
        $this->validate();
        try {
            // Artisan::queue("Url:Crawl", ["url" => $this->url])
            //     ->onConnection('database')->onQueue('processing');
            // Artisan::call("Url:Crawl",["url" => "https://datatables.net/examples/data_sources/dom"]);
            // $this->url = "";
            Product::truncate();
            $url = 'https://datatables.net/examples/data_sources/dom';
            $client = Client::createChromeClient(base_path("drivers/chromedriver"), null, ["port" => 9558]);
            Log::info("Start processing");
            $client->request('GET', $url);
            $client->waitFor('.demo-html')->filter('.dataTables_wrapper > #example_paginate > span > a')->each(function(Crawler $firstCrawler, $k) use ($client) {
                $client->clickLink($k+1);
                $second = $client->waitFor('.demo-html');
                $second->filter('.dataTables_wrapper > #example > tbody > tr')->each(function (Crawler $parentCrawler, $i) {
                    $product = new Product();
                    $parentCrawler->filter('.dataTables_wrapper > #example > tbody > tr > td')->each(function (Crawler $child, $j) use ($product) {
                        
                        if($j == 0) {
                            $product->name = $child->text(); 
                        } else if($j == 1) {
                            $product->position = $child->text(); 
                        } else if ($j == 2) {
                            $product->office = $child->text(); 
                        } else if ($j == 3) {
                            $product->age = $child->text(); 
                        } else if($j == 4) {
                            $product->start_date = $child->text(); 
                        } else if ($j == 5) {
                            $product->salary = $child->text(); 
                        }
                    });
                    $product->save();
                    Log::info("Item retrieved and saved");
                    ProductReceived::dispatch($product);
                });
            });
            $client->quit();
            $this->startScrape = true;
            session()->flash("success", "Url Added Successfully to queue and it will be processed shortly!");
            // return redirect()->to('/product');
            // $data['product'] = Product::paginate(10);
            // array_unshift($this->products, $data['product']);
        } catch (\Exception $ex) {
            Log::error($ex->getMessage());
        } finally {
            Log::info("Finish Crawling");
        }
    }
    
    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function onProductFetch()
    {
        $this->resetPage();
    }

    public function render()
    {
        return view('livewire.scraper-form',[
            'products' => Product::orderBy('id','DESC')->paginate(10)
        ]);
    }
}
