<?php

namespace App\Http\Controllers\Visitor;

use App\Http\Controllers\Controller;
use App\Http\Requests\Visitor\VisitorRequest;
use App\Http\Service\VisitorService;
use App\Models\Visitor;
use Illuminate\View\View;

class UIController extends Controller
{
    use VisitorService;

    public function show(string $code): View
    {
        $visitor = Visitor::firstWhere('code', $code);

        if (blank($visitor)) {
            return view('visitors.notfound');
        }

        if ($visitor->isRejected()) {
            return view('visitors.rejected', [
                'visitor' => $visitor,
            ]);
        }

        if ($visitor->getCategory() === Visitor::CATEGORY_VIP) {
            return view('visitors.vip', [
                'visitor' => $visitor,
            ]);
        }

        if ($visitor->getCategory() === Visitor::CATEGORY_EMPLOYEE) {
            return view('visitors.employee', [
                'visitor' => $visitor,
            ]);
        }

        return view('visitors.common', [
            'visitor' => $visitor,
        ]);
    }

    public function search(VisitorRequest $request): View
    {
        $query = $request->getSearchQuery();

        if (!blank($query)) {
            $visitors = $this->searchByQuery($query);
        } else {
            $visitors = [];
        }

        return view('visitors.search', [
            'visitors' => $visitors,
            'query' => $query,
        ]);
    }

    public function manage(VisitorRequest $request): View
    {
        $query = $request->getSearchQuery();

        if (!blank($query)) {
            $visitors = $this->searchByQuery($query);
        } else {
            $visitors = Visitor::all();
        }

        return view('visitors.manage', [
            'visitors' => $visitors,
            'query' => $query,
            'newCount' => $visitors->where('category', Visitor::CATEGORY_UNKNOWN)->count(),
            'employeesCount' => $visitors->where('category', Visitor::CATEGORY_EMPLOYEE)->count(),
            'pressCount' => $visitors->where('category', Visitor::CATEGORY_PRESS)->count(),
            'vipCount' => $visitors->where('category', Visitor::CATEGORY_VIP)->count(),
            'guestsCount' => $visitors->where('category', Visitor::CATEGORY_GUEST)->count(),
            'rejectedCount' => $visitors->where('isRejected', true)->count(),
        ]);
    }
}
