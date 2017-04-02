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
		textarea{
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
		<form method="POST" action="{{route('add_markerChange')}}">
			<div>
				<input name="id" type="hidden" value="{{ $mark->id }}">
				<b>Маркер:</b> {{ $mark->marker }}
				<input name="marker" type="text" placeholder="Змінити маркер"><br><br>
			</div>
			<div>
				<b>Тема:</b> {{ $mark->title }}
				<input name="title" type="text" placeholder="Змінити заголовок"><br><br>
			</div>
			<div>
				<b>Опис:</b> {{ $mark->text }}
				<input name="text" type="text" placeholder="Змінити інформацію"><br><br>
			</div>
			<button>Змінити</button><br><br>
			{{ csrf_field() }}
		</form>
	</div>
	
</body>
</html>