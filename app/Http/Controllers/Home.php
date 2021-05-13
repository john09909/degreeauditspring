<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session;

class Home extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        //
    }

    public function index()
    {       
        $data = [];
        $this->load->view("landing_page", $data);
    }  

    public function freshman(Request $request){
        if($request->student_id2 && !Session::get('student_id')){
            Session::put('student_id', $request->student_id2);
        }
        
        $student_id = Session::get('student_id');
        $page_id = 3;
        $pages = \DB::table('courses')->where('id',3)->get();
        $main_div = \DB::table('future_comet')->where(['page_id' => 3,'main_div'=>'yes','student_id'=>'sample'])->orderBy('year','desc')->get();
        $other_div = \DB::table('future_comet')->where(['page_id' => 3,'main_div'=>'no','student_id'=>'sample'])->orderBy('sort_order','asc')->get();


        return view('main')->with('student_id',$student_id)->with('pages',$pages)->with('page_id',$page_id)->with('main_div',$main_div)->with('other_div',$other_div);
    }

    function check_is_numeric($num = false){
        if(is_numeric($num)){
            return true;
        }

        return false;
    }

    function print_array($arr){
        echo "<pre>"; print_r($arr); die;    
    }

    function begining_of_sheet($delem , $str = false){
        return explode($delem, $str)[1];
    }

    function get_first_year($str=false){
        return explode('Record', $str);
    }

    function getAllYear($arr = false){
        $defined_Arr = ['2018','2019','2020','2021','2022'];
        $defined_Arr_Names = ['Spring','Fall','Summer'];

        $year_raw_data = preg_split('/\s+/', $arr);
        //$this->print_array($year_raw_data);
        $years_data = [];
        if($year_raw_data){
            foreach ($year_raw_data as $key=>$value) {
                if(in_array($value, $defined_Arr) && in_array($year_raw_data[$key+1], $defined_Arr_Names) ){
                    $years_data[] = $value.' '.$year_raw_data[$key+1];
                }
            }
        }

        return $years_data;
    }

    function findOneYear($string = false){
        $defined_Arr = ['2018','2019','2020','2021','2022'];
        $defined_Arr_Names = ['Spring','Fall','Summer'];

        $year_raw_data = preg_split('/\s+/', $string);
        //$this->print_array($year_raw_data);
        $year = '';
        if($year_raw_data){
            foreach ($year_raw_data as $key=>$value) {
                if(in_array($value, $defined_Arr) && in_array($year_raw_data[$key+1], $defined_Arr_Names) ){
                    $year = $value.' '.$year_raw_data[$key+1];
                }
            }
        }

        return $year;
    }
}
