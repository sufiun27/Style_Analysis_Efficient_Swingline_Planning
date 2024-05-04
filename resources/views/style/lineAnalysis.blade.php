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


<div class="table-responsive">
    <table class="table">



        

<tr>
       <?php
       $arrayLength = count($styles);
?>
        <tr>
            <th class="table-warning"><h4>Reference</h4></th>
            <th class="table-primary text-center" colspan="{{$arrayLength}}-1"><h4>Sequence</h4></th>
        </tr>
<?php      
       $r=$styles[$arrayLength-$arrayLength];
    echo "<th class=\"table-success\"> <h4>".$r."<h4> </th>";
       do {
                
            $height = array();
                foreach ($styles as $c) {
                    if ($r === $c) {
                        continue;
                    }
                    
                    $percent = analysis($r, $c);
                    $height[$c] = $percent;
                }
                if (!empty($height)) {
                    $maxValue = max($height);
                    $maxKey = array_search($maxValue, $height);
                    $percentage = $maxValue;
?>

<form action="{{route('style.compare')}}" method="post">
    @csrf
    <input hidden readonly type="text" name="referance" value="{{$r}}">
    <input hidden readonly type="text" name="compare" value="{{$maxKey}}">
    <th @if($percentage== 100 )style="background-color:rgba(0, 200, 0,{{$percentage/100}})" @elseif($percentage< 50 )style="background-color:rgba(250, 100, 94,{{1-$percentage/100}}) " @else style="background-color:rgba(94, 241, 94,{{$percentage/100}}) " @endif>
        <button type="submit" class="btn" style="width: 100%; height: 100%;">
            {{-- <h5>{{$r}}</h5> --}}
            <h5>{{$maxKey}}</h5>
            <h4>{{$percentage}}%</h4>
        </button>
    </th>
</form>
<?php
                    //echo "r: ".$r." c: ".$maxKey." percentage: ".$percentage."<br>";
                    $temp=$maxKey;
                    $styles = array_diff($styles, array($r, $maxKey));
                    $r=$temp;
                } else {
                    echo "No elements in the array <br>";
                }
            



       } while (!empty($styles));
      // echo $ref;
       ?>
</tr>
</table>
</div>{{--table-responsive--}}



    </div>
</div>






@endsection