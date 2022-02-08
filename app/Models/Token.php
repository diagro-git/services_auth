<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Token extends Model
{


    use HasFactory;


    const TOKEN_TYPE_AT  = 'AT';
    const TOKEN_TYPE_AAT = 'AAT';

    const STATUS_ACTIVE = 0;
    const STATUS_EXPIRED = 1;
    const STATUS_REVOKED = 2;


    protected $fillable = [
        'user_id',
        'token_type',
        'token',
        'status',
        'revoked_by',
        'revoked_reason',
        'issuer',
        'device'
    ];


    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }


    public function revokedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'revoked_by', 'id');
    }


    public function issuer(): BelongsTo
    {
        return $this->belongsTo(FrontendApplication::class);
    }


}
