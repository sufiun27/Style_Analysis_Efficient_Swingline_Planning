@extends('template.index')
@section('content')





<x-message/>
<div class="card">
    <div class="card-body">
        <div class="card-title"><h4>All Heretical Analysis</h4> </div>
        <div class="container mt-5">
            
            <form id="inputForm" action="{{ route('style.sequenceAnalysis') }}" method="get">
                @csrf
                <div class="row">
                    <div class="col-8">
                        <div class="form-outline" data-mdb-input-init>
                            <textarea class="form-control" id="textAreaExample" name="styles" rows="4"></textarea>
                            <label class="form-label" for="textAreaExample">Styles</label>
                        </div>
                    </div>
                    
                    <div class="col-4">
                        <div class="form-outline" >
                            <label class="form-label" for="textAreaExample1">Styles: Input Example</label>
                            <p>Style 1 : take it as reference </p>
                            <p>Style 2</p>
                            <p>Style 3</p>
                            <p>Style 4</p>
                            <p>Please input multiple styles, each on a new line.</p>
                        </div>
                    </div>
                
                </div>
                <div class="form-group mt-3">
                    <button type="submit" class="btn btn-success" id="submitButton">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    // Initialization for ES Users
    import { Input, initMDB } from "mdb-ui-kit";
    initMDB({ Input });
</script>

@endsection
