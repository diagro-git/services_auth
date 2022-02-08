<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Application extends Model
{

    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'description',
    ];


    public function rights(): HasMany
    {
        return $this->hasMany(ApplicationRight::class);
    }


    public function companies(): BelongsToMany
    {
        return $this->belongsToMany(Company::class, 'installations')
            ->using(Installation::class)
            ->withTimestamps();
    }


    public function roles(): BelongsToMany
    {
        return $this->belongsToMany(Role::class, 'application_roles')
            ->using(ApplicationRole::class)
            ->withTimestamps()
            ->withPivot(['id']);
    }


    public function frontendApplications()
    {
        return $this->belongsToMany(FrontendApplication::class, 'frontend_applications_applications')->withTimestamps();
    }


}
