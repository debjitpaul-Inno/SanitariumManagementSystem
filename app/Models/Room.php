<?php

namespace App\Models;

use Askedio\SoftCascade\Traits\SoftCascadeTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Room extends Model
{
    use HasFactory;
    use SoftDeletes;
    use SoftCascadeTrait;

    protected $guarded=[
        'id',
        'uuid',
    ];
    protected $softCascade = ['beds'];
    public static function boot()
    {
        parent::boot();
        static::creating(function($model) {
            $model->uuid = Str::uuid();
        });
    }
    public function beds()
    {
        return $this->hasMany(BedList::class, 'id', 'room_id');
    }
    public function labs()
    {
        return $this->hasMany(Lab::class, 'id', 'room_id');
    }
    public function wards()
    {
        return $this->belongsTo(Ward::class, 'ward_id', 'id');
    }
    public function roomTypes()
    {
        return $this->belongsTo(RoomType::class, 'room_type_id', 'id');
    }
}
