<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FrontendApplication extends Model
{
    use HasFactory;

    const TYPE_WEB                              = 0;
    const TYPE_FLUTTER                          = 1;

    protected $fillable = [
        'name',
        'description',
        'app_type'
    ];


    public function applications()
    {
        return $this->belongsToMany(Application::class, 'frontend_applications_applications')->withTimestamps();
    }

}
