<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Locale extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'identifier'
    ];


    public function language(): BelongsTo
    {
        return $this->belongsTo(Language::class);
    }


    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }
}
