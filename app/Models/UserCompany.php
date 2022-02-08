<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\Pivot;

class UserCompany extends Pivot
{


    public $incrementing = true;


    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }


    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }


    public function role(): BelongsTo
    {
        return $this->belongsTo(Role::class);
    }


    public function ucar(): HasMany
    {
        return $this->hasMany(UCAR::class, 'user_company_id', 'id');
    }


}
