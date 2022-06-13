<?php

namespace App\Repository;

namespace App\Repository\Eloquent;
use App\Models\Ward;
use App\Repository\WardRepositoryInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

class WardRepository extends BaseRepository implements WardRepositoryInterface
{
    /**
     * @var Model
     */
    protected $model;

    /**
     * BaseRepository constructor.
     *
     * @param Model $model
     */
    public function __construct(Ward $model)
    {
        $this->model = $model;
    }
}
