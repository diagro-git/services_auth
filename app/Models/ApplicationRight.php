<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class ApplicationRight extends Model
{


    use HasFactory, SoftDeletes;

    protected $fillable = [
        'application_id',
        'name',
        'description'
    ];


    public function application(): BelongsTo
    {
        return $this->belongsTo(Application::class);
    }


    public function arar(): HasMany
    {
        return $this->hasMany(ARAR::class);
    }


    public function ucar(): HasMany
    {
        return $this->hasMany(UCAR::class);
    }


}
