<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Role extends Model
{

    use HasFactory, SoftDeletes;


    protected $fillable = [
        'name'
    ];


    public function applications(): BelongsToMany
    {
        return $this->belongsToMany(Application::class, 'application_roles')
            ->using(ApplicationRole::class)
            ->withTimestamps();
    }


}
