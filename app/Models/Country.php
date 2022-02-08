<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Country extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'name_international',
        'name_native',
        'currency_id',
        'iso_3166_1'
    ];


    public function currency(): BelongsTo
    {
        return $this->belongsTo(Currency::class);
    }
}
