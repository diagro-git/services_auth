<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasOneThrough;
use Illuminate\Database\Eloquent\SoftDeletes;

class Company extends Model
{

    use HasFactory, SoftDeletes;


    protected $fillable = [
        'name',
        'country_id'
    ];

    protected $visible = [
        'id',
        'name'
    ];


    public function country(): BelongsTo
    {
        return $this->belongsTo(Country::class);
    }


    public function currency(): BelongsTo
    {
        return $this->country()->first()->currency();
    }


    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'user_companies')
            ->using(UserCompany::class)
            ->withTimestamps()
            ->withPivot(['role_id']);
    }


    public function applications()
    {
        return $this->belongsToMany(Application::class, 'installations')
            ->using(Installation::class)
            ->withTimestamps();
    }


}
