<?php 

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Marker;
use App\MarkerChange;
use App\Reserv;
use App\Like;

class IndexController extends Controller
{

	public function index()
	{
		$likes_id = Like::pluck('id_parent');
		
		
		
		$markers = Marker::select(['id','email','marker','title','text'])->get();
		$reservs = Reserv::select(['id','email','marker','title','text'])->get();
		$loc_marker = Marker::select(['marker'])->get();
		return view('work')->with(['markers' => $markers, 'reservs' => $reservs, 'loc_marker' => $loc_marker, 'likes' => $likes_id]);
		
	}

	public function add(){
		return view('add-content');
	}

	public function store(Request $request){
		$this->validate($request, [
			'email' => 'required|max:255',
			'marker' => 'required|max:255',
			'title' => 'required|max:255',
			'text' => 'required'
			]);
		$data = $request->all();
		$reservs = new Reserv;
		$reservs->fill($data);
		$reservs->save();
		return redirect('work');
	}

	function FormChars($p1){
		return n12br(htmlspecialchars($p1, ENT_QUOTES), false);
	}

	public function change($id) {
		// $marker_db = Marker::find($id);
		$marker_db = Marker::select(['id','marker', 'title', 'text'])->where('id', $id)->first();
		return view('add-change')->with(['mark' => $marker_db]);
		
	}

	public function add_change(Request $request){
		$data = $request->all();
		$change = new Marker;
		$change->fill($data);
		$valid_marker = Marker::select(['marker','title','text'])->where('id', $change['id'])->first();
		if($valid_marker){
			if(!empty($change['marker'])){
				Marker::where('id', $change['id'])->update(['marker' => $change['marker']]);
				return redirect('work');
			}
			if(!empty($change['title'])){
				Marker::where('id', $change['id'])->update(['title' => $change['title']]);
				return redirect('work');
			}
			if(!empty($change['text'])){
				Marker::where('id', $change['id'])->update(['text' => $change['text']]);
				return redirect('work');
			}
		}
	}
}
