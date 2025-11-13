<?php

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TodoController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Api\SearchController;

// Public auth endpoints
Route::post('/auth/register', [AuthController::class, 'register']);
Route::post('/auth/login',    [AuthController::class, 'login']);

// Protected: must send Bearer token
Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('/auth/user',   [AuthController::class, 'me']);
    Route::post('/auth/logout', [AuthController::class, 'logout']);

    // You can also restrict by token abilities if you want:
    // Route::apiResource('todos', TodoController::class)->middleware('abilities:todos:read,todos:write');

    Route::apiResource('todos', TodoController::class);
    Route::patch('todos/{id}/toggle', [TodoController::class, 'toggle']); // quick toggle done/undone
});


//Elastic Search
Route::get('/search', function (Request $request) {
    $query = $request->get('query', '');
    $category = $request->get('category');
    $brand = $request->get('brand');
    $minPrice = $request->get('min_price');
    $maxPrice = $request->get('max_price');
    $page = $request->get('page', 1);

    // Start search
    $search = Product::search($query);

    // Add filters using Laravel Collection (after Scout results)
    $results = $search->get()->when($category, fn($q) => $q->where('category', $category))
                               ->when($brand, fn($q) => $q->where('brand', $brand))
                               ->when($minPrice, fn($q) => $q->where('price', '>=', $minPrice))
                               ->when($maxPrice, fn($q) => $q->where('price', '<=', $maxPrice))
                               ->forPage($page, 10)
                               ->values();

    return response()->json([
        'total' => $results->count(),
        'page' => (int) $page,
        'data' => $results
    ]);
});



Route::get('/autocomplete', function (Request $request) {
    $keyword = $request->get('query', '');

    $results = Product::search($keyword)->take(5)->get();

    return response()->json(
        $results->pluck('name')
    );
});




Route::get('/search', [SearchController::class, 'search']);
Route::get('/autocomplete', [SearchController::class, 'autocomplete']);
Route::get('/aggregations-search-stats', [SearchController::class, 'stats']);
Route::get('/fuzzy-search', [SearchController::class, 'fuzzySearch']);

