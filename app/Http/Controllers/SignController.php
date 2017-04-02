<?php 

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\User;

class SignController extends Controller
{
	
	public function to_login(){
		return view('auth/admin');
	}
	public function login_now(Request $request){
		
		$data = $request->all();
		$users = new User;
		$users->fill($data);
		if($users['login']){
			$valid_login = \App\User::where('login', $users['login'])->first();
			if($valid_login){
				if($valid_login['password'] == $users['password']){
					$request->session()->put('admin', $valid_login['admin']);
					$request->session()->put('login', $valid_login['login']); 
					return redirect('work');
				}
				else{
					echo 'OOps. пароль неправильний!';
				}
			}
			else {
				echo 'Такого логіна неіснує!';
			}
		} else {
			echo 'Десь проблема з формами!';
		}
	}
}