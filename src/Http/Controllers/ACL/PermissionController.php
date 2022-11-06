<?php

namespace Bws\Core\Http\Controllers\ACL;

use Bws\Core\Criteria\OrderBy;
use Bws\Core\Criteria\SearchByField;
use Bws\Core\Http\Controllers\CoreController;
use Bws\Core\Models\Repositories\PermissionRepositoryInterface;
use Illuminate\Http\Request;

class PermissionController extends CoreController
{
    protected $repository;

    public function __construct(PermissionRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function index(Request $request) {
        $perPage = (int)$request->input('perPage', config('app.per_page'));
        $data = $this->repository->withCriteria([
            new SearchByField($request->search ?? []),
            new OrderBy($request->column ?? 'id', $request->sortBy ?? 'asc')
        ])->paginate($perPage);
        return view('bws@core::pages.permission.list', compact('data'));
    }
}
