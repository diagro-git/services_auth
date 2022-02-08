<?php
namespace App\Policies;

use Diagro\Backend\Policy\Diagro;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy extends Diagro
{
    use HandlesAuthorization;
}
