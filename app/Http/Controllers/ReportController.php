<?php

namespace App\Http\Controllers;

use App\Models\Part;
use App\Models\PartTarget;
use Illuminate\Http\Request;
use App\Models\AppraisalScore;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class ReportController extends Controller
{
    // public function __construct()
    // {
    //     $this->middleware('auth');
    // }

    public function index()
    {
        $parts = Part::all();

        return view('report.index', [
            'parts' => $parts,
        ]);
    }

    public function self()
    {
        $parts = Part::all();
        $user_id = Auth::user()->id;
        $part_target_first = PartTarget::where('part_id', 1)->get();
        $part_target_second = PartTarget::where('part_id', 2)->get();
        $part_target_third = PartTarget::where('part_id', 3)->get();
        $part_target_fourth = PartTarget::where('part_id', 4)->get();
        $part_target_fifth = PartTarget::where('part_id', 5)->get();
        // dd($part_target_first);
        /* ----- ด้าน 1 ----- */
        $score_first = DB::select("
        SELECT part_target.part_target_id
           , part_target.part_target_order
            , part_target.part_target_name
            , sum(appraisal_score_score) / COUNT(appraisal_score.part_target_id) AS sum_score
        FROM part_target
        LEFT JOIN appraisal_score ON part_target.part_target_id = appraisal_score.part_target_id
        WHERE part_id = 1 and appraisal_score.created_by =  $user_id
        GROUP BY part_target.part_target_id
           ,part_target.part_target_order
            , part_target.part_target_name
        ");
        
        $total_first = 0;
        $arrLabels_first = [];
        $arrSumScore_first = [];

        foreach ($score_first as $value) {
            $total_first += $value->sum_score;

            array_push($arrLabels_first, $value->part_target_order);
            array_push($arrSumScore_first, $value->sum_score);
        }

        $data_first = [
            'labels' => $arrLabels_first,
            'data' => $arrSumScore_first,
        ];

        /* ----- ด้าน 2 ----- */
        $score_second = DB::select("
        SELECT 
            part_target.part_target_order
            , part_target.part_target_name
            , sum(appraisal_score_score) / COUNT(appraisal_score.part_target_id) AS sum_score
        FROM part_target
        LEFT JOIN appraisal_score ON part_target.part_target_id = appraisal_score.part_target_id
        WHERE part_id = 2 and appraisal_score.created_by =  $user_id
        GROUP BY 1,2
        ");
        
        $total_second = 0;
        $arrLabels_second = [];
        $arrSumScore_second = [];

        foreach ($score_second as $value) {
            $total_second += $value->sum_score;

            array_push($arrLabels_second, $value->part_target_order);
            array_push($arrSumScore_second, $value->sum_score);
        }

        $data_second = [
            'labels' => $arrLabels_second,
            'data' => $arrSumScore_second,
        ];

        /* ----- ด้าน 3 ----- */
        $score_third = DB::select("
        SELECT 
            part_target.part_target_order
            , part_target.part_target_name
            , sum(appraisal_score_score) / COUNT(appraisal_score.part_target_id) AS sum_score
        FROM part_target
        LEFT JOIN appraisal_score ON part_target.part_target_id = appraisal_score.part_target_id
        WHERE part_id = 3 and appraisal_score.created_by =  $user_id
        GROUP BY 1,2
        ");
        
        $total_third = 0;
        $arrLabels_third = [];
        $arrSumScore_third = [];

        foreach ($score_third as $value) {
            $total_third += $value->sum_score;

            array_push($arrLabels_third, $value->part_target_order);
            array_push($arrSumScore_third, $value->sum_score);
        }

        $data_third = [
            'labels' => $arrLabels_third,
            'data' => $arrSumScore_second,
        ];

        /* ----- ด้าน 4 ----- */
        $score_fourth = DB::select("
        SELECT 
            part_target.part_target_order
            , part_target.part_target_name
            , sum(appraisal_score_score) / COUNT(appraisal_score.part_target_id) AS sum_score
        FROM part_target
        LEFT JOIN appraisal_score ON part_target.part_target_id = appraisal_score.part_target_id
        WHERE part_id = 4 and appraisal_score.created_by =  $user_id
        GROUP BY 1,2
        ");
        
        $total_fourth = 0;
        $arrLabels_fourth = [];
        $arrSumScore_fourth = [];

        foreach ($score_fourth as $value) {
            $total_fourth += $value->sum_score;

            array_push($arrLabels_fourth, $value->part_target_order);
            array_push($arrSumScore_fourth, $value->sum_score);
        }

        $data_fourth = [
            'labels' => $arrLabels_fourth,
            'data' => $arrSumScore_second,
        ];

        /* ----- ด้าน 5 ----- */
        $score_fifth = DB::select("
        SELECT 
            part_target.part_target_order
            , part_target.part_target_name
            , sum(appraisal_score_score) / COUNT(appraisal_score.part_target_id) AS sum_score
        FROM part_target
        LEFT JOIN appraisal_score ON part_target.part_target_id = appraisal_score.part_target_id
        WHERE part_id = 5 and appraisal_score.created_by =  $user_id
        GROUP BY 1,2
        ");
        
        $total_fifth = 0;
        $arrLabels_fifth = [];
        $arrSumScore_fifth = [];

        foreach ($score_fifth as $value) {
            $total_fifth += $value->sum_score;

            array_push($arrLabels_fifth, $value->part_target_order);
            array_push($arrSumScore_fifth, $value->sum_score);
        }

        $data_fifth = [
            'labels' => $arrLabels_fifth,
            'data' => $arrSumScore_second,
        ];

        return view('report.self', [
            'parts' => $parts,
            'part_target_first' => $part_target_first,
            'part_target_second' => $part_target_second,
            'part_target_third' => $part_target_third,
            'part_target_fourth' => $part_target_fourth,
            'part_target_fifth' => $part_target_fifth,
            'total_first' => $total_first,
            'score_first' => $score_first,
            'data_first' => $data_first,
            'total_second' => $total_second,
            'score_second' => $score_second,
            'data_second' => $data_second,
            'total_third' => $total_third,
            'score_third' => $score_third,
            'data_third' => $data_third,
            'total_fourth' => $total_fourth,
            'score_fourth' => $score_fourth,
            'data_fourth' => $data_fourth,
            'total_fifth' => $total_fifth,
            'score_fifth' => $score_fifth,
            'data_fifth' => $data_fifth,
        ]);
    }
    
    public function part($id)
    {
        $part = Part::all();
        $score = DB::select("
        SELECT 
            part_target.part_target_order
            , part_target.part_target_name
            , sum(appraisal_score_score) / COUNT(appraisal_score.part_target_id) AS sum_score
        FROM part_target
        LEFT JOIN appraisal_score ON part_target.part_target_id = appraisal_score.part_target_id
        WHERE part_id = $id
        GROUP BY 1,2
        ");
        
        $total = 0;
        $arrLabels = [];
        $arrSumScore = [];

        foreach ($score as $value) {
            $total += $value->sum_score;

            array_push($arrLabels, $value->part_target_order);
            array_push($arrSumScore, $value->sum_score);
        }

        $data = [
            'labels' => $arrLabels,
            'data' => $arrSumScore,
        ];

        return view('report.self', [
            'part' => $part,
            'total' => $total,
            'score' => $score,
            'data' => $data,
            'part_id' => $id,
        ]);
    }

    public function partFirst()
    {
        // $part = Part::where('part_id', 1)->get();
        $score = DB::select("
        SELECT 
            part_target.part_target_order
            , part_target.part_target_name
            , sum(appraisal_score_score) / COUNT(appraisal_score.part_target_id) AS sum_score
        FROM part_target
        LEFT JOIN appraisal_score ON part_target.part_target_id = appraisal_score.part_target_id
        WHERE part_id = 1
        GROUP BY 1,2
        ");
        
        $total = 0;
        $arrLabels = [];
        $arrSumScore = [];

        foreach ($score as $value) {
            $total += $value->sum_score;

            array_push($arrLabels, $value->part_target_order);
            array_push($arrSumScore, $value->sum_score);
        }

        $data = [
            'labels' => $arrLabels,
            'data' => $arrSumScore,
        ];

        // return view('report.part', [
        //     'part' => $part,
        //     'total' => $total,
        //     'score' => $score,
        //     'data' => $data,
        // ]);
    }

    public function partSecond()
    {
        $part = Part::where('part_id', 2)->get();
        $score = DB::select("
        SELECT 
            part_target.part_target_order
            , part_target.part_target_name
            , sum(appraisal_score_score) / COUNT(appraisal_score.part_target_id) AS sum_score
        FROM part_target
        LEFT JOIN appraisal_score ON part_target.part_target_id = appraisal_score.part_target_id
        WHERE part_id = 2
        GROUP BY 1,2
        ");

        $total = 0;
        $arrLabels = [];
        $arrSumScore = [];

        foreach ($score as $value) {
            $total += $value->sum_score;

            array_push($arrLabels, $value->part_target_order);
            array_push($arrSumScore, $value->sum_score);
        }

        $data = [
            'labels' => $arrLabels,
            'data' => $arrSumScore,
        ];

        return view('report.part', [
            'part' => $part,
            'total' => $total,
            'score' => $score,
            'data' => $data,
        ]);
    }

    public function partThird()
    {
        $part = Part::where('part_id', 3)->get();
        $score = DB::select("
        SELECT 
            part_target.part_target_order
            , part_target.part_target_name
            , sum(appraisal_score_score) / COUNT(appraisal_score.part_target_id) AS sum_score
        FROM part_target
        LEFT JOIN appraisal_score ON part_target.part_target_id = appraisal_score.part_target_id
        WHERE part_id = 3
        GROUP BY 1,2
        ");

        $total = 0;
        $arrLabels = [];
        $arrSumScore = [];

        foreach ($score as $value) {
            $total += $value->sum_score;

            array_push($arrLabels, $value->part_target_order);
            array_push($arrSumScore, $value->sum_score);
        }

        $data = [
            'labels' => $arrLabels,
            'data' => $arrSumScore,
        ];

        return view('report.part', [
            'part' => $part,
            'total' => $total,
            'score' => $score,
            'data' => $data,
        ]);
    }

    public function partFourth()
    {
        $part = Part::where('part_id', 4)->get();
        $score = DB::select("
        SELECT 
            part_target.part_target_order
            , part_target.part_target_name
            , sum(appraisal_score_score) / COUNT(appraisal_score.part_target_id) AS sum_score
        FROM part_target
        LEFT JOIN appraisal_score ON part_target.part_target_id = appraisal_score.part_target_id
        WHERE part_id = 4
        GROUP BY 1,2
        ");

        $total = 0;
        $arrLabels = [];
        $arrSumScore = [];

        foreach ($score as $value) {
            $total += $value->sum_score;

            array_push($arrLabels, $value->part_target_order);
            array_push($arrSumScore, $value->sum_score);
        }

        $data = [
            'labels' => $arrLabels,
            'data' => $arrSumScore,
        ];

        return view('report.part', [
            'part' => $part,
            'total' => $total,
            'score' => $score,
            'data' => $data,
        ]);
    }

    public function partFifth()
    {
        $part = Part::where('part_id', 5)->get();
        $score = DB::select("
        SELECT 
            part_target.part_target_order
            , part_target.part_target_name
            , sum(appraisal_score_score) / COUNT(appraisal_score.part_target_id) AS sum_score
        FROM part_target
        LEFT JOIN appraisal_score ON part_target.part_target_id = appraisal_score.part_target_id
        WHERE part_id = 5
        GROUP BY 1,2
        ");

        $total = 0;
        $arrLabels = [];
        $arrSumScore = [];

        foreach ($score as $value) {
            $total += $value->sum_score;

            array_push($arrLabels, $value->part_target_order);
            array_push($arrSumScore, $value->sum_score);
        }

        $data = [
            'labels' => $arrLabels,
            'data' => $arrSumScore,
        ];

        return view('report.part', [
            'part' => $part,
            'total' => $total,
            'score' => $score,
            'data' => $data,
        ]);
    }
}
