@extends('layouts.app')
@section('content')
<form method="post" action="{{Route('view',$token)}}" enctype="multipart/form-data">
	{{csrf_field()}}
	<div class="form-group">
		<div class="row">
			<select name="image[]" multiple="multiple" class="form-control image-picker">
				@foreach($data as $instagram)
				<option data-img-src='{{$instagram->images->thumbnail->url}}' value="{{$instagram->id}}">1</option>
				@endforeach
			</select>
		</div>
	</div>
	<div class="form-group">
		<div class="row">
			<label for="music" class="col-md-2" style="background-color:blue;border-radius:4px;">MusicSecetion:</label>
			<input type="file" class="col-md-6" name="mp3file" accept=".mp3">
			<button type="submit" class="col-md-3 btn btn-primary">VideoPlay</button>
		</div>
	</div>
</form>
@endsection
@section('footer_script')
<script type="text/javascript">
	(function(){
		$('select').imagepicker();
	})();
</script>
@endsection