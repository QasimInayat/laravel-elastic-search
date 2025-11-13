<?php

namespace App\Services;

class SlugService
{
    public function generate(string $title): string
    {
        return strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $title)));
    }
}

