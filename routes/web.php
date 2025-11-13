<?php

use App\Models\Product;
use Illuminate\Support\Facades\Route;
use App\Services\ProductSearchService;

Route::get('/', function () {
    return view('welcome');
});



//Elastic Search
Route::get('/test-es', function (ProductSearchService $es) {
    return response()->json($es->allProducts()->asArray());
});

Route::get('/search/{keyword}', function ($keyword, ProductSearchService $es) {
    //   return response()->json($es->search($keyword)->asArray());
    return Product::search($keyword)->get();
    

});
