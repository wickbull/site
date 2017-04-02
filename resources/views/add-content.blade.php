<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Document</title>
	<link rel="stylesheet" href="{{ asset('css/bootstrap.css') }}">
	<style>
		#main{
			width: 15%;
			margin: 50px auto;
		}
		input{
			width: 100%;
		}
	</style>
</head>
<body>
	@if(count($errors) > 0)
		<div class="alert alert-danger">
			<ul>
				@foreach($errors->all() as $error)
					<li>{{ $error }}</li>
				@endforeach
			</ul>
		</div>
	@endif

	<a href="/work" class="btn btn-default" style="width:12%;margin: 10px 10px;">Повернутись назад</a>
	
	<div id="main">
		<form method="POST" action="{{route('markerStore')}}">
			{{ csrf_field() }}
			<input name="email" type="email" placeholder="Введіть свій @mail"><br><br>
			<input name="marker" type="text" placeholder="Введіть місце"><br><br>
			<input name="title" type="text" placeholder="Введіть заголовок"><br><br>
			<input name="text" type="text" placeholder="Введіть інформацію"><br><br>
			<button>Відправити</button><br><br>
		</form>
	</div>
	
</body>
</html>