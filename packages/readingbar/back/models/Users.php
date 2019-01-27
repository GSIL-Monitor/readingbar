<?php

namespace Readingbar\Back\Models;

use Illuminate\Database\Eloquent\Model;

class Users extends Model
{
    public $table='users';
      /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = array('name','avatar','cellphone','email','role','password','remember_token');

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];
}
