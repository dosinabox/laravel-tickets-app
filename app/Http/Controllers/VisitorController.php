<?php

namespace App\Http\Controllers;

use App\Models\Visitor;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

class VisitorController extends Controller
{
    public function index(): JsonResponse
    {
        $visitors = Visitor::all()->map(function (Visitor $visitor) {
            return $visitor->serialize();
        });

        return response()->json($visitors);
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
        } catch (Throwable $exception) {
            return response()->json([
                'message' => 'Visitor not created: ' . $exception->getMessage()
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        if (!$visitor instanceof Visitor) {
            return response()->json([
                'message' => 'Failed to create visitor.'
            ], Response::HTTP_BAD_REQUEST);
        }

        return response()->json([
            'message' => 'Visitor created.'
        ], Response::HTTP_CREATED);
    }

    public function show(string $code): JsonResponse
    {
        $visitor = Visitor::firstWhere('code', $code);

        if (empty($visitor)) {
            return response()->json([
                'message' => 'Visitor not found.'
            ], Response::HTTP_NOT_FOUND);
        }

        return response()->json($visitor->serialize());
    }

    public function update(Request $request, int $id): JsonResponse
    {
        $visitor = Visitor::find($id);

        if (empty($visitor)) {
            return response()->json([
                'message' => 'Visitor not found.'
            ], Response::HTTP_NOT_FOUND);
        }

        try {
            if (isset($request->name)) {
                $visitor->setName($request->name);
            }
            if (isset($request->lastName)) {
                $visitor->setLastname($request->lastName);
            }
            if (isset($request->status)) {
                $visitor->setStatus($request->status);
            }
            if (isset($request->company)) {
                $visitor->setCompany($request->company);
            }
            if (isset($request->phone)) {
                $visitor->setPhone($request->phone);
            }
            if (isset($request->telegram)) {
                $visitor->setTelegram($request->telegram);
            }
            if (isset($request->email)) {
                $visitor->setEmail($request->email);
            }
            if (isset($request->category)) {
                $visitor->setCategory($request->category);
            }
            if (isset($request->isApproved)) {
                $visitor->setIsApproved((bool)$request->isApproved);
            }
            if (isset($request->isRejected)) {
                $visitor->setIsRejected((bool)$request->isRejected);
            }

            $visitor->save();

        } catch (Throwable $exception) {
            return response()->json([
                'message' => 'Visitor not updated: ' . $exception->getMessage()
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return response()->json([
            'message' => 'Visitor updated.'
        ], Response::HTTP_OK);
    }

    public function delete(int $id): JsonResponse
    {
        $visitor = Visitor::find($id);

        if (empty($visitor)) {
            return response()->json([
                'message' => 'Visitor not found.'
            ], Response::HTTP_NOT_FOUND);
        }

        try {
            $visitor->delete();
        } catch (Throwable $exception) {
            return response()->json([
                'message' => 'Visitor not deleted: ' . $exception->getMessage()
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return response()->json([
            'message' => 'Visitor deleted.'
        ], Response::HTTP_OK);
    }
}
