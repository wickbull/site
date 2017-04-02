<?php 
namespace App;
use Illuminate\Database\Eloquent\Model;
class Reserv extends Model
{
	protected $fillable = array('email','marker','title','text');
}
?>