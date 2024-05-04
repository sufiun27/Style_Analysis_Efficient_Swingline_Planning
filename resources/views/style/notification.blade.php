@extends('template.index')
@section('content')


<div class="card">
    <div class="card-body">
        
        @if(isset($error))
        <div class="alert alert-danger">{{ $error }}</div>
        @endif

        
        <a class="alert alert-success but" href="http://10.3.13.87:8080">Home</a>

        
    </div>
</div>
@endsection