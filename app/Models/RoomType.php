<?php

namespace App\Models;

use Askedio\SoftCascade\Traits\SoftCascadeTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class RoomType extends Model
{
    use HasFactory;
    use SoftDeletes;
    use SoftCascadeTrait;

    protected $guarded=[
        'id',
        'uuid',
    ];
    protected $softCascade = ['rooms'];

    public static function boot()
    {
        parent::boot();
        static::creating(function ($model){
            $uuid = Str::uuid();
            $model->uuid =$uuid;
        });
    }
    public function rooms()
    {
        return $this->hasMany(Room::class, 'id', 'room_type_id');
    }
}
