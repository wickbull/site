<?php

Route::get('/', function () {
    return view('welcome');
});

Route::get('work', 'IndexController@index');

Route::get('work/logout', function(){
	session()->flush();
	return redirect('work');
});

Route::get('auth/admin', 'SignController@to_login');
Route::post('auth/admin', 'SignController@login_now')->name('adminLogged');

Route::get('work/marker/{id}', 'IndexController@change')->name('markerChange');
Route::post('work/marker', 'IndexController@add_change')->name('add_markerChange');

Route::get('work/add', 'IndexController@add');
Route::post('work/add','IndexController@store')->name('markerStore');

Route::get('work/{Like}', function($like){
	$ip = Request::ip();
	$ip_STR = str_replace(".", "_", '='.$ip);
	$ID_IP = $like.$ip_STR;
	$array = array($like, $ID_IP);
	$likes = new \App\Like;
	$likes->fill($array);
	$searchLike = \App\Like::where('ip', $ID_IP)->first();
	if($ID_IP != $searchLike['ip']){
		$add_like = \App\Like::insert(['id_parent' => $like,'ip' => $ID_IP]);
		return redirect('work');
	} else {
		$deleteLike = \App\Like::where('ip', $ID_IP)->first();
		$deleteLike->delete();
		return redirect('work');
	}
})->name('addLike');


Route::post('work/add_new_marker/{Marker}', function($reservs){
	$add_reserv = \App\Reserv::where('id', $reservs)->first();
	$new_marker = new \App\Marker;
	$new_marker->fill($add_reserv->toArray());
	$new_marker->save();
	$add_reserv->delete();
	return redirect('work');
})->name('markerAdd');

Route::delete('work/delete_new/{Reserv}', function($reserv){
	$reserv_tmp = \App\Reserv::where('id', $reserv)->first();
	$reserv_tmp->delete();
	return redirect('work');
})->name('reservDelete');


Route::delete('work/delete_old/{Marker}', function($marker){
	$marker_tmp = \App\Marker::where('id', $marker)->first();
	$marker_tmp->delete();
	return redirect('work');
})->name('markerDelete');

