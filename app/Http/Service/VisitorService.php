<?php

namespace App\Http\Service;

use Illuminate\Support\Str;

trait VisitorService
{
    public function createCode(): string
    {
        return Str::random(12);
    }
}
