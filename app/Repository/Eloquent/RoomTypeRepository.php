<?php

namespace App\Repository;

namespace App\Repository\Eloquent;
use App\Models\RoomType;
use App\Repository\RoomTypeRepositoryInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

class RoomTypeRepository extends BaseRepository implements RoomTypeRepositoryInterface
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
    public function __construct(RoomType $model)
    {
        $this->model = $model;
    }
}
