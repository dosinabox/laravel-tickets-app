<?php

namespace App\Http\Service;

use App\Models\Visitor;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Str;

trait VisitorService
{
    public function createCode(): string
    {
        return Str::random(12);
    }

    public function searchByQuery(string $query): Collection
    {
        $pattern = '%' . $query . '%';

        return Visitor::where('name', 'LIKE', $pattern)
            ->orWhere('lastName', 'LIKE', $pattern)
            ->orWhere('code', 'LIKE', $pattern)
            ->get();
    }

    public function respondWithMessage(string $message, int $code): JsonResponse
    {
        return response()->json([
            'message' => $message
        ], $code);
    }
}
