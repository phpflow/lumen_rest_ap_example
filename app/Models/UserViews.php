<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class UserViews extends Model {
   protected $fillable = ['name', 'created_by', 'updated_by'];
   protected $table = 'user_views';

   public function UserViewDetails()
    {

        return $this->hasMany('App\Models\UserViewDetails', 'view_id', 'id');
    }

}