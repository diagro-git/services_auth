<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{

    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'locale_id',
        'timezone_id',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime', //cast to Carbon object
    ];


    public function locale(): BelongsTo
    {
        return $this->belongsTo(Locale::class);
    }


    public function language(): BelongsTo
    {
        return $this->locale()->first()->language();
    }


    public function timezone(): BelongsTo
    {
        return $this->belongsTo(Timezone::class);
    }


    public function tokens(): HasMany
    {
        return $this->hasMany(Token::class);
    }


    public function companies(?FrontendApplication $frontend = null): BelongsToMany
    {
        $relation = $this->belongsToMany(Company::class, 'user_companies')
            ->using(UserCompany::class)
            ->withTimestamps()
            ->withPivot(['id', 'role_id']);

        if($frontend != null) {
            $relation->whereHas('applications', function(Builder $query) use ($frontend) {
                $query->whereHas('frontendApplications', function(Builder $query) use ($frontend) {
                    $query->where('frontend_application_id', '=', $frontend->id);
                });
            });
        }

        return $relation;
    }


    public function rights(Company $company, Application $application)
    {
        $rights = [];

        /** @var UserCompany $uc */
        $uc = $this->companies()->find($company->id)?->pivot;
        if($uc && $company->applications()->where('application_id', '=', $application->id)->exists()) {
            $arar = $application->roles()->find($uc->role_id)?->pivot->arar()->whereHas('applicationRight', function(Builder $query) use ($application) {
                $query->where('application_id', '=', $application->id);
            })->with('applicationRight')->get();
            $rights = $this->resultToRightsArray($arar);

            $ucar = $uc->ucar()->whereHas('applicationRight', function(Builder $query) use ($application) {
                $query->where('application_id', '=', $application->id);
            })->with('applicationRight')->get();
            $rights = array_merge($rights, $this->resultToRightsArray($ucar));
        }

        return $rights;
    }


    private function resultToRightsArray($result) : array
    {
        $rights = [];

        if($result != null) {
            foreach ($result as $right) {
                $rights[$right->applicationRight->name] = [
                    'r' => $right->read,
                    'c' => $right->create,
                    'u' => $right->update,
                    'd' => $right->delete,
                    'p' => $right->publish,
                    'e' => $right->export,
                ];
            }
        }

        return $rights;
    }


}
