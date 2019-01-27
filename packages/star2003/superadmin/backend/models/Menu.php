<?php

namespace Superadmin\Backend\Models;

use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    public $table='menues';
      /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'access','pre_id','status','display','icon','url','rank',
    ];
}
