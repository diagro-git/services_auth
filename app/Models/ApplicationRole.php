<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\Pivot;

class ApplicationRole extends Pivot
{


    public $incrementing = true;


    public function arar(): HasMany
    {
        return $this->hasMany(ARAR::class, 'application_role_id', 'id');
    }


}
