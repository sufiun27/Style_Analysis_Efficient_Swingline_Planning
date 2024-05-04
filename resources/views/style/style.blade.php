@extends('template.index')
@section('content')


<div class="card">
    <div class="card-body">
        <x-message/>
        <form action="{{route('style.styleData')}}" method="POST">
            @csrf
            <div class="row g-3 align-items-center">
        
                <div class="col-auto">
                  <label for="style_no" class="col-form-label">Style No</label>
                </div>
                <div class="col-auto">
                  <input type="text" name="style_no" id="style_no" placeholder="Style No" class="form-control" aria-describedby="passwordHelpInline">
                </div>
        
                <div class="col-auto">
                  <span id="passwordHelpInline" class="form-text">
                    <button type="submit" class="btn btn-success">Submit</button>
                  </span>
                </div>
              </div>
            
          </form>

    </div>
</div>
@endsection