<?php

namespace App\Models;
 
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Differenceshading extends Model
{   
    protected $table = 'differenceshading';	
	protected $primaryKey  = 'id';
    protected $fillable = ['jobcard_no','dept','original_image','user_id'];      
}
