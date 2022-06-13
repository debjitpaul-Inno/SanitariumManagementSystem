<?php

namespace App\Repository;

namespace App\Repository\Eloquent;
use App\Models\Lab;
use App\Repository\LabRepositoryInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

class LabRepository extends BaseRepository implements LabRepositoryInterface
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
    public function __construct(Lab $model)
    {
        $this->model = $model;
    }

    public function createLab($payload)
    {
        $lab = new Lab();
        $lab->lab_name = $payload['lab_name'];
        $lab->room_id = $payload['room_id'];
        $lab->address = $payload['address'];
        $lab->status = $payload['status'];
        $lab->save();
    }

    public function updateLab($uuid, $payload)
    {
        $lab = $this->findByUuid($uuid);
        $lab->lab_name = $payload['lab_name'];
        $lab->room_id = $payload['room_id'];
        $lab->address = $payload['address'];
        $lab->status = $payload['status'];
        $lab->save();
    }
}
