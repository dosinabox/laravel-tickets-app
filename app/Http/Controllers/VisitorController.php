<?php

namespace App\Http\Controllers;

use App\Models\Visitor;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class VisitorController extends Controller
{
    public function index(): JsonResponse
    {
        $visitors = Visitor::all();

        return response()->json($visitors);
    }

    public function create()
    {
        //
    }

    public function store(Request $request): JsonResponse
    {
        try {
            $visitor = new Visitor();
            $visitor->setName($request->name ?? '');
            $visitor->setLastName($request->lastName ?? '');
            $visitor->setStatus($request->status ?? '');
            $visitor->setCompany($request->company ?? '');
            $visitor->setPhone($request->phone ?? '');
            $visitor->setTelegram($request->telegram ?? '');
            $visitor->setEmail($request->email ?? '');
            $visitor->setCode();
            $visitor->save();
        } catch (\Throwable $exception) {
            return response()->json([
                'message' => 'Visitor not created: ' . $exception->getMessage()
            ], Response::HTTP_BAD_REQUEST);
        }

        if (!$visitor instanceof Visitor) {
            return response()->json([
                'message' => 'Failed to create visitor.'
            ]);
        }

        return response()->json([
            'message' => 'Visitor created.'
        ], Response::HTTP_CREATED);
    }

    public function show(string $code): JsonResponse
    {
        $visitor = Visitor::where('code', $code)->first();

        return !empty($visitor) ?
            response()->json($visitor) :response()->json([
                'message' => 'Visitor not found.'
            ], Response::HTTP_NOT_FOUND);
    }

    public function edit(Visitor $visitor)
    {
        //
    }

    public function update(Request $request, Visitor $visitor)
    {
        //
    }

    public function destroy(Visitor $visitor)
    {
        //
    }
}
