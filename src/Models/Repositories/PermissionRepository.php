<?php
namespace Bws\Core\Models\Repositories;

use Bws\Core\Http\Repositories\EloquentRepository;
use Spatie\Permission\Models\Permission;

class PermissionRepository extends EloquentRepository implements PermissionRepositoryInterface
{
    protected $entity = Permission::class;
}
