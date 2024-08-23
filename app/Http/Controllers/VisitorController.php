<?php

namespace App\Http\Controllers;

use App\Models\Visitor;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
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

    public function search(string $query): JsonResponse
    {
        $pattern = '%' . $query . '%';

        $result = Visitor::where('name', 'LIKE', $pattern)
            ->orWhere('lastName', 'LIKE', $pattern)
            ->orWhere('code', 'LIKE', $pattern)
            ->get();

        $visitors = $result->map(function (Visitor $visitor) {
            return $visitor->serialize();
        });

        return response()->json($visitors);
    }

    public function validate(string $code): View
    {
        $visitor = Visitor::firstWhere('code', $code);

        if (empty($visitor)) {
            return view('visitors.notfound');
        }

        if ($visitor->getIsRejected() === true) {
            return view('visitors.rejected', [
                'visitor' => $visitor,
            ]);
        }

        if ($visitor->getCategory() === Visitor::CATEGORY_VIP) {
            return view('visitors.vip', [
                'visitor' => $visitor,
            ]);
        }

        return view('visitors.common', [
            'visitor' => $visitor,
        ]);
    }

    public function list(Request $request): View
    {
        $query = $request->get('query');

        if (!is_null($query)) {
            $pattern = '%' . $query . '%';

            $visitors = Visitor::where('name', 'LIKE', $pattern)
                ->orWhere('lastName', 'LIKE', $pattern)
                ->orWhere('code', 'LIKE', $pattern)
                ->get();

            if (empty($visitors)) {
                return view('visitors.notfound');
            }
        }

        return view('visitors.search', [
            'visitors' => $visitors ?? [],
            'query' => $query,
        ]);
    }

    public function all(): View
    {
        $visitors = Visitor::all();

        return view('visitors.all', [
            'visitors' => $visitors,
        ]);
    }

    public function manage(Request $request): View
    {
        $query = $request->get('query');

        if (!is_null($query)) {
            $pattern = '%' . $query . '%';

            $visitors = Visitor::where('name', 'LIKE', $pattern)
                ->orWhere('lastName', 'LIKE', $pattern)
                ->orWhere('code', 'LIKE', $pattern)
                ->get();
        } else {
            $visitors = Visitor::all();
        }

        return view('visitors.manage', [
            'visitors' => $visitors,
            'query' => $query,
            'newCount' => $this->countVisitorsBy($visitors, 'category', Visitor::CATEGORY_UNKNOWN),
            'employeesCount' => $this->countVisitorsBy($visitors, 'category', Visitor::CATEGORY_EMPLOYEE),
            'pressCount' => $this->countVisitorsBy($visitors, 'category', Visitor::CATEGORY_PRESS),
            'vipCount' => $this->countVisitorsBy($visitors, 'category', Visitor::CATEGORY_VIP),
            'guestsCount' => $this->countVisitorsBy($visitors, 'category', Visitor::CATEGORY_GUEST),
            'rejectedCount' => $this->countVisitorsBy($visitors, 'isRejected', true),
        ]);
    }

    private function countVisitorsBy(Collection $visitors, string $key, string $value): int
    {
        return $visitors->where($key, $value)->count();
    }
}
