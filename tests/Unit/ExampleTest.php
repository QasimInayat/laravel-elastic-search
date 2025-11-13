<?php

use App\Services\SlugService;

test('it generates a slug correctly', function () {
    $service = new SlugService();
    $slug = $service->generate('Hello World');

    expect($slug)->toBe('hello-world');
});


test('sum works', function () {
    expect(2 + 2)->toBe(4);



    expect("Laravel")->toBeString()->toContain('Lara');
    expect([1, 2, 3])->toHaveCount(3)->toContain(2);

    expect('Hello World')
        ->toBeString()
        ->toStartWith('Hello')
        ->toEndWith('World');
});
