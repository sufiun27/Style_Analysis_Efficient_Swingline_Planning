@extends('template.index')
@section('content')




<div class="card">
    <div class="card-body">
     <div class="card-title">Style Comparison</div>
        <x-message/>
        <form action="{{route('style.compare')}}" method="POST">
            @csrf
            <div class="row g-3 align-items-center">
        
                <div class="col-auto">
                  <label for="referance" class="col-form-label">Referance</label>
                </div>
                <div class="col-auto">
                  <input type="text" name="referance" id="referance" placeholder="Style No" class="form-control" aria-describedby="passwordHelpInline">
                </div>
        
                <div class="col-auto">
                    <label for="compare" class="col-form-label">Compare</label>
                  </div>
                  <div class="col-auto">
                    <input type="text" name="compare" id="compare" class="form-control" placeholder="Style No" aria-describedby="passwordHelpInline">
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