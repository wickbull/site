<?php 
namespace App;
use Illuminate\Database\Eloquent\Model;
class MarkerChange extends Model
{
	protected $fillable = array('id','marker','title','text');
}
?>