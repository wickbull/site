<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>work</title>
	<link rel="stylesheet" href="{{ asset('css/bootstrap.css') }}">
	<link rel="stylesheet" href="{{ asset('css/font-awesome.min.css') }}">
	<style>
		*{
			padding: 0;
			margin: 0;
		}
		html,body{
			width: 100%;
			height: 100%;
			overflow:hidden;
		}
		.container{
			height: 100%;
		}
		.bottom{
			background: #DEDEDE;
			height: 100%;
		}
		#scroll{
			height: 89%;
			width:100%;
			overflow-x: hidden;
			overflow-y: scroll;
		}
		.col-md-3{
			height: 100%;
		}
		.col-md-9{
			height: 100%;
		}
		#map_canvas {
	        width: 100%;
	        height: 100%;
	        float: left;
	    }
	</style>
</head>
<body onload="initialize();codeAddress()">
	<div class="bottom">
		<div class="col-md-3">
			
			@if(empty(session('login')))
				<div class="col-md-12">
					<a href="/" class="btn btn-info btn-xs" style="margin-left: 5px;margin-top: 5px; border-radius:0px;">Головна</a>
					<a href="auth/admin" class="btn btn-info btn-xs" style="float:right; margin-left: 5px;margin-top: 5px; border-radius:0px;">Авторизація для лінивого адміна</a>
					<a href="work/add" class="btn btn-success" style="border-radius: 0px;margin-left:30%; margin-top: 5px;">Запропонувати місце</a>
				</div>
			@else
				<div class="col-md-12">
					<a href="/" class="btn btn-info btn-xs" style="margin-left: 5px;margin-top: 5px; border-radius:0px;">Головна</a>
					<a href="work/logout" class="btn btn-info btn-xs" style="float:right; margin-top: 5px; border-radius:0px;">Вихід</a>
					<a href="work/add" class="btn btn-success" style="border-radius: 0px;margin-left:30%; margin-top: 5px;">Запропонувати місце</a>
				</div>
			@endif

			<div class="col-md-12" id="scroll">

				@if(!empty(session('admin')))
					@foreach($reservs as $key => $reserv)
						<div class="col-md-12" style="margin-top: 5px;background: #E2FFF4">

							<b style="color:#3437B0;"> <h4> ADMIN </h4> </b>
							<b style="color:#3437B0;"> Запропоноване місце №{{ ++$key }} </b><br>
							<b>@mail:</b> <?php print strip_tags($reserv->email) ?>.<br>
							<?php //preg_match_all(pattern, subject, matches) ?>
							<b>Маркер:</b> <?php print str_replace('\'','',str_replace(';','',str_replace(')','',str_replace('(', '', strip_tags($reserv->marker))))) ?>.<br>
							<b>Тема:</b> <?php print strip_tags($reserv->title) ?>.<br>
							<b>Опис:</b> <?php print strip_tags($reserv->text) ?>.<br>

							<form action="{{ route('markerAdd',['reservs' => $reserv->id]) }}" method="POST">
								{{ method_field('POST') }}
								{{ csrf_field() }}
								<button type="submit" class="btn btn-success btn-xs" style="margin-top:5px;margin-bottom:5px;border-radius: 0;">Добавити маркер</button>
							</form>

							<form action="{{ route('reservDelete',['reserv' => $reserv->id]) }}" method="POST">
								{{ method_field('DELETE') }} <!-- то саме що <input type="hidden" name="_method" value="DELETE"> -->
								{{ csrf_field() }} <!-- сесійний захист від запросів -->
								<button type="submit" class="btn btn-danger btn-xs" style="margin-top:5px;margin-bottom:5px;border-radius: 0;">Видалити запис</button>
							</form>

						</div>
					@endforeach
				@endif
				
				@foreach($markers as $key => $marker)
					<div class="col-md-12" style="margin-top: 5px;background: #FFE2E2">
						
						<b style="color:#349DB0;"> <h4> USER </h4> </b>
						<b style="color:#349DB0;">Місце №{{ ++$key }}</b><br>
						<b>@mail:</b> <?php print strip_tags($marker->email) ?>.<br>
						<b>Маркер:</b> <?php print str_replace('\'','',str_replace(';','',str_replace(')','',str_replace('(', '', strip_tags($marker->marker))))) ?>.<br>
						<b>Тема:</b> <?php print strip_tags($marker->title) ?>.<br>
						<b>Опис:</b> <?php print strip_tags($marker->text) ?>.<br>
						
						<a href="{{ route('addLike',['id' => $marker->id]) }}" class="
						<?php
							$ip = Request::ip();
							$ip_STR = str_replace('.', '_', '='.$ip);
							$idLike = $marker->id.$ip_STR;
							$searchLike = \App\Like::where('ip', $idLike)->first();
							if($searchLike){
								echo 'btn btn-danger btn-xs';
							} else {
								echo 'btn btn-primary btn-xs';
							}
						?>" 
						style="float:right;margin-top:5px;margin-bottom:5px;border-radius: 0;">
							<?php
								$ip = Request::ip();
								$ip_STR = str_replace('.', '_', '='.$ip);
								$idLike = $marker->id.$ip_STR;
								$searchLike = \App\Like::where('ip', $idLike)->first();
								if($searchLike){
									echo ' <i class="fa fa-thumbs-down" aria-hidden="true"></i> ';
								} else {
									echo ' <i class="fa fa-thumbs-up" aria-hidden="true"></i> ';
								}
							?>
							<b>
								<?php 
									$count = 0;
									foreach ($likes as $like) {
									$parent = $like;
										if( $parent == $marker->id ){
											++$count;
										}
									} 
									print $count;
								?>
							</b>
						</a>

						@if(!empty(session('admin')))
							
							<a href="{{ route('markerChange',['id' => $marker->id]) }}" class="btn btn-info btn-xs" style="margin-top:5px;margin-bottom:5px;border-radius: 0;">Редагувати запис</a>

							<form action="{{ route('markerDelete',['marker' => $marker->id]) }}" method="POST">
								{{ method_field('DELETE') }}
								{{ csrf_field() }}
								<button type="submit" class="btn btn-danger btn-xs" style="margin-top:5px;margin-bottom:5px;border-radius: 0;">Видалити запис</button>
							</form>
						@endif
						
					</div>
				@endforeach
				
			</div>
		</div>
		<div class="col-md-9">
			<div id="map_canvas"></div>
			
			<script type="text/javascript"
			    src="https://maps.googleapis.com/maps/api/js?key= AIzaSyDgInw-VTPOqRMvkB9ou7M9Gs0kycrmGqg &sensor=false">
			</script>
			<script>
			var geocoder;
			var map;
			function initialize() {
			    geocoder = new google.maps.Geocoder();
			    var latlng = new google.maps.LatLng(50.51342653, 30.43212891);
			    var mapOptions = {
			      	zoom: 4,
			      	center: latlng
			    }
			    map = new google.maps.Map(document.getElementById("map_canvas"), mapOptions);
			}
			function codeAddress() {
			    var loc_address = "<?php foreach ($loc_marker as $mark) {
			    	echo str_replace('\'','',str_replace(';','',str_replace(')','',str_replace('(', '', strip_tags($mark->marker))))).'/';
			    } ?>";
			    loc_add = loc_address.substring(0, loc_address.length - 1)
			    var address = loc_add.split('/');
			    var j = 0;
			    for(var i=0;i<address.length;i++){
			    	geocoder.geocode( { 'address': address[i]}, function(results, status) {
				        if (status == google.maps.GeocoderStatus.OK) {
				        	var contentString = '<div id="content">'+
					      		'<div id="siteNotice">'+
					      		'</div>'+
					      		'<div id="bodyContent">'+
				      			'<p><b><h4>Точка: </b>'+address[j++]+'</h4></p>'+
					      		'</div>'+
					      		'</div>';

					      	var infowindow = new google.maps.InfoWindow({
							    content: contentString,
							    maxWidth: 200
						  	});

					        map.setCenter(results[0].geometry.location);
					        var marker = new google.maps.Marker({
					            map: map,
					            position: results[0].geometry.location
					        });


					        marker.addListener('click', function() {
							    infowindow.open(map, marker);
							});


				        } else {
				        	alert("Geocode was not successful for the following reason: " + status);
				      	}
				    });
			    }
			  }
			</script>
		</div>
	</div>
</body>
</html>

