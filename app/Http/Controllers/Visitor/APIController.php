<?php

namespace App\Http\Controllers\Visitor;

use App\Http\Controllers\Controller;
use App\Http\Requests\Visitor\VisitorRequest;
use App\Http\Service\VisitorService;
use App\Models\Visitor;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

class APIController extends Controller
{
    use VisitorService;

    public function index(): JsonResponse
    {
        $visitors = Visitor::all()->map(function (Visitor $visitor) {
            return $visitor->serialize();
        });

        return response()->json($visitors);
    }

    public function store(VisitorRequest $request): JsonResponse
    {
        try {
            $visitor = new Visitor();
            $visitor->setName($request->getName());
            $visitor->setLastName($request->getLastName());
            $visitor->setStatus($request->getStatus());
            $visitor->setCompany($request->getCompany());
            $visitor->setPhone($request->getPhone());
            $visitor->setTelegram($request->getTelegram());
            $visitor->setEmail($request->getEmail());
            $visitor->setCode();
            $visitor->save();
        } catch (Throwable $exception) {
            return $this->respondWithMessage(
                'Visitor not created: ' . $exception->getMessage(),
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }

        return $this->respondWithMessage('Visitor created.', Response::HTTP_CREATED);
    }

    public function show(string $code): JsonResponse
    {
        $visitor = Visitor::firstWhere('code', $code);

        if (blank($visitor)) {
            return $this->respondWithMessage('Visitor not found.', Response::HTTP_NOT_FOUND);
        }

        return response()->json($visitor->serialize());
    }

    public function update(VisitorRequest $request, int $id): JsonResponse
    {
        $visitor = Visitor::find($id);

        if (blank($visitor)) {
            return $this->respondWithMessage('Visitor not found.', Response::HTTP_NOT_FOUND);
        }

        try {
            if (isset($request->category)) {
                $visitor->setCategory($request->getCategory());
            }
            if (isset($request->isRejected)) {
                $visitor->setIsRejected($request->getIsRejected());
            }
            $visitor->save();
        } catch (Throwable $exception) {
            return $this->respondWithMessage(
                'Visitor not updated: ' . $exception->getMessage(),
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }

        return $this->respondWithMessage('Visitor updated.', Response::HTTP_OK);
    }

    public function delete(int $id): JsonResponse
    {
        $visitor = Visitor::find($id);

        if (blank($visitor)) {
            return $this->respondWithMessage('Visitor not found.', Response::HTTP_NOT_FOUND);
        }

        try {
            $visitor->delete();
        } catch (Throwable $exception) {
            return $this->respondWithMessage(
                'Visitor not deleted: ' . $exception->getMessage(),
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }

        return $this->respondWithMessage('Visitor deleted.', Response::HTTP_OK);
    }

    public function search(string $query): JsonResponse
    {
        $visitors = $this->searchByQuery($query)->map(function (Visitor $visitor) {
            return $visitor->serialize();
        });

        return response()->json($visitors);
    }
}
