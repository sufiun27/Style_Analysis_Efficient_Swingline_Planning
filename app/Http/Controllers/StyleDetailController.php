<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\StyleDetail;

class StyleDetailController extends Controller
{
    public function styleComparison(Request $request)
    {
        
        $request->validate([
            'referance' => 'required|exists:style_details,style_no',
            'compare' => 'required|exists:style_details,style_no'
        ]);

        $style_no=[
            'referance' => $request->referance,
            'compare' => $request->compare
        ];

        $sql = "SELECT
            style_no,
            operation_map_code,
            description,
            sewing_machine_match, sewing_machine,
            factory_machine_name_match, factory_machine_name,
            accessories_match, accessories,
            presser_foot_match, presser_foot,
            needle_match, needle,
            bottom_by_surface_match, bottom_by_surface,
            stitch_by_3cm_match, stitch_by_3cm,
            needle_stitch_width_match, needle_stitch_width,
            seam_allowance_match, seam_allowance,
    
            (sewing_machine_match + factory_machine_name_match 
            + accessories_match + presser_foot_match + needle_match + bottom_by_surface_match 
            + stitch_by_3cm_match + needle_stitch_width_match + seam_allowance_match) AS partial_match_total
        FROM (
            SELECT
                sd1.style_no,
                sd1.operation_map_code,
                CASE
                    WHEN (sd1.sewing_machine = sd2.sewing_machine) OR (sd1.sewing_machine IS NULL AND sd2.sewing_machine IS NULL) THEN 1 ELSE 0 END AS sewing_machine_match,
                CASE
                    WHEN (sd1.factory_machine_name = sd2.factory_machine_name) OR (sd1.factory_machine_name IS NULL AND sd2.factory_machine_name IS NULL) THEN 1 ELSE 0 END AS factory_machine_name_match,
                CASE
                    WHEN (sd1.accessories = sd2.accessories) OR (sd1.accessories IS NULL AND sd2.accessories IS NULL) THEN 1 ELSE 0 END AS accessories_match,
                CASE
                    WHEN (sd1.presser_foot = sd2.presser_foot) OR (sd1.presser_foot IS NULL AND sd2.presser_foot IS NULL) THEN 1 ELSE 0 END AS presser_foot_match,
                CASE
                    WHEN (sd1.needle = sd2.needle) OR (sd1.needle IS NULL AND sd2.needle IS NULL) THEN 1 ELSE 0 END AS needle_match,
                CASE
                    WHEN (sd1.bottom_by_surface = sd2.bottom_by_surface) OR (sd1.bottom_by_surface IS NULL AND sd2.bottom_by_surface IS NULL) THEN 1 ELSE 0 END AS bottom_by_surface_match,
                CASE
                    WHEN (sd1.stitch_by_3cm = sd2.stitch_by_3cm) OR (sd1.stitch_by_3cm IS NULL AND sd2.stitch_by_3cm IS NULL) THEN 1 ELSE 0 END AS stitch_by_3cm_match,
                CASE
                    WHEN (sd1.needle_stitch_width = sd2.needle_stitch_width) OR (sd1.needle_stitch_width IS NULL AND sd2.needle_stitch_width IS NULL) THEN 1 ELSE 0 END AS needle_stitch_width_match,
                CASE
                    WHEN (sd1.seam_allowance = sd2.seam_allowance) OR (sd1.seam_allowance IS NULL AND sd2.seam_allowance IS NULL) THEN 1 ELSE 0 END AS seam_allowance_match,
                sd2.sewing_machine,
                sd2.factory_machine_name,
                sd2.needle_stitch_width,
                sd2.accessories,
                sd2.presser_foot,
                sd2.needle,
                sd2.bottom_by_surface,
                sd2.stitch_by_3cm,
                sd2.seam_allowance,
                sd2.description
    
            FROM
                style_details AS sd1
            INNER JOIN
                style_details AS sd2 ON sd1.operation_map_code = sd2.operation_map_code
            WHERE 
                    sd1.style_no = '$request->referance'
                AND sd2.style_no = '$request->compare'
        ) AS subquery";
        
        $sql2="SELECT DISTINCT 
        sd1.operation_map_code,
        sd1.style_no,
        sd1.description,
        sd1.sewing_machine,
        sd1.factory_machine_name,
        sd1.accessories,
        sd1.presser_foot,
        sd1.needle,
        sd1.bottom_by_surface,
        sd1.stitch_by_3cm,
        sd1.needle_stitch_width,
        sd1.seam_allowance
        
    FROM style_details AS sd1 
    WHERE sd1.style_no = '$request->referance'
    AND NOT EXISTS (
        SELECT 1
        FROM style_details AS sd2 
        WHERE sd2.operation_map_code = sd1.operation_map_code 
        AND sd2.style_no = '$request->compare'
    )";
        $row = \DB::select($sql);
        $row2= $row;
        $row3 = \DB::select($sql2);

        return view('styleComparison.styleComparison', compact('row','row2','row3','style_no'));
    }

    public function styleAnalysis(Request $request){

       $styles=$request->styles;    
       
      return view('styleComparison.styleAnalysis', compact('styles'));
      
    }

    public function select(){

        $styles = StyleDetail::select('style_no')->distinct()->get();
        
        return view('styleComparison.select', compact('styles'));
  
        
      }
    
    
}
