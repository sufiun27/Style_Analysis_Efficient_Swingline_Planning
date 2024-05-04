@extends('template.index')
@section('content')



<div class="card">
    {{-- {{$exporters}} --}}

    <div class="card-body">
        <div class="card-title">
            <h5>Style Analysis</h5>
        </div>
        <hr>
        <table class="table">
            <thead>
                <tr>
                    <th>Features</th>
                    <th>Details</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Processes Details</td>
                    <td>Details about processes in a styles.</td>
                </tr>

                <tr>
                    <td>Comparison</td>
                    <td>Compare two styles to find the similarity index.</td>
                </tr>

                <tr>
                    <td>Matrix Analysis</td>
                    <td>Compare multiple styles to find the similarity matrix.</td>
                </tr>

                <tr>
                    <td>Sequential Analysis</td>
                    <td>Based on reference style, show the similarity index for other styles in descending order.</td>
                </tr>

                <tr>
                    <td>Heretical Analysis</td>
                    <td>Based on reference style, show the similarity index for other styles by finding the best matching sequence.</td>
                </tr>

                <tr>
                    <td>All Heretical Analysis</td>
                    <td>Show the similarity index for each style with other styles by finding the best matching sequence and showing the full sequence average similarity.</td>
                </tr>

                <tr>
                    <td>Lines Wise Heretical Analysis</td>
                    <td>Finding the best matching sequence for multiple lines based on the running reference style and making an optimal style loading sequence.</td>
                </tr>
            </tbody>
        </table>
    </div>

    <div class="card-footer">
        <span>Developed By: Abu Sufiun - abu.sufiun@hoplun.com - BD IT </span>
    </div>
</div>

@endsection