<?php
namespace App\Http\Controllers\Api;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Elastic\Elasticsearch\ClientBuilder;

class SearchController extends Controller
{
    public function search(Request $request)
    {
        $query = $request->get('query', '');
        $category = $request->get('category');
        $brand = $request->get('brand');
        $minPrice = $request->get('min_price');
        $maxPrice = $request->get('max_price');
        $page = $request->get('page', 1);

        $search = Product::search($query);
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
    }

    public function autocomplete(Request $request)
    {
        $keyword = $request->get('query', '');
        $results = Product::search($keyword)->take(5)->get();

        return response()->json($results->pluck('name'));
    }

    public function stats()
    {
        $client = ClientBuilder::create()
            ->setHosts([config('services.elastic.host')])
            ->build();

        $response = $client->search([
            'index' => 'products_v2',
            'body'  => [
                'size' => 0, // we only need stats
                'aggs' => [
                    'categories' => [
                        'terms' => ['field' => 'category.keyword']
                    ],
                    'price_ranges' => [
                        'range' => [
                            'field' => 'price',
                            'ranges' => [
                                ['to' => 1500],
                                ['from' => 1500, 'to' => 3000],
                                ['from' => 3000]
                            ]
                        ]
                    ]
                ]
            ]
        ]);

        return response()->json($response->asArray()['aggregations']);
    }

    // public function fuzzySearch(Request $request)
    // {
    //     $query = $request->get('query', '');

    //     if (empty($query)) {
    //         return response()->json(['error' => 'query parameter is required'], 422);
    //     }

    //     // Basic Scout search (babenkoivan/elastic-scout-driver)
    //     $results = Product::search($query)->get();

    //     return response()->json([
    //         'query' => $query,
    //         'total' => $results->count(),
    //         'data'  => $results
    //     ]);
    // }



    public function fuzzySearch(Request $request)
    {
        $query = request()->get('query', '');

        if (empty($query)) {
            return response()->json(['error' => 'query parameter is required'], 422);
        }

        $client = ClientBuilder::create()
            ->setHosts(['http://localhost:9200'])
            ->build();

        $response = $client->search([
            'index' => 'products_v2',
            'body' => [
                'query' => [
                    'multi_match' => [
                        'query'     => $query,
                        'fields'    => ['name^3', 'brand', 'category'],
                        'fuzziness' => 'AUTO',
                        'operator'  => 'and'
                    ]
                ]
            ]
        ]);

        return response()->json($response->asArray());
    }

}
