<?php

namespace App\Console\Commands;

use App\Product;
use App\Events\ProductReceived;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Symfony\Component\Panther\Client;
use Symfony\Component\Panther\DomCrawler\Crawler;

class CrawUrlCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'Url:Crawl {url}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Crawl url using panther';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $url = $this->argument('url');

        $_SERVER['PANTHER_NO_HEADLESS'] = false;
        $_SERVER['PANTHER_NO_SANDBOX'] = true;
        // $_SERVER['PANTHER_CHROME_ARGUMENTS'] = false;
        // $_SERVER['PANTHER_DEVTOOLS'] = true;

        try {

            // $client = Client::createChromeClient(base_path("drivers/chromedriver"), null, ["port" => 9558]);
            // $this->info("Start processing");
            // $client->request('GET', $url);
            // dd($client);
            // $client2 = $client;
            // $crawler = $client2->waitForVisibility('#page_general_wrapper');//.fs-overbought-app-wrapper
            // $client2->waitFor('.page_general_wrapper')->filter('.fs-overbought-zarovnanie-stran > div.fs-overbought-tlaciktkoveinputy')->each(function(Crawler $firstCrawler, $k) use ($client) {
            //     $second = $client->waitFor('.fs-overbought-app-wrapper');

            //     dd($firstCrawler->getText());
            // });
            // dd($crawler);
            // $crawler->filter('app-root')->each(function(Crawler $firstCrawler, $k) {
            //     dd($firstCrawler->filter('table')->text());
            // });
            Product::truncate();
            // dd(base_path("drivers/chromedriver"));
            $client = Client::createChromeClient(base_path("drivers/chromedriver"), null, ["port" => 9558]);
            // $this->info("Start processing");
            $client->request('GET', $url);
            // dd($client);
            $client2 = $client;
            $crawler = $client2->waitFor('.demo-html');
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
                    $this->info("Item retrieved and saved");
                });
            });
            $client->quit();
        } catch (\Exception $ex) {
            $this->error("Error: " . $ex->getMessage());
            Log::error($ex->getMessage());
        } finally {
            $this->info("Finished processing");
            $client->quit();
        }
    }
}
