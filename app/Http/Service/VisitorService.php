<?php

namespace App\Http\Service;

use App\Imports\VisitorsImport;
use App\Models\Visitor;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Facades\Excel;

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

    public function importVisitors(object $file): int
    {
        $items = Excel::toArray(new VisitorsImport(), $file);
        $count = 0;

        foreach ($items[0] as $item) {
            $visitor = Visitor::where('email', $item['email'])->first();

            if (!$visitor) {
                $visitor = new Visitor();
                $visitor->setEmail($item['email']);
                $visitor->setCode();
            }

            $visitor->setName($item['name']);
            $visitor->setLastName($item['lastname']);
            $visitor->setPhone($item['phone']);
            $visitor->setTelegram($item['telegram']);
            $visitor->setCategory($item['category']);

            $visitor->save();
            ++$count;
        }

        return $count;
    }
}
