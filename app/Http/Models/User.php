<?php

namespace App\Http\Models;

use App\Http\Models\Group;
use App\Http\Models\Character;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;

class User extends Model implements AuthenticatableContract,
                                    AuthorizableContract,
                                    CanResetPasswordContract
{
    use Authenticatable, Authorizable, CanResetPassword;
    
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['login', 'email', 'password', 'group_id'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = ['password'/*, 'remember_token'*/];

    public function setPasswordAttribute($password)
    {
        $this->attributes['password'] = \Hash::make($password);
    }

    /**
    * Get the global elo of all the users
    *
    * @return \Illuminate\Database\Eloquent\Collection
    */
    public static function getGlobalElo()
    {
        //Si quelqu'un veut s'amuser, voici la query à mettre en ORM si on veut le faire en 1 requête
        //SELECT id, SUM(elo) as elo FROM (SELECT users.id as id, characters.elo as elo FROM users LEFT JOIN characters ON characters.user_id = users.id UNION ALL SELECT users.id as id, teams.elo as elo FROM users LEFT JOIN teams ON teams.user_id = users.id) as tmp GROUP BY id
        $characters = User::join('characters', 'characters.user_id', '=', 'users.id')
        ->selectRaw('users.id, SUM(characters.elo) as elo')
        ->groupBy('users.id')
        ->lists('elo', 'users.id')->toArray();
        $teams = User::join('teams', 'teams.user_id', '=', 'users.id')
        ->selectRaw('users.id, SUM(teams.elo) as elo')
        ->lists('elo', 'users.id')->toArray();

        $total = [];
        foreach (array_keys($characters + $teams) as $key)
        {
            $total[$key] = (isset($characters[$key]) ? $characters[$key] : 0) + (isset($teams[$key]) ? $teams[$key] : 0);
        }
        arsort($total);
        return $total;
    }

    /**
    * An user is in a group.
    *
    * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
    *
    */
    public function group()
    {
        return $this->belongsTo('App\Http\Models\Group');
    }

    /**
    * A user has many characters.
    *
    * @return \Illuminate\Database\Eloquent\Relations\HasMany
    *
    */
    public function character()
    {
        return $this->hasMany('App\Http\Models\Character');
    }

    /**
    * A user has many scripts.
    *
    * @return \Illuminate\Database\Eloquent\Relations\HasMany
    *
    */
    public function script()
    {
        return $this->hasMany('App\Http\Models\Script');
    }

    /**
    * A user has many teams.
    *
    * @return \Illuminate\Database\Eloquent\Relations\HasMany
    *
    */
    public function team()
    {
        return $this->hasMany('App\Http\Models\Team');
    }
}
