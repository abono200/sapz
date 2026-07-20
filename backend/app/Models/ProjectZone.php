<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class ProjectZone extends Model
{
    use HasUuids;

    protected $fillable = ['name', 'state', 'commodity_focus', 'coordinates'];

    public function projects()
    {
        return $this->hasMany(Project::class, 'zone_id');
    }
}
