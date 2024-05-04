@extends('template.index')
@section('content')





<div class="card">
    
    <div class="card-body">
        <div class="card-title">
            <h4>Style Informations : Referance: {{$ref['Style_No']}}</h4>            
        </div>   


<div class="row">
<div class="col-4 border-right">
    
    <p>Style No: {{$com['Style_No']}}</p>
    <p>Type: {{$com['Type']}}</p>
    <p>Styling: {{$com['Styling']}}</p>
    <p>Prepared By Date: {{$com['Prepared_By_Date']}}</p>
    <p>Confirm By Date: {{$com['Confirm_By_Date']}}</p>
    {{-- <p>Api hit Count: {{$hitCounter}}</p> --}}
</div>


<div class="col-8">

    <div class="row">
        <div class="col-12"><div id="outputD"></div><br></div>
        
        <div class="col-6">
            <div class="row">

                <div class="col-6 ">
                    <span id="total_process"></span>
                    
                    <hr>
                    
                    <span class="text-success">Full Match</span>
                    <br>
                    <span>Total</span>
                    <span id="full_match"></span>
                    <br>
                    <span>Manual</span>
                    <span id="full_match_manual"></span>
                    <span id="full_match_manual_p"></span>
                    <br>
                    <span>Solder Strip</span>
                    <span id="ss_full"></span>
                    <span id="ss_full_p"></span>
                   
                    <hr>

                    <span class="text-warning" >Partial Match</span>
                    <br>
                    <span>Total</span>
                    <span id="partial_match"></span>
                    <br>
                    <span>Manual</span>
                    <span id="partial_match_manual"></span>
                    <span id="partial_match_manual_p"></span>
                    <br>
                    <span>Solder Strip</span>
                    <span id="ss_partial"></span>
                    <span id="ss_partial_p"></span>
                    
                    <hr>
                   
                    <span class="text-danger" id="not_match"></span>
                    <br>
                    <span> &nbsp;&nbsp; </span>
                </div>

                <div class="col-6 ">
                    <div id="piechart"></div>
                    <br>
                </div>
                
                
            </div>
            

        </div>
            

</div>

</div>{{--row--}}


<div class="row">
 <div class="table-responsive">
    <table class="table table-sm table-bordered">
        <thead>
            <tr class="table-primary">
                <th>Sequence</th>
                {{-- <th>OperationMap_Code</th> --}}
                <th >Operation_Step_OR_Process_Description</th>
                {{-- <th>Title_Additional_Description</th> --}}
                <th>Sewing_Machine</th>
                <th>Factory_Machine_Name</th>
                <th>Accessories</th>
                <th>Presser_Foot</th>
                <th>Needle</th>
                <th>Bottom_Surface</th>
                <th>Stitch_3cm</th>
                <th>Needle_Stitch_Width</th>
                <th>Seam_Allowance</th>
                <th>Percentage</th>
                {{-- <th>Sewing_Instruction</th> --}}
            </tr>
        </thead>

        <tbody>

        @php
            $full=0;
            $partial=0;
            $not=0;
            $manual=0;
            $manual_full=0;
            $manual_partial=0;
            $solder_strip_full=0;
            $solder_strip_partial=0;
        @endphp

        <tr><td id="outputA" colspan="14"></td></tr>
            
        

        @foreach ( $com['Detail'] as $c)
            @foreach ( $ref['Detail'] as $r)
            @if (
                (
                    ($c['OperationMap_Code'] == $r['OperationMap_Code']) || 
                    ($c['OperationMap_Code'] == null && $r['OperationMap_Code'] == null)
                ) &&
                (
                    ($c['Sewing_Machine'] == $r['Sewing_Machine']) ||
                    ($c['Sewing_Machine'] == null && $r['Sewing_Machine'] == null)
                ) &&
                (
                    ($c['Factory_Machine_Name'] == $r['Factory_Machine_Name']) ||
                    ($c['Factory_Machine_Name'] == null && $r['Factory_Machine_Name'] == null)
                ) &&
                (
                    ($c['Accessories'] == $r['Accessories']) ||
                    ($c['Accessories'] == null && $r['Accessories'] == null)
                ) &&
                (
                    ($c['Presser_Foot'] == $r['Presser_Foot']) ||
                    ($c['Presser_Foot'] == null && $r['Presser_Foot'] == null)
                ) &&
                (
                    ($c['Needle'] == $r['Needle']) ||
                    ($c['Needle'] == null && $r['Needle'] == null)
                ) &&
                (
                    ($c['Stitch_3cm'] == $r['Stitch_3cm']) ||
                    ($c['Stitch_3cm'] == null && $r['Stitch_3cm'] == null)
                ) &&
                (
                    ($c['Needle_Stitch_Width'] == $r['Needle_Stitch_Width']) ||
                    ($c['Needle_Stitch_Width'] == null && $r['Needle_Stitch_Width'] == null)
                ) &&
                (
                    ($c['Seam_Allowance'] == $r['Seam_Allowance']) ||
                    ($c['Seam_Allowance'] == null && $r['Seam_Allowance'] == null)
                ) 
            )

                @php
                    $full++;
                @endphp
                
                @if (substr($c['Sequence'], 0, 2) == 'SS')
                @php
                     $solder_strip_full++;
                @endphp
                @endif

                @if ($c['Sewing_Machine'] == 'Manual')
                    @php
                        $manual++;
                        $manual_full++;
                    @endphp
                
                
                

                <tr class="table-secondary">
                    <td>{{$c['Sequence']}}</td>
                    {{-- <td>{{$c['OperationMap_Code']}}</td> --}}
                    <td>{{$c['Description']}}</td>
                    {{-- <td>{{$c['Title_Additional_Description']}}</td> --}}
                    <td>{{$c['Sewing_Machine']}}</td>
                    <td>{{$c['Factory_Machine_Name']}}</td>
                    <td>{{$c['Accessories']}}</td>
                    <td>{{$c['Presser_Foot']}}</td>
                    <td>{{$c['Needle']}}</td>
                    <td>{{$c['Bottom_Surface']}}</td>
                    <td>{{$c['Stitch_3cm']}}</td>
                    <td>{{$c['Needle_Stitch_Width']}}</td>
                    <td>{{$c['Seam_Allowance']}}</td>
                    {{-- <td>{{$c['Sewing_Instruction']}}</td> --}}
                    <td>
                        <div class="bg-danger">
                            <div class="bg-success text-light progress-bar" style="height:35px;width:100%">100%</div>
                        </div>
                    </td>
                </tr>
                @else
                
                <tr class="table-success">
                    <td>{{$c['Sequence']}}</td>
                    {{-- <td>{{$c['OperationMap_Code']}}</td> --}}
                    <td>{{$c['Description']}}</td>
                    {{-- <td>{{$c['Title_Additional_Description']}}</td> --}}
                    <td>{{$c['Sewing_Machine']}}</td>
                    <td>{{$c['Factory_Machine_Name']}}</td>
                    <td>{{$c['Accessories']}}</td>
                    <td>{{$c['Presser_Foot']}}</td>
                    <td>{{$c['Needle']}}</td>
                    <td>{{$c['Bottom_Surface']}}</td>
                    <td>{{$c['Stitch_3cm']}}</td>
                    <td>{{$c['Needle_Stitch_Width']}}</td>
                    <td>{{$c['Seam_Allowance']}}</td>
                    {{-- <td>{{$c['Sewing_Instruction']}}</td> --}}
                    <td>
                        <div class="bg-danger">
                            <div class="bg-success text-light progress-bar" style="height:25px;width:100%">100%</div>
                        </div>
                    </td>
                </tr>
                
                @endif
                
            @endif
                                                    
            @endforeach
        @endforeach
       
        
        {{-- <tr>
            <td colspan="14">
                Manual: {{$manual}}
            </td>
        </tr> --}}

        @php
            $row=0;
        @endphp

        <tr><td id="outputB" colspan="14"></td></tr>

        @foreach ( $com['Detail'] as $c)
            @foreach ( $ref['Detail'] as $r)
            
            @if (
                    ($c['OperationMap_Code'] == $r['OperationMap_Code']) || 
                    ($c['OperationMap_Code'] == null && $r['OperationMap_Code'] == null)
            )
                @if (
                (
                    ($c['Sewing_Machine'] == $r['Sewing_Machine']) ||
                    ($c['Sewing_Machine'] == null && $r['Sewing_Machine'] == null)
                ) &&
                (
                    ($c['Factory_Machine_Name'] == $r['Factory_Machine_Name']) ||
                    ($c['Factory_Machine_Name'] == null && $r['Factory_Machine_Name'] == null)
                ) &&
                (
                    ($c['Accessories'] == $r['Accessories']) ||
                    ($c['Accessories'] == null && $r['Accessories'] == null)
                ) &&
                (
                    ($c['Presser_Foot'] == $r['Presser_Foot']) ||
                    ($c['Presser_Foot'] == null && $r['Presser_Foot'] == null)
                ) &&
                (
                    ($c['Needle'] == $r['Needle']) ||
                    ($c['Needle'] == null && $r['Needle'] == null)
                ) &&
                (
                    ($c['Stitch_3cm'] == $r['Stitch_3cm']) ||
                    ($c['Stitch_3cm'] == null && $r['Stitch_3cm'] == null)
                ) &&
                (
                    ($c['Needle_Stitch_Width'] == $r['Needle_Stitch_Width']) ||
                    ($c['Needle_Stitch_Width'] == null && $r['Needle_Stitch_Width'] == null)
                ) &&
                (
                    ($c['Seam_Allowance'] == $r['Seam_Allowance']) ||
                    ($c['Seam_Allowance'] == null && $r['Seam_Allowance'] == null)
                )
                )
                @else
                @php
                    $partial++; 
                @endphp

                @if (substr($c['Sequence'], 0, 2) == 'SS')
                @php
                    $solder_strip_partial++;
                @endphp
                @endif

                @if ($c['Sewing_Machine'] == 'Manual')
                @php
                    $manual++;
                    $manual_partial++;
                @endphp
                <tr class="table-secondary">
                    <td >{{$c['Sequence']}}</td>
                    {{-- <td >{{$c['OperationMap_Code']}}</td> --}}
                    <td >{{$c['Description']}}</td>
                    {{-- <td >{{$c['Title_Additional_Description']}}</td> --}}
                    <td @if($c['Sewing_Machine'] != $r['Sewing_Machine']) class="text-danger"             @php $col1=0; @endphp @else @php $col1=1; @endphp @endif>{{$c['Sewing_Machine']}}</td>
                    <td @if($c['Factory_Machine_Name'] != $r['Factory_Machine_Name']) class="text-danger" @php $col2=0; @endphp @else @php $col2=1; @endphp @endif>{{$c['Factory_Machine_Name']}}</td>
                    <td @if($c['Accessories'] != $r['Accessories']) class="text-danger"                   @php $col3=0; @endphp @else @php $col3=1; @endphp @endif>{{$c['Accessories']}}</td>
                    <td @if($c['Presser_Foot'] != $r['Presser_Foot']) class="text-danger"                 @php $col4=0; @endphp @else @php $col4=1; @endphp @endif>{{$c['Presser_Foot']}}</td>
                    <td @if($c['Needle'] != $r['Needle']) class="text-danger"                             @php $col5=0; @endphp @else @php $col5=1; @endphp @endif>{{$c['Needle']}}</td>
                    <td @if($c['Bottom_Surface'] != $r['Bottom_Surface']) class="text-danger"             @php $col6=0; @endphp @else @php $col6=1; @endphp @endif>{{$c['Bottom_Surface']}}</td>
                    <td @if($c['Stitch_3cm'] != $r['Stitch_3cm']) class="text-danger"                     @php $col7=0; @endphp @else @php $col7=1; @endphp @endif>{{$c['Stitch_3cm']}}</td>
                    <td @if($c['Needle_Stitch_Width'] != $r['Needle_Stitch_Width']) class="text-danger"   @php $col8=0; @endphp @else @php $col8=1; @endphp @endif>{{$c['Needle_Stitch_Width']}}</td>
                    <td @if($c['Seam_Allowance'] != $r['Seam_Allowance']) class="text-danger"             @php $col9=0; @endphp @else @php $col9=1; @endphp @endif>{{$c['Seam_Allowance']}}</td>
                    {{-- <td>{{$c['Sewing_Instruction']}}</td> --}}
                    @php
                      $pp= $col1 + $col2 + $col3 + $col4 + $col5 + $col6 + $col7 + $col8 + $col9;
                      $pp= $pp/9*100;
                      $pp=number_format($pp, 2);
                   @endphp
                    <td>
                        <div class="bg-danger">
                            <div class="bg-success text-light progress-bar" style="height:25px;width:{{$pp}}%">{{$pp}}%</div>
                        </div>
                    </td>
                    {{-- <td>{{ $col1 . $col2 . $col3 . $col4 . $col5 . $col6 . $col7 . $col8 . $col9 }}</td> --}}
                    @php $row = $row + $col1+$col2+$col3+$col4+$col5+$col6+$col7+$col8+$col9; @endphp
                </tr>
                @else

                <tr class="table-warning">
                    <td >{{$c['Sequence']}}</td>
                    {{-- <td >{{$c['OperationMap_Code']}}</td> --}}
                    <td >{{$c['Description']}}</td>
                    {{-- <td >{{$c['Title_Additional_Description']}}</td> --}}
                    <td @if($c['Sewing_Machine'] != $r['Sewing_Machine']) class="text-danger"             @php $col1=0; @endphp @else @php $col1=1; @endphp @endif>{{$c['Sewing_Machine']}}</td>
                    <td @if($c['Factory_Machine_Name'] != $r['Factory_Machine_Name']) class="text-danger" @php $col2=0; @endphp @else @php $col2=1; @endphp @endif>{{$c['Factory_Machine_Name']}}</td>
                    <td @if($c['Accessories'] != $r['Accessories']) class="text-danger"                   @php $col3=0; @endphp @else @php $col3=1; @endphp @endif>{{$c['Accessories']}}</td>
                    <td @if($c['Presser_Foot'] != $r['Presser_Foot']) class="text-danger"                 @php $col4=0; @endphp @else @php $col4=1; @endphp @endif>{{$c['Presser_Foot']}}</td>
                    <td @if($c['Needle'] != $r['Needle']) class="text-danger"                             @php $col5=0; @endphp @else @php $col5=1; @endphp @endif>{{$c['Needle']}}</td>
                    <td @if($c['Bottom_Surface'] != $r['Bottom_Surface']) class="text-danger"             @php $col6=0; @endphp @else @php $col6=1; @endphp @endif>{{$c['Bottom_Surface']}}</td>
                    <td @if($c['Stitch_3cm'] != $r['Stitch_3cm']) class="text-danger"                     @php $col7=0; @endphp @else @php $col7=1; @endphp @endif>{{$c['Stitch_3cm']}}</td>
                    <td @if($c['Needle_Stitch_Width'] != $r['Needle_Stitch_Width']) class="text-danger"   @php $col8=0; @endphp @else @php $col8=1; @endphp @endif>{{$c['Needle_Stitch_Width']}}</td>
                    <td @if($c['Seam_Allowance'] != $r['Seam_Allowance']) class="text-danger"             @php $col9=0; @endphp @else @php $col9=1; @endphp @endif>{{$c['Seam_Allowance']}}</td>
                    {{-- <td>{{$c['Sewing_Instruction']}}</td> --}}
                   @php
                      $pp= $col1 + $col2 + $col3 + $col4 + $col5 + $col6 + $col7 + $col8 + $col9;
                      $pp= $pp/9*100;
                      $pp=number_format($pp, 2);
                   @endphp
                    <td>
                        <div class="bg-danger">
                            <div class="bg-success text-light progress-bar" style="height:25px;width:{{$pp}}%">{{$pp}}%</div>
                        </div>
                    </td>
                    
                    
                    {{-- <td>{{ $col1 . $col2 . $col3 . $col4 . $col5 . $col6 . $col7 . $col8 . $col9 }}</td> --}}
                    @php $row = $row + $col1+$col2+$col3+$col4+$col5+$col6+$col7+$col8+$col9; @endphp
                </tr>

                @endif
                    
                @endif
                
                
            @endif
                                                    
            @endforeach
        @endforeach

        
        <tr><td id="outputC" colspan="14"></td></tr>

        @foreach ($com['Detail'] as $c)
            @php
                $matchFound = false;
            @endphp

            @foreach ($ref['Detail'] as $r)
                @if ($c['OperationMap_Code'] == $r['OperationMap_Code'])
                    @php
                        $matchFound = true;
                        break; // No need to continue checking once a match is found
                    @endphp
                @endif
            @endforeach

            @if (!$matchFound)
                @php
                    $not++;
                @endphp

                <tr class="table-danger">
                    <td>{{$c['Sequence']}}</td>
                    {{-- <td>{{$c['OperationMap_Code']}}</td> --}}
                    <td>{{$c['Description']}}</td>
                    {{-- <td>{{$c['Title_Additional_Description']}}</td> --}}
                    <td>{{$c['Sewing_Machine']}}</td>
                    <td>{{$c['Factory_Machine_Name']}}</td>
                    <td>{{$c['Accessories']}}</td>
                    <td>{{$c['Presser_Foot']}}</td>
                    <td>{{$c['Needle']}}</td>
                    <td>{{$c['Bottom_Surface']}}</td>
                    <td>{{$c['Stitch_3cm']}}</td>
                    <td>{{$c['Needle_Stitch_Width']}}</td>
                    <td>{{$c['Seam_Allowance']}}</td>
                    {{-- <td>{{$c['Sewing_Instruction']}}</td> --}}
                    <td>
                        <div class="bg-danger">
                            <div class="bg-success text-light progress-bar" style="height:25px;width:0%">0%</div>
                        </div>
                    </td>
                </tr>
            @endif
        @endforeach


        

    </tbody>{{--tbody--}}       
    </div> {{--table--}}
</table>  {{--table-responsive--}} 
</div>{{--row--}}

<div class="row">
    <div class="col">
        @php
        $total=$full*9;
        $total=$total+$row;

        $percent= ($total/(($full+$partial+$not)*9))*100;
        $percent=number_format($percent, 2);
        @endphp
        <div class="bg-danger">
            <div class="bg-success text-light progress-bar" style="height:35px;width:{{$percent}}%">Match {{$percent}}%</div>
        </div>
    </div>
    {{-- <div class="col">
        <h1>Full {{$manual_full}}</h1>
        <h1>Partial {{$manual_partial}}</h1>
        <h4>ss full {{ $solder_strip_full}}</h4>
        <h4>ss partial {{ $solder_strip_partial}}</h4>

    </div> --}}
</div>

    </div>
</div>





<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script>
    // Variables
    let fullManual={{$manual_full}};
    let partialManual={{$manual_partial}};
    var a = {{$full}};
    var b = {{$partial}};
    var c = {{$not}};
    var d = {{$percent}};

    // Display the full match and partial match counts

    document.getElementById("total_process").innerHTML = 'Total Process: ' + (a+b+c);
    document.getElementById("full_match").innerHTML = '' + a ;
    document.getElementById("partial_match").innerHTML = '' + b ;
    document.getElementById("not_match").innerHTML = 'Not Match: ' + c ;

    document.getElementById("full_match_manual").innerHTML = ' : ' + fullManual + ' | T - ' + (100 * fullManual / a).toFixed(2) + '%' ;
    document.getElementById("partial_match_manual").innerHTML = ' : ' + partialManual + ' | T - ' + (100 * partialManual / b).toFixed(2) + '%';
    document.getElementById("ss_full").innerHTML = ' : ' + {{$solder_strip_full}} + ' | T - ' + (100 * {{$solder_strip_full}} / a).toFixed(2) + '%';
    document.getElementById("ss_partial").innerHTML = ' : ' + {{$solder_strip_partial}} + ' | T - ' + (100 * {{$solder_strip_partial}} / b).toFixed(2) + '%';


        document.getElementById("outputA").innerHTML =  ' Full Match : '+a;
        document.getElementById("outputB").innerHTML =  ' Partial Match '+b;
        document.getElementById("outputC").innerHTML =  ' Not Match '+c;
        document.getElementById("outputD").innerHTML ='<div class="bg-danger"><div class="bg-success text-light progress-bar" style="height:35px;width:' + d + '%"> Match: ' + d + '%</div></div>';

</script>

<script type="text/javascript">
    // Load google charts
    google.charts.load('current', {'packages':['corechart']});
    google.charts.setOnLoadCallback(drawChart);
    
    // Draw the chart and set the chart values
    function drawChart() {
        var a = {{$full*9}};
        var b = {{$partial*9}};
        var c = {{$not*9}};
        
        var p ={{$row}};
        c = c + (b - p);
        var t= a+b+c;
    
        var d = {{$percent}};
        var e = 100 - d;
    
        var f = ((p/(a+b+c))*100);
        var g = ((c/(a+b+c))*100);
        var h = ((a/(a+b+c))*100);
    
        // Ensure that e and d are numbers
        f = parseFloat(f);
        g = parseFloat(g);
        h = parseFloat(h);

        document.getElementById("full_match_manual_p").innerHTML = ' | F - ' + ((h*fullManual) / (a/9)).toFixed(2) + '%';
        document.getElementById("partial_match_manual_p").innerHTML = ' | F - ' + ((f*partialManual) / (b/9)).toFixed(2) + '%';
        document.getElementById("ss_full_p").innerHTML = ' | F - ' + ((h*{{$solder_strip_full}}) / (a/9)).toFixed(2) + '%';
        document.getElementById("ss_partial_p").innerHTML = ' | F - ' + ((f*{{$solder_strip_partial}}) / (b/9)).toFixed(2) + '%';

    
        // Create the data table
        var data = google.visualization.arrayToDataTable([
            ['Task', 'Percentage'],
            ['Full Match', h],
            ['Partial Match', f],
            ['Not Match', g],
        ]);
    
        // Optional; add a title and set the width and height of the chart
        var options = {
            'width': 400,
            'height': 200,
            'chartArea': {'width': '100%', 'height': '100%', 'left': 0, 'top': 0},
            'margin': 0,
            'padding': 0,
            'pieHole': 0.1, // Optional: Adds a hole in the center for a donut chart effect
            'colors': ['green','orange', 'red'], // Set custom colors for 'Full Match' and 'Not Match'
        };
    
        // Display the chart inside the <div> element with id="piechart"
        var chart = new google.visualization.PieChart(document.getElementById('piechart'));
        chart.draw(data, options);
    }
    </script>
@endsection