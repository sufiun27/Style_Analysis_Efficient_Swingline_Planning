@extends('template.index')
@section('content')

<x-message/>

<div class="card">
    <div class="card-body">
        <x-message/>
        <form action="{{ route('style.styleData') }}" method="POST">
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

<div class="card">
    <div class="card-body">
        <div class="card-title"><h4>Style Information</h4></div>

        @if ($data !== null)
        <div class="card">
          <div class="card-header">Style No: {{ $data['Style_No'] }}</div>
          <ul class="list-group list-group-flush">
            <li class="list-group-item">Type: {{ $data['Type'] }}</h5></li>
            <li class="list-group-item">Styling: {{ $data['Styling'] }}</li>
            <li class="list-group-item">Prepared By Date: {{ $data['Prepared_By_Date'] }}</li>
            <li class="list-group-item">Confirm By Date: {{ $data['Confirm_By_Date'] }}</li>

          </ul>
        </div>

            <h5>Details</h5>
            <hr>
            <div class="row bg-warning">
                @foreach ($data['Detail'] as $detail)
                    <div class="col-4 ">
                        <div 
                        @if ($detail['Sewing_Machine']  == 'Manual')
                        class="card bg-secondary"
                        @else
                        class="card bg-success"
                        @endif
                        >
                            <div class="card-header">{{ $detail['Sequence'] }}</div>
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item"><h5>Operation {{ $detail['Sequence'] }}</h5></li>
                                <li class="list-group-item"><p>Operation Map Code: {{ $detail['OperationMap_Code'] }}</p></li>
                                <li class="list-group-item"><p>Sewing Machine: {{ $detail['Sewing_Machine'] }}</p></li>
                                <li class="list-group-item"><p>Description: {{ $detail['Description'] }}</p></li>
                                <li class="list-group-item"><p>Additional Description: {{ $detail['Title_Additional_Description'] }}</p></li>
                                <li class="list-group-item"><p>Accessories: {{ $detail['Accessories'] }}</p></li>
                                <li class="list-group-item"><p>Presser Foot: {{ $detail['Presser_Foot'] }}</p></li>
                                <li class="list-group-item"><p>Needle: {{ $detail['Needle'] }}</p></li>
                                <li class="list-group-item"><p>Bottom Surface: {{ $detail['Bottom_Surface'] }}</p></li>
                                <li class="list-group-item"><p>Stitch 3cm: {{ $detail['Stitch_3cm'] }}</p></li>
                                <li class="list-group-item"><p>Needle Stitch Width: {{ $detail['Needle_Stitch_Width'] }}</p></li>
                                <li class="list-group-item"><p>Seam Allowance: {{ $detail['Seam_Allowance'] }}</p></li>
                                <li class="list-group-item"><p>Sewing Instruction: {{ $detail['Sewing_Instruction'] }}</p></li>
                            </ul>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <p>Failed to fetch data from API.</p>
        @endif

    </div>
</div>
@endsection
