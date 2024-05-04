@extends('template.index')
@section('content')





<x-message/>
<div class="card">
    <div class="card-body">
        <div class="card-title"><h4>Lines Wise Heretical Analysis</h4> </div>
        <div class="container mt-5">
            
            <form id="inputForm" action="{{ route('style.multiLineAnalysis') }}" method="get">
                @csrf
                <div class="row">
                    
                    

                    <div class="col-4">
                        <div class="form-outline" data-mdb-input-init>
                            <label class="form-label" for="textAreaExample">Lines</label>
                            <textarea class="form-control" id="textAreaExample" name="lines" rows="4"></textarea> 
                        </div>
                    </div>
                        

                        <div class="col-4">
                            <div class="form-outline" data-mdb-input-init>
                                <label class="form-label" for="textAreaExample">Referance Styles</label>
                                <textarea class="form-control" id="textAreaExample" name="referances" rows="4"></textarea> 
                            </div>
                        </div>
                        
                        <div class="col-4">
                        
                            <div class="form-outline" data-mdb-input-init>
                                <label class="form-label" for="textAreaExample">Styles</label>
                                <textarea class="form-control" id="textAreaExample" name="styles" rows="10"></textarea> 
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
