<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Cache;


class StyleController extends Controller
{
    
    public function styleData($style_no)
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
    
    
    public function style(){
        return view('style.style');
    }

    public function styleDetails(Request $request){
        $request->validate([
            'style_no' => 'required',
        ]);

        $style=$request->style_no;
        $data = $this->styleData($style);
        
        if (empty($data)) {
            return view('style.notification')
            ->with('error', 'Cna not found this style number: [ '.$style.', ] Please put correct one.');
        }
        
         return view('style.styleData',compact('data'));
    }
    
    public function compare(Request $request){

        
        $request->validate([
            'referance' => 'required',
            'compare' => 'required',
        ]);

        
        $referance=$request->referance;
        $compare=$request->compare;
        $ref = $this->styleData($referance);
        $com= $this->styleData($compare);

        if (empty($ref)) {
            return view('style.notification')
            ->with('error', 'Cna not found this referance style number: [ '.$request->referance.' ] Please put correct one.');
        }elseif(empty($com)){
            return view('style.notification')
            ->with('error', 'Cna not found this compare style number: [ '.$request->compare.' ] Please put correct one.');
        }
        
        return view('style.compare',compact('ref','com'));

    }



    public function analysis(){
        return view('style.analysis');
    }



    public function styleAnalysis(Request $request){
        
        set_time_limit(60*2);
        $styles = array();
        $compact=$request->styles;
        // Split the string into an array based on line breaks
        $stylesArray = explode("\n", $request->styles);
        // $stylesArray length
        $length = count($stylesArray);

        if (empty($compact)) {
            return redirect()->back()->with('error', 'can not be empty');
        }
        
        if ($length > 20 || $length < 1) {
            return redirect()->back()->with('error', 'Please enter a valid style number between 1 and 20');
        }
        

        // Loop through the array and append each style to the $styles array
        foreach ($stylesArray as $style) {
            // Trim any leading or trailing whitespaces
            $style = trim($style);
            

            // Check if the style is not empty
            if (!empty($style)) {

                $data=$this->styleData($style);
                 
            if (empty($data)) {
                return view('style.notification')
                ->with('error', 'Cna not found this style number: [ '.$style.', ] Please put correct one.');
            }
                $styles[] = $style; // Append the style to the $styles array
            }
        }

        return view('style.styleAnalysis', compact('styles','length'));

    }


    public function line(){
        return view('style.line');
    }

    public function lineAnalysis(Request $request){

        set_time_limit(80);
        $styles = array();

        // Split the string into an array based on line breaks
        $stylesArray = explode("\n", $request->styles);
        // $stylesArray length
        $length = count($stylesArray);

        if (empty($stylesArray)) {
            return redirect()->back()->with('error', 'Please enter valid style numbers and not more than 10');
        }
        if ($length > 10 || $length < 1) {
            return redirect()->back()->with('error', 'Please enter valid style numbers and not more than 10');
        }

        // Loop through the array and append each style to the $styles array
        foreach ($stylesArray as $style) {
            // Trim any leading or trailing whitespaces
            $style = trim($style);
            

            // Check if the style is not empty
            if (!empty($style)) {

                $data=$this->styleData($style);
            if (empty($data)) {
                return redirect()->back()->with('error', 'Style No : '.$style.' Not found');
            }
                $styles[] = $style; // Append the style to the $styles array
            }
        }

        return view('style.lineAnalysis',compact('styles'));
    }

    public function lineSimple(){
        return view('style.lineSimple');
    }
    public function lineSimpleAnalysis(Request $request){
        set_time_limit(80);
        $styles = array();

        // Split the string into an array based on line breaks
        $stylesArray = explode("\n", $request->styles);
        // $stylesArray length
        $length = count($stylesArray);

        if (empty($stylesArray)) {
            return redirect()->back()->with('error', 'Please enter valid style numbers and not more than 10');
        }
        if ($length > 10 || $length < 1) {
            return redirect()->back()->with('error', 'Please enter valid style numbers and not more than 10');
        }

        // Loop through the array and append each style to the $styles array
        foreach ($stylesArray as $style) {
            // Trim any leading or trailing whitespaces
            $style = trim($style);
            

            // Check if the style is not empty
            if (!empty($style)) {

                $data=$this->styleData($style);
            if (empty($data)) {
                return redirect()->back()->with('error', 'Style No : '.$style.' Not found');
            }
                $styles[] = $style; // Append the style to the $styles array
            }
        }

        return view('style.lineSimpleAnalysis',compact('styles'));
    }


    public function sequence(){
        return view('style.sequence');
    }
    public function sequenceAnalysis(Request $request){
        set_time_limit(80);
        $styles = array();

        // Split the string into an array based on line breaks
        $stylesArray = explode("\n", $request->styles);
        // $stylesArray length
        $length = count($stylesArray);

        if (empty($stylesArray)) {
            return redirect()->back()->with('error', 'Please enter valid style numbers and not more than 10');
        }
        if ($length > 10 || $length < 1) {
            return redirect()->back()->with('error', 'Please enter valid style numbers and not more than 10');
        }

        // Loop through the array and append each style to the $styles array
        foreach ($stylesArray as $style) {
            // Trim any leading or trailing whitespaces
            $style = trim($style);
            

            // Check if the style is not empty
            if (!empty($style)) {

                $data=$this->styleData($style);
            if (empty($data)) {
                return redirect()->back()->with('error', 'Style No : '.$style.' Not found');
            }
                $styles[] = $style; // Append the style to the $styles array
            }
        }

        return view('style.sequenceAnalysis',compact('styles'));
    }
    

    //multiLine
    public function multiLine(){
        return view('style.multiLine');
    }

    //multiLineAnalysis
    public function multiLineAnalysis(Request $request){
        //dd($request->all()  );
        set_time_limit(80);
        $styles = array();
        $referance=array();
        $line=array();
        // Split the string into an array based on line breaks
        $stylesArray = explode("\n", $request->styles);
        $referanceArray = collect(explode("\n", $request->input('referances')))
                            ->map(function ($reference) {
                                return trim($reference) !== '' ? trim($reference) : null;
                            })
                            ->toArray();
        if (in_array(null, $referanceArray)) {
            return redirect()->back()->with('error', 'Referance can not be empty');
        }
        $lineArray = explode("\n", $request->lines);
        // $stylesArray length
        $lengthStyle = count($stylesArray);
        $lengthReferance=count($referanceArray);
        $lengthLine=count($lineArray);

        // echo 's-'.$lengthStyle.'<br>';
        // echo 'r-'.$lengthReferance.'<br>';
        // echo 'l-'.$lengthLine.'<br>';
        // echo'<hr>';

        // print_r($stylesArray);
        // echo'<hr>';
         //print_r($referanceArray);
        // echo'<hr>';
        // print_r($lineArray);
        // echo'<hr>';
        function checkForNull($array) {
            foreach ($array as $key => $value) {
                if ($value === null) {
                    return redirect()->back()->with('error', 'Referance can not be empty');
                }
            }
            return $array;
        }
        $referanceArray=checkForNull($referanceArray);

        if ($lengthLine != $lengthReferance) {
            //echo 'Line and Referance must be equal';
            return redirect()->back()->with('error', 'Style and Referance must be equal');
        }
        if (empty($request->styles)||empty($request->styles)||empty($request->styles)) { 
              //echo 'Line , Style and Referance can not be empty';
            return redirect()->back()->with('error', 'Line , Style and Referance can not be empty');
        }
        if($lengthStyle+$lengthReferance>20){
            //echo 'Total can not be more than 20';
            return redirect()->back()->with('error', 'Combinely Total Style & Referance can not be more than 20');
        }

        // Loop through the array and append each style to the $styles array
        foreach ($stylesArray as $style) {
            // Trim any leading or trailing whitespaces
            $style = trim($style);
            
            // Check if the style is not empty
            if (!empty($style)) {

                $data=$this->styleData($style);
            if (empty($data)) {
                return redirect()->back()->with('error', 'Style No : '.$style.' Not found');
            }
                $styles[] = $style; // Append the style to the $styles array
            }
        }

        foreach ($referanceArray as $ref) {
            // Trim any leading or trailing whitespaces
            $ref = trim($ref);
            
            // Check if the style is not empty
            if (!empty($ref)) {

                $data=$this->styleData($ref);
            if (empty($data)) {
                return redirect()->back()->with('error', 'Style No : '.$ref.' Not found');
            }
                $referance[] = $ref; // Append the style to the $styles array
            }
        }

        // echo'<hr>';
        // print_r($styles);
        // echo'<hr>';
        // print_r($referance);
        // echo'<hr>';
        

        return view('style.multiLineAnalysis',compact('styles','referance', 'referanceArray','lineArray'));

    }

    


    public function language($language){

        Session::put('locale', $language);
       
        return view('dashboard');
    }

    public function cache()
    {
        $Key = 'style_data_'.session('locale').'018-NN-00201';  
        $data = Cache::get($Key);
        //convert this data in to jason
         $data = json_encode($data);

        return $data;
    }



}
