@extends('template.index')
@section('content')

@php
set_time_limit(180);
use Illuminate\Support\Facades\Http;

global $hitCounterinner;
$hitCounterinner=0;

function styleData($style_no)
    {
        $cacheKey = 'style_data_'.session('locale'). $style_no;

        // Check if data is present in the cache
        if (Cache::has($cacheKey)) {
            // Retrieve data from the cache
            $data = Cache::get($cacheKey);
        } else {
            // If not in cache, fetch data from API
            $apiUrl = "http://10.20.200.52/restapi/aio/production/SewingOperationbyStyle?Style_No=".$style_no."&Language=".session('locale');

            // Fetch data from API
            $response = file_get_contents($apiUrl);

            // Decode JSON response
            $data = json_decode($response, true);

            // Store data in the cache for 60 minutes (adjust as needed)
            Cache::put($cacheKey, $data, 60*60*24);
        }

        

        return $data;
    }

function analysis($referance,$compare){
            $ref=styleData($referance);
            $com=styleData($compare);
            $full=0;
            $partial=0;
            $row=0;
            $not=0;


            foreach ( $com['Detail'] as $c){
                $matchFound = false;
               foreach ( $ref['Detail'] as $r){
                if($c['OperationMap_Code'] == $r['OperationMap_Code']){
                    $matchFound = true;
                    if (
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
                    ) {
    
                  
                        $full++;
                    }//if end for full comparison
                    else {
                        $partial++;
                        $col1 = ($c['Sewing_Machine'] != $r['Sewing_Machine']) ? 0 : 1;
                        $col2 = ($c['Factory_Machine_Name'] != $r['Factory_Machine_Name']) ? 0 : 1;
                        $col3 = ($c['Accessories'] != $r['Accessories']) ? 0 : 1;
                        $col4 = ($c['Presser_Foot'] != $r['Presser_Foot']) ? 0 : 1;
                        $col5 = ($c['Needle'] != $r['Needle']) ? 0 : 1;
                        $col6 = ($c['Bottom_Surface'] != $r['Bottom_Surface']) ? 0 : 1;
                        $col7 = ($c['Stitch_3cm'] != $r['Stitch_3cm']) ? 0 : 1;
                        $col8 = ($c['Needle_Stitch_Width'] != $r['Needle_Stitch_Width']) ? 0 : 1;
                        $col9 = ($c['Seam_Allowance'] != $r['Seam_Allowance']) ? 0 : 1;
                    
                       // $pp = $col1 + $col2 + $col3 + $col4 + $col5 + $col6 + $col7 + $col8 + $col9;
                    
                        $row = $row + $col1 + $col2 + $col3 + $col4 + $col5 + $col6 + $col7 + $col8 + $col9;
                    }//else end for partial comparison
                    
                } //end if
                else{

                }
                                                   
               }//inner loop end

               if (!$matchFound){ $not++; }
                
                
            }//outer loop end full comparison

            $percentage = ((($full*9)+ $row) / ( ($full *9) + ($partial*9) + ($not*9) )) * 100;
            $percentage = round($percentage, 2);
            return $percentage;
        } //analysis function end
        
        //print_r($styles);
        
@endphp






<div class="card">
    <div class="card-body">
        <div class="card-title">
            {{-- <h3>from controller api count : {{$hitCounter}}</h3>
            <h3>from inner function api count : {{$hitCounterinner}}</h3> --}}
        </div>




       <?php
       $allDetails=[];
       $refCount=0;
       $tempStyle='';
       $c=0;
do{
        $arrayLengthStyle = count($styles);
        $arrayLengthLine = count($lineArray);
        $arrayLengthReferance = count($referanceArray);        

        //$analysis = array();
        $sequence = [];

        for ($i = 0; $i < $arrayLengthLine; $i++) { //outer loop for lines
            
            
                $percentages = [];
                   
                for ($j = 0; $j < $arrayLengthStyle; $j++) { //inner loop for styles

                    if($refCount==0){
                        $lastCompare = $referanceArray[$i];
                        $percentage = analysis($referanceArray[$i], $styles[$j]);
                    }else{
                        $dataAll=$allDetails;
                        $line=$lineArray[$i];

                        $resultsALL = array_filter($dataAll, function ($item) use ($line) {
                            return $item['line'] == $line;
                        });
                        $resultsALL = array_values($resultsALL);
                        $last = end($resultsALL);
                        $lastCompare = $last['compare'];

                        $percentage = analysis($lastCompare, $styles[$j]);
                    }
                    
                    $percentages[$styles[$j]] = $percentage;
                }
        
                arsort($percentages);

                $percentage = collect($percentages)->first();
                $compare = collect($percentages)->keys()->first();
                $searchValue = $compare;
                $style = $compare;
                $ref=$lastCompare;

               // echo"count".$i."lineno:".$lineArray[$i]." searchValue: ".$searchValue." <br>";
                    
                    if (in_array($searchValue, array_column($sequence, 'compare'))) {
                        
                        $index = array_search($searchValue, array_column($sequence, 'compare'));

                        if ($sequence[$index]['percentage'] < $percentage) {
                           // echo "if index: ".$index." <br>";
                            
                            //print_r( $sequence[$index]);

                            $allcompare=$sequence[$index]['compare'];
                            //atfirst delete index then add new value
                            unset($sequence[$index]);
                            //reindex array
                            $sequence = array_values($sequence);

                            $sequence[] = [
                                'line'      => $lineArray[$i],
                                'referance' => $ref,
                                'compare'   => $style,
                                'percentage'=> $percentage
                            ];
                           // echo"if compare:".$style."percentage:".$percentage." <br>";

                            $index = array_search($allcompare, array_column($allDetails, 'compare'));
                            unset($allDetails[$index]);
                            $allDetails = array_values($allDetails);

                            $allDetails[]=[
                                'line'      => $lineArray[$i],
                                'referance' => $ref,
                                'compare'   => $style,
                                'percentage'=> $percentage
                            ];
                            
                        } else {}

                        
                    } else {

                        $sequence[] = [
                            'line'      => $lineArray[$i],
                            'referance' => $ref,
                            'compare'   => $style,
                            'percentage'=> $percentage
                        ];
                       // echo"else compare:".$style."percentage:".$percentage." <br>";
                        $allDetails[]=[
                                'line'      => $lineArray[$i],
                                'referance' => $ref,
                                'compare'   => $style,
                                'percentage'=> $percentage
                            ];

                            
                           
                    }
        
                   
             
        }//end reference foreach
        
        // Function to print array in tabular form
        
            // echo "<table border='1' class='table'>";
            // echo "<tr><th>Line</th><th>Reference</th><th>Compare</th><th>Percentage</th></tr>";
            // foreach ($sequence as $row) {
            //     echo "<tr>";
            //     echo "<td>" . $row['line'] . "</td>";
            //     echo "<td>" . $row['referance'] . "</td>";
            //     echo "<td>" . $row['compare'] . "</td>";
            //     echo "<td>" . $row['percentage'] . "</td>";
            //     echo "</tr>";

                
            // }
            //     echo"<tr><pre>";
            //         print_r($styles);
            //     echo"</pre></tr>";

            // echo "</table>";
        
            $compareValues = array_column($sequence, "compare");
            $filteredStylesArray = array_diff($styles, $compareValues);
            $filteredStylesArray = array_values($filteredStylesArray);
            $styles=$filteredStylesArray;
            
            
           $refCount++;
        } while (!empty($styles));
        ?>
<?php

$data=$allDetails;

$count=0;
foreach ($lineArray as $line) {

$results = array_filter($data, function ($item) use ($line) {
    return $item['line'] == $line;
});

$results = array_values($results);

?>
<div class="table-responsive">
<table class="table table-striped">
    <tr>
        <th style="width: 150px; background-color:rgb(142, 241, 241)" class="table-primary"><b>{{$line}}</b></th>
        <th style="width: 150px" class="table-warning"><b>{{$referanceArray[$count]}}</b></th>
        @foreach($results as $result)

        <th> 
        
        {{-- R: {{$result['referance']}} <br> C: {{$result['compare']}} <br> P: {{$result['percentage']}} --}}

        <form action="{{route('style.compare')}}" method="post">
            @csrf
            <input hidden readonly type="text" name="referance" value="{{$result['referance']}}">
            <input hidden readonly type="text" name="compare" value="{{$result['compare']}}">
            @php $percentage=$result['percentage']; @endphp
            <div class="comparison-cell" 
             @if($percentage== 100 )style=" background-color:rgba(0, 200, 0,{{$percentage/100}})"
             @elseif($percentage<50 )style=" background-color:rgba(250, 100, 94,{{1-$percentage/100}}) " 
             @else style=" background-color:rgba(94, 241, 94,{{$percentage/100}}) " @endif
             >
                <button type="submit" class="btn" style="width: 100%; height: 100%;">
                    {{-- <h5>{{$r}}</h5> --}}
                    <h5>{{$result['compare']}}</h5>
                    <h4>{{$percentage}}%</h4>
                </button>
            </div>
            
        </form>
        
    </th>
        @endforeach
    </tr>
</table>
</div>
<?php
$count++;
}

?>






    </div>
</div>






@endsection