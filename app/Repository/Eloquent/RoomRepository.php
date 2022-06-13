<?php

namespace App\Repository;

namespace App\Repository\Eloquent;
use App\Models\Room;
use App\Repository\RoomRepositoryInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

class RoomRepository extends BaseRepository implements RoomRepositoryInterface
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
    public function __construct(Room $model)
    {
        $this->model = $model;
    }
}
