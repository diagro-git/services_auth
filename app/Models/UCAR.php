<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class UCAR extends Model
{

    use HasFactory, SoftDeletes;


    protected $table = 'ucar';

    protected $fillable = [
        'user_company_id',
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


    public function userCompany(): BelongsTo
    {
        return $this->belongsTo(UserCompany::class);
    }


    public function applicationRight(): BelongsTo
    {
        return $this->belongsTo(ApplicationRight::class);
    }


}
