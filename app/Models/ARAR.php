<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class ARAR extends Model
{

    use HasFactory, SoftDeletes;


    protected $table = 'arar';

    protected $fillable = [
        'application_role_id',
        'application_right_id',
        'read',
        'create',
        'update',
        'delete',
        'publish',
        'export'
    ];

    protected $casts = [
        'read' => 'boolean',
        'create' => 'boolean',
        'update' => 'boolean',
        'delete' => 'boolean',
        'publish' => 'boolean',
        'export' => 'boolean'
    ];


    public function applicationRole(): BelongsTo
    {
        return $this->belongsTo(ApplicationRole::class);
    }


    public function applicationRight(): BelongsTo
    {
        return $this->belongsTo(ApplicationRight::class);
    }


}
