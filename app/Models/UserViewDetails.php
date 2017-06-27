<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class UserViewDetails extends Model {
   protected $fillable = ['view_id', 'service_name', 'created_by', 'updated_by'];
   protected $table = 'user_view_details';

   public function UserViews()
    {

        return $this->hasOne('App\Models\UserViews', 'id', 'view_id');
    }

}