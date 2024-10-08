<?php

namespace App\Models;
 
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DiffShadeDetail extends Model
{   
    protected $table = 'diffshadedetail';	
	protected $primaryKey  = 'id';
    protected $fillable = ['jobcard_no','output_image','uploaded_image','accuracy'];      
}
