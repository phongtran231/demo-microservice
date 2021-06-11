<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;

class HomeController extends Controller
{
    public function getProductList()
    {
        $products = Http::send('GET', config('app.product_url') . "/product/list");
        return $products->json();
    }
}
