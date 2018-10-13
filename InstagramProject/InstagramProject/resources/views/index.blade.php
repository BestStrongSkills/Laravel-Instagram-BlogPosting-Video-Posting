@extends('layouts.app')

@section('content')
@if($flush = session()->get('error'))
    <div id="flushMessage" class="alert alert-success alert-dismissable fade show">
        <button type="button" class="close" data-dismiss="alert">&times;</button>
        {{$flush}}
    </div>
@endif
<form>
    <div class="form-group">
        <div class="row">
            <label class="col-md-4" style="color:white;font-size:20px;font-weight:500">InstagramSecretAccount</label>
            <input id="tokken" type="text" name="token_value" class="form-control col-md-8" required="">
        </div>
    </div>
    <div class="form-group">
        <div class="row">
            <label class="col-md-4"></label>
            <button id="tokken" onclick="route()" class="btn btn-primary col-md-8">Show Instagram Media Gallery</button>
        </div>
    </div>
</form>
<a href="http://instagram.pixelunion.net/" style="font-size:25px;font-weight:600;color: #6b1cb1;">Generate SecretAccount</a>
@stop

@section('footer_script')
<script type="text/javascript">
    function route() {
        event.preventDefault();
        document.location.href="./showGallery/"+$('#tokken').val();
    }
</script>
@endsection