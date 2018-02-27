<div id="messages">
@if(count($errors) > 0)
@foreach($errors->all() as $error)
<div class="row">
    <div class="col-md-12">
        <div class="alert alert-danger">
            {{$error}}
        </div>
    </div>
</div>
@endforeach
@endif

@if(session('message'))
    <div class="row">
        <div class="col-md-12">
            <div class="alert alert-success">
                {{session('message')}}
            </div>
        </div>
    </div>
@endif
</div>
