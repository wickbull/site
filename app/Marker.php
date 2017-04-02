<?php 
namespace App;
use Illuminate\Database\Eloquent\Model;
class Marker extends Model
{
	protected $fillable = array('id','email','marker','title','text');
}
?>