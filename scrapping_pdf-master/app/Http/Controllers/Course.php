<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session;
use URL;


class Course extends Controller
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
        return redirect()->route('page', ['page_id' => 1]);
    }

    public function page(Request $request)
    {  
        $student_id = $request->student_id;
        $page_id = 3;

        $pages = \DB::table('courses')->where('id',3)->get();

        if($student_id=='freshman'){
            $main_div = \DB::table('future_comet')->where(['page_id' => 3,'main_div'=>'yes','student_id'=>'sample'])->orderBy('year','desc')->get();
            $other_div = \DB::table('future_comet')->where(['page_id' => 3,'main_div'=>'no','student_id'=>'sample'])->orderBy('sort_order','asc')->get();

        }else{
            $main_div = \DB::table('top_courses')->where(['page_id' => $page_id,'main_div'=>'yes','student_id'=>$student_id])->get();
            $other_div = \DB::table('top_courses')->where(['page_id' => $page_id,'main_div'=>'no','student_id'=>$student_id])->get();
        }

        return view('main')->with('student_id',$student_id)->with('pages',$pages)->with('page_id',$page_id)->with('main_div',$main_div)->with('other_div',$other_div);
    }

    public function see_details($user_id = false)
    {       
        $page_id = 3;
        $pages = $this->Courses_model->getPageList();
        $data = array();
        $data['pages'] = $pages;
        $data['page_id'] = $page_id;
        $student_id = Session::get('student_id');

        $data['main_div'] = $this->db->get_where('top_courses', array('page_id' => $page_id,'main_div'=>'yes','student_id'=>$student_id))->result();
        $data['other_div'] = $this->db->get_where('top_courses', array('page_id' => $page_id,'main_div'=>'no','student_id'=>$student_id))->result();

        //print_r($data['main_div']); die;
        $this->load->view("index", $data);
    }

    public function delete_div($div_id, $page_id, Request $request){
        $student_id = Session::get('student_id');
        $status = \DB::table('top_courses')->where(['student_id'=>$student_id,'div_id'=>$div_id,'page_id'=>$page_id])->delete();

        echo $status; die;
    }

    public function max_div_id(Request $request){
        $page_id = $request->page_id;
        $student_id = $request->student_id;

        $result = \DB::table('top_courses')->where('student_id',$student_id)->where('page_id',$page_id)->orderBy('year','desc')->first();

        $total = \DB::table('top_courses')->where('student_id',$student_id)->where('page_id',$page_id)->count();

        if(!empty($result)){
            $data = array(
                 'page_id' => $page_id,
                 'main_div' => 'no',
                 'div_id' => $result->div_id + 1,
                 'student_id' => $student_id,
                 'year' => $result->year + 1,
                 'div_1_year' => $result->year + 1,
                 'div_2_year' => $result->year + 2,
                 'div_3_year' => $result->year + 2
                );
            \DB::table('top_courses')->insert($data);
            return response()->json(['div_id' => $result->div_id, 'year' => $result->year + 1,'total' => $total + 1,'div_1_year'=>$result->year + 1,'div_2_year'=>$result->year + 2,'div_3_year'=>$result->year + 2]);
        }else{
            $data = array(
                 'page_id' => $page_id,
                 'main_div' => 'no',
                 'div_id' => 1,
                 'student_id' => $student_id,
                 'year' => $result->year + 1,
                 'div_1_year' => $result->year + 1,
                 'div_2_year' => $result->year + 2,
                 'div_3_year' => $result->year + 2
                );
            \DB::table('top_courses')->insert($data);

            return response()->json(['div_id' => 1, 'year' => $result->year + 1,'total' => $total + 1,'div_1_year'=>$result->year + 1,'div_2_year'=>$result->year + 2,'div_3_year'=>$result->year + 2]);
        }
    }
    
    /**
     * This function is used to load the user list
     */
    function save_callback(Request $request)
    {
        //print_r(URL::current()); die;
        /*print_r($this->input->post());return;*/
        $page_id = $request->input('page_id');
        if($request->input('card_element')){
            $card_element = $request->input('card_element');
        }else{
            $card_element = [];
        }
        
        $main_div = $request->input('main_div');
        $div_type = $request->input('div_type');
        $div_id = $request->input('div_id');
        if($request->input('last_segment') && $request->input('last_segment')=="freshman"){
            $student_id = 'sample';
        }else{
            $student_id = $request->input('student_id');
        }

        $query = \DB::table('top_courses')->where(['page_id'=>$page_id,'div_id'=>$div_id])->first();
        
        if($query){
            if($div_type=='div_1'){
                $data = array(
                 'page_id' => $page_id,
                 'main_div' => $main_div,
                 'div_id' => $div_id,
                 'div_1' => serialize($card_element),
                 'student_id'=> $student_id
                 );
            }else if($div_type=='div_2'){
                $data = array(
                 'page_id' => $page_id,
                 'main_div' => $main_div,
                 'div_id' => $div_id,
                 'div_2' => serialize($card_element),
                 'student_id'=> $student_id
                 );
            }else{
                $data = array(
                 'page_id' => $page_id,
                 'main_div' => $main_div,
                 'div_id' => $div_id,
                 'div_3' => serialize($card_element),
                 'student_id'=>$student_id
                 );
            }

            \DB::table('top_courses')->where(['div_id'=>$div_id,'page_id'=>$page_id])->update($data);
        }else{
            if($div_type=='div_1'){
                $data = array(
                 'page_id' => $page_id,
                 'main_div' => $main_div,
                 'div_id' => $div_id,
                 'div_1' => serialize($card_element),
                 'student_id'=> $student_id
                 );
            }else if($div_type=='div_2'){
                $data = array(
                 'page_id' => $page_id,
                 'main_div' => $main_div,
                 'div_id' => $div_id,
                 'div_2' => serialize($card_element),
                 'student_id'=> $student_id
                 );
            }else{
                $data = array(
                 'page_id' => $page_id,
                 'main_div' => $main_div,
                 'div_id' => $div_id,
                 'div_3' => serialize($card_element),
                 'student_id'=> $student_id
                 );
            }

            \DB::table('top_courses')->insert($data);
        }
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
        return @explode($delem, $str)[1];
    }

    function get_first_year($str=false){
        return explode('Record', $str);
    }

    function getAllYear($arr = false){
        $defined_Arr = ['2011','2012','2013','2014','2015','2016','2017','2018','2019','2020','2021','2022','2023','2024'];
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
        $defined_Arr = ['2011','2012','2013','2014','2015','2016','2017','2018','2019','2020','2021','2022','2023','2024'];
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
    
    function findMyYear($str_find){
        $defined_Arr = ['2011','2012','2013','2014','2015','2016','2017','2018','2019','2020','2021','2022','2023','2024'];
        
        $sems = ['Summer','Fall','Spring'];
        
        $str = [];  
        foreach($defined_Arr as $row){
            foreach($sems as $sem){
                $str[] = "{$row} {$sem}";   
            }
        }
        
        foreach($str as $con){
            if (strpos($str_find, $con) !== false) {
                return $con;
            }
        }
        
        return false;
    }
    
    function lastyear(){
        Session::put('last', $request->student_id); 
    }

    function parse_pdf(Request $request){
        Session::put('student_id', $request->student_id); 
        //Session::put('student_id', 23231); 
        $student_id = Session::get('student_id');
        
        //$this->print_array($user_info);
        //die;
        //echo $student_id; die;
        $parser = new \Smalot\PdfParser\Parser();
        //$pdf = $parser->parseFile(URL::asset('public').'/assets/test.pdf');
        $pdf = $parser->parseFile($_FILES['filename']['tmp_name']);
         
        // Retrieve all pages from the pdf file.
        $pages  = $pdf->getText();
        //echo $pages; die;
        $end_string = 'Transfer';
        $start = $this->begining_of_sheet('Beginning',$pages);
        //$this->print_array($start);

        if($start){
            $parts = explode('Grade',$start);
            
            $first_year = $this->get_first_year($start);
            $first_year = preg_split('/\s+/', $first_year[1]);
            $first_year = $first_year[1].' '.$first_year[2];
            
            $find_years = explode('Record',$start);
            $find_years = $this->getAllYear($find_years[1]);

            //print_r($find_years); die;
            array_shift($parts);
            $couses_arr = [];
            $row = [];
            $total = count($parts);
            
            if(is_array($parts)){
                  
                foreach ($parts as $keying=>$value) {
                    if($keying==0){
                        $year = $first_year;
                    }else{
                        $keying = $keying - 1;
                        $year = $this->findMyYear($parts[$keying]);
                        if($year){
                            $year = $year;
                            Session::put('year', $year);
                        }else{
                            $year = Session::get('year');
                        }
                    }   
                    
                    
                   //$this->print_array($value);  
                    //echo "<pre>-----------"; print_r($value); 
                    //echo "----------------";
                   
                   $string_parts = explode(' ', $value);
                   //$this->print_array($string_parts);              
                   
                   if(is_array($string_parts)){
                    //$this->print_array($string_parts);
                    foreach ($string_parts as $keying_met=>$string_parts_value) {
                    $rows_data = explode(' ', $string_parts_value);
                      
                    //echo "<pre>";
                    //print_r($rows_data);
                    //$this->print_array($string_parts_value);  

                    foreach ($rows_data as $key=>$rowing) {
                         $rowing = trim($rowing);
                         $rowing = preg_split('/\s+/', $rowing);
                         
                         if(count($rowing) >= 5){
                            $row[] = $rowing;
                            
                            //$off = $keying - 1;
                            $row[] = array('year'=>$year);
                            $couses_arr[] = $row;
                            $row = [];
                         }else{
                            $row[] = $rowing;
                         }                    
                      } 
                    }
                   }
                }
            }

            //Sometimes not working for transcript files
            $tracing = [];
            if(empty($couses_arr)){
                $first_year = $this->get_first_year($start);
                $first_year = preg_split('/\s+/', $first_year[1]);
                $first_year = $first_year[0].' '.$first_year[1];

                foreach ($parts as $keying=>$value) {
                    if($keying==0){
                        $year = $first_year;
                    }else{
                        $keying = $keying - 1;
                        $year = $this->findMyYear($parts[$keying]);
                        //$this->print_array($year);

                        if($year){
                            $year = $year;
                            Session::put('year', $year);
                        }else{
                            $year = Session::get('year');
                        }
                    } 
                   
                    $string_parts = explode(' ', $value);
                    //$this->print_array($string_parts);
                    
                    if(is_array($string_parts)){
                        foreach ($string_parts as $key => $value) {
                            //$this->print_array($value);
                            $num = preg_match_all( "/[0-9]/", @$value);
                            if($num >=3){
                                $start = $key;
                                $limit = $start + 8;
                                $i = $start;
                                for($i;$i <= $limit; $i++){
                                    if($keying==0){
                                        $tracing[$year][] = @$string_parts[$i]; 
                                    }else{
                                        $tracing[$year][] = @$string_parts[$i]; 
                                    }
                                }
                            }    
                        }
                   }
                }
            }

            $main_arr = [];
            $row = [];  

            //$this->print_array($tracing); 

            /*     
            $year_is_first = '';
            $semester_is_first = '';
            foreach ($couses_arr as $value) {
                foreach ($value as $boat) {
                    if(array_key_exists('year', $boat)){
                        $year_is_first = trim(explode(' ', $boat['year'])[0]);
                        $semester_is_first = trim(explode(' ', $boat['year'])[1]);
                        break;
                    }
                }
            }
            */

            //echo $year_is_first;
            //echo $semester_is_first;
            //die;
            
            if($couses_arr){
                foreach($couses_arr as $row){
                    $insert = array();
                    $where_to_save = '';
                    $course_id = 0;
                    $save_where = '';
                    $attempted = '';
                    $earned = '';

                    //print_r(array_key_exists('year',$row[4])); die;
                    foreach($row as $key=>$item){
                    
                        //$num = preg_match_all( "/[0-9]/", $row[1][0]);
                        //$this->print_array($row[1][0]);
                        $course_name = '';
                        if(is_array($item)){
                            if(count($item) >= 5){
                                $insert[] = $item;
                                $course_name .= $item[0];
                                $attempted = $item[1];
                                $earned = $item[2];
                            }
                        }
                        
                        if($course_id==0){
                            $num = preg_match_all( "/[0-9]/", @$item[0]);
                            if(count($item)==2 && $num >=3){
                                //print_r($row); die;
                                $prefix= '';
                                if(@$row[$key-1][0]=='Points'){
                                    $prefix= @$row[$key-1][1];
                                }else{
                                    $prefix= @$row[$key-1][0];
                                }

                                $iteming = [$prefix.' '.$item[0],$item[1]];
                                $insert[] = $iteming;
                                $course_id = 1;
                            }
                        }
                        
                        if(array_key_exists('year',$row[$key]) && $course_id){
                            $exp = explode(' ',$item['year']);
                            
                            if($exp[1]=='Fall' && $course_id){
                                $insert[] = ['year'=>$exp[0]];
                                $save_where = 'fall';
                            }
                            
                            if($exp[1]=='Summer' && $course_id){
                                $insert[] = ['year'=>$exp[0]];  
                                $save_where = 'summer';
                            }
                            
                            if($exp[1]=='Spring' && $course_id){
                                $insert[] = ['year'=>$exp[0]];
                                $save_where = 'spring';
                            }
                        }
                    }
                    
                    //$this->print_array($couses_arr);   
                    if($course_id==1){
                        if($save_where=='spring'){
                            $course_name = $insert[0][1].' '.$insert[1][0];
                            $marks = ['attempted'=>$attempted,'earned'=>$earned];

                            \DB::table('tem_records')->insert(['student_id'=>$student_id,'course_id'=>$insert[0][0],'spring'=>$course_name,'year'=>$insert[2]['year'],'spring_mark'=>serialize($marks)]);   
                        }
                        
                        if($save_where=='summer'){
                            $course_name = $insert[0][1].' '.$insert[1][0];
                            $marks = ['attempted'=>$attempted,'earned'=>$earned];

                            \DB::table('tem_records')->insert(['student_id'=>$student_id,'course_id'=>$insert[0][0],'summer'=>$course_name,'year'=>$insert[2]['year'],'summer_mark'=>serialize($marks)]);
                        }
                        
                        if($save_where=='fall'){
                            $course_name = $insert[0][1].' '.$insert[1][0];
                            $marks = ['attempted'=>$attempted,'earned'=>$earned];

                            \DB::table('tem_records')->insert(['student_id'=>$student_id,'course_id'=>$insert[0][0],'fall'=>$course_name,'year'=>$insert[2]['year'],'fall_mark'=>serialize($marks)]);   
                        }
                        
                    }
                }
            }

        //\DB::table('top_courses')->where('student_id',$student_id)->delete();
            //$records = \DB::table('tem_records')->where('student_id',$student_id)->get()
            //            ->groupBy(function($val) {
            //            return $val->year;
            //        });

        //$student_id = 'fsdfd43423dscccccc';
        $records = \DB::table('tem_records')->where('student_id',$student_id)->orderBy('id','asc')->get();

        //$this->print_array($records);
        $academic_years = [];            
        foreach($records as $key=>$row){

            if($row->fall!=""){
                $year = $row->year;

                $academic_years[$year][] = $row;    
                if($row->spring !="" || $row->summer!=""){
                    $academic_years[] = $row;    
                }
            }else if($row->summer !="" || $row->spring !=""){
                $academic_years[$year][] = $row;    
            }
        }  

        //$this->print_array($academic_years);

        foreach ($academic_years as $key => $item) {
            $year = $key;
            $fall = [];
            $spring = [];
            $summer = [];

            $div_1_year = '';
            $div_2_year = '';
            $div_3_year = '';

            $div_1_mark = [];
            $div_2_mark = [];
            $div_3_mark = [];

            foreach ($item as $key => $value) {
                if($value->fall!=""){
                    $fall[] = $value->course_id.' '.$value->fall;
                    $div_1_mark[] = $value->fall_mark;
                    $div_1_year = (int) $value->year;                   
                }

                if($value->spring!=""){
                    $spring[] = $value->course_id.' '.$value->spring;
                    $div_2_mark[] = $value->spring_mark;                   
                    $div_2_year = (int) $value->year;                   
                }

                if($value->summer!=""){
                    $summer[] = $value->course_id.' '.$value->summer;
                    $div_3_mark[] = $value->summer_mark;                 
                    $div_3_year = (int) $value->year;                   
                }
            }

            //var_dump($div_3_year); die;
            if($div_1_year==""){
                (int) $div_1_year = (int) $div_2_year - 1;
            }else if($div_2_year==""){
                (int) $div_2_year = (int) $div_1_year + 1;
            }

            if($div_3_year==""){
                $div_3_year = (int) $div_2_year;
            }

            //$this->print_array($fall); die;
            \DB::table('top_courses')->insert(['page_id'=>3,'main_div'=>'no','div_id'=>$value->id+1,'year'=>$year,'div_1'=>serialize($fall),'div_2'=>serialize($spring),'div_3'=>serialize($summer),'student_id'=>$student_id,'div_1_mark'=>serialize($div_1_mark),'div_2_mark'=>serialize($div_2_mark),'div_3_mark'=>serialize($div_3_mark),'div_1_year'=>$div_1_year,'div_2_year'=>$div_2_year,'div_3_year'=>$div_3_year]);
            }

            \DB::table('tem_records')->where('student_id',$student_id)->delete();   
        }

        return redirect('/student/'.$student_id);
    }

    public function red_label_card(Request $request){
        $content = $this->fixedCourses();
        $move_element = $request->course_id;
        $arr = $request->arr;

        foreach($content as $key=>$value1){
            if(trim($key)==trim($move_element)){    
               
               if(array_key_exists('coreq', $value1)){
                    $str = $value1['coreq'];
                    $str = explode(' ', $str);
                    //$this->print_array($str); 
                    if($str){
                        $matched = false;
                        foreach ($arr as $value) {
                            $value = @explode(' ', @$value, 3);
                            $value = @$value[0].@$value[1];
                            $value = @strtolower($value);
                            //echo $value; die;
                            foreach ($str as $key => $value_matched) {
                                //$value_matched = filter_var($value_matched, FILTER_SANITIZE_NUMBER_INT);
                                $value_matched = $this->clean($value_matched);
                                $value_matched = strtolower($value_matched);

                                if($value_matched && ($value==$value_matched)){
                                    $matched = true;
                                }
                            }
                        }

                        //var_dump($matched); die;
                        if($matched){
                            exit(false);
                        }else{
                            exit(true);
                        }
                        
                    }else{
                        exit(false);
                    }
               }

               if(array_key_exists('prereq', $value1)){

                    $str = $value1['prereq'];
                    $str = explode(' ', $str);
                    //print_r($str); die;
                    if($str){
                        $matched = false;
                        foreach ($arr as $value) {
                            //echo $value; die;
                            $value = @explode(' ', @$value, 3);
                            $value = @$value[0].@$value[1];
                            $value = @strtolower($value);
                            //echo $value; die;
                            foreach ($str as $key => $value_matched) {
                                //$value_matched = filter_var($value_matched, FILTER_SANITIZE_NUMBER_INT);
                                $value_matched = $this->clean($value_matched);
                                $value_matched = strtolower($value_matched);

                                if($value_matched && ($value==$value_matched)){
                                    exit(true);
                                }   
                            }
                        }
                        
                    }else{
                        exit(false);
                    }
               }

               if(array_key_exists('preorcoreq', $value1)){
                    $str = $value1['preorcoreq'];
                    $str = explode(' ', $str);
                    
                    if($str){
                        $matched = false;
                        foreach ($arr as $value) {
                            $value = @explode(' ', @$value, 3);
                            $value = @$value[0].@$value[1];
                            $value = @strtolower($value);

                            foreach ($str as $key => $value_matched) {
                                //$value_matched = filter_var($value_matched, FILTER_SANITIZE_NUMBER_INT);
                                $value_matched = $this->clean($value_matched);
                                $value_matched = strtolower($value_matched);

                                if($value_matched && ($value==$value_matched)){
                                    $matched = true;
                                }
                            }
                        }

                        //print_r($matched); die;
                        if($matched){
                            exit(false);
                        }else{
                            exit(true);
                        }
                        
                    }else{
                        exit(false);
                    }
               }

               exit(false);
            }
        }
        
        exit(false);
    }

    public function clean($string) {
       $string = str_replace(' ', '-', $string); // Replaces all spaces with hyphens.

       return preg_replace('/[^A-Za-z0-9\-]/', '', $string); // Removes special chars.
    }

    public function fixedCourses(){
        $arr = [   
        "ce4201"=> [
            "prereq"=> "SPX prerequisite: CE3202 or EE3202 or instructor consent required"
        ],
        "ce4202"=> [
            "prereq"=> "SPX prerequisite: CE3202 or EE3202 or instructor consent required"
        ],
        "ce4203"=> [
            "prereq"=> "SPX prerequisite: CE3202 or EE3202 or instructor consent required"
        ],
        "ce4204"=> [
            "prereq"=> "SPX prerequisite: CE3202 or EE3202 or instructor consent required"
        ],
        "ce4205"=> [
            "prereq"=> "SPX prerequisite CE3202 or EE3202 or instructor consent required"
        ],
        "ce4304"=> [
            "prereq"=> "CE3320 or EE3320"
        ],
        "ce4337"=> [
            "prereq"=> "((CE2336 or CS2336 or CS2337) or CS3333) and (CE2305 or CS2305) and (CS2340 or SE3340 or CE4304 or EE4304)"
        ],
        "ce4348"=> [
            "prereq"=> "SPX prerequisites=> (CS2340 or SE3340 or equivalent), and (CE3345 or CS3345 or SE3345), and a working knowledge of C and UNIX"
        ],
        "ce4370"=> [
            "prereq"=> "CE3320 or EE3320"
        ],
        "ce4388"=> [
            "prereq"=> "SPX prerequisites=> ECS3390 and one of the following prerequisite sequences=> ((CE3311 or EE3311) and (CE3320 or EE3320) and (CE3345 or CS3345 or SE3345) and (CE3354 or CS3354 or SE3354)) or (ENGR3300 and EE3302 and (CE3311 or EE3311) and (CE3320 or EE3320)) or (ENGR3300 and EE3302 and (CE3345 or CS3345 or SE3345))"
        ],
        "ce4389"=> [
            "prereq"=> "CE4388 or EE4388"
        ],
        "ce4390"=> [
            "prereq"=> "(CE3345 or CS3345 or SE3345) "
        ],
        "cs1134"=> [
            "coreq"=> "CS1334"
        ],
        "cs1136"=> [
            "coreq"=> "CS1336"
        ],
        "cs1324"=> [
            "prereq"=> "CS1336 "
        ],
        "cs1325"=> [
            "prereq"=> "CS1336 "
        ],
        "cs1334"=> [
            "coreq"=> "CS1134"
        ],
        "cs1335"=> [
            "prereq"=> "CS1334 "
        ],
        "cs1336"=> [
            "coreq"=> "CS1136"
        ],
        "cs1337"=> [
            "prereq"=> "CS1336 "
        ],
        "cs2305"=> [
            "prereq"=> "SPX prerequisite=> ALEKS score required or MATH2312 with a grade of C or better"
        ],
        "cs2335"=> [
            "prereq"=> "CS1335 or CE1337 or CS1337"
        ],
        "cs2336"=> [
            "preorcoreq"=> "(CE2305 or CS2305) "
        ],
        "cs2337"=> [
            "preorcoreq"=> "(CE2305 or CS2305) "
        ],
        "cs3149"=> [
            "prereq"=> "(CE2336 or CS2336 or CS2337)  and CS3305 "
        ],
        "cs3162"=> [
            "preorcoreq"=> "CS3345 and CS3354"
        ],
        "cs3305"=> [
            "prereq"=> "(CE2305 or CS2305)  and (MATH2414 or MATH2419)"
        ],
        "cs3333"=> [
            "prereq"=> "SPX prerequisite=> CS1335 or (CE1337 or CS1337) or equivalent programming experience"
        ],
        "cs3341"=> [
            "prereq"=> "(MATH1326 or MATH2414 or MATH2419) and (CE2305 or CS2305) "
        ],
        "cs3345"=> [
            "preorcoreq"=> "(CS3341 or SE3341 or ENGR3341)"
        ],
        "cs3354"=> [
            "preorcoreq"=> "ECS3390"
        ],
        "cs3360"=> [
            "prereq"=> "CS2335"
        ],
        "cs3377"=> [
            "prereq"=> "(CE2336 or CS2336 or CS2337) "
        ],
        "cs4141"=> [
            "Coreq"=> "CS4341"
        ],
        "cs4301"=> [
            "prereq"=> "CE3345 or CS3345 or SE3345"
        ],
        "cs4313"=> [
            "prereq"=> "(MATH2414 or MATH2419) and (STAT3341 or STAT4351) and MATH2418"
        ],
        "cs4314"=> [
            "prereq"=> "SPX prerequisites=> ((MATH2414 or MATH2419) and (CS3341 or SE3341) and MATH2418) or instructor consent required"
        ],
        "cs4315"=> [
            "prereq"=> "SPX prerequisite=> CGS4314 or CS4314 or instructor consent required"
        ],
        "cs4332"=> [
            "prereq"=> "CE3345 or CS3345 or SE3345"
        ],
        "cs4334"=> [
            "prereq"=> "(MATH2370 or CS1324 or CS1325 or CE1337 or CS1337) and (MATH2418 and MATH2451 or MATH3351)"
        ],
        "cs4336"=> [
            "prereq"=> "(CE2336 or CS2336 or CS2337) "
        ],
        "cs4337"=> [
            "prereq"=> "((CE2336 or CS2336 or CS2337) or CS3333) and (CE2305 or CS2305) and (CS2340 or SE3340 or CE4304 or EE4304)"
        ],
        "cs4341"=> [
            "coreq"=> "cs4141"
        ],
        "cs4347"=> [
            "prereq"=> "CE3345 or CS3345 or SE3345"
        ],
        "cs4348"=> [
            "prereq"=> "(CS2340 or SE3340)  and (CS3377 or SE3377) and (CE3345 or CS3345 or SE3345)"
        ],
        "cs4349"=> [
            "prereq"=> "CS3305  and (CE3345 or CS3345 or SE3345)"
        ],
        "cs4361"=> [
            "prereq"=> "MATH2418 and (CE2336 or CS2336 or CS2337) and (CE3345 or CS3345 or SE3345) "
        ],
        "cs4365"=> [
            "prereq"=> "(CE3345 or CS3345 or SE3345) "
        ],
        "cs4371"=> [
            "prereq"=> "(CS2336 or CS2337) and CS4347"
        ],
        "cs4372"=> [
            "coreq"=> "CS4375"
        ],
        "cs4375"=> [
            "prereq"=> "(CS3341 or SE3341) and (CE3345 or CS3345 or SE3345) "
        ],
        "cs4376"=> [
            "prereq"=> "(CE2336 or CS2336 or CS2337) "
        ],
        "cs4384"=> [
            "prereq"=> "CS3305 "
        ],
        "cs4386"=> [
            "prereq"=> "(CE3345 or CS3345 or SE3345) "
        ],
        "cs4389"=> [
            "prereq"=> "CS4347 or SE4347"
        ],
        "cs4390"=> [
            "prereq"=> "(CE3345 or CS3345 or SE3345) "
        ],
        "cs4391"=> [
            "prereq"=> "(CE3345 or CS3345 or SE3345) "
        ],
        "cs4392"=> [
            "prereq"=> "MATH2418 and (CE3345 or CS3345 or SE3345) "
        ],
        "cs4393"=> [
            "prereq"=> "(CE4348 or CS4348 or SE4348) "
        ],
        "cs4394"=> [
            "prereq"=> "SPX prerequisite=> CE4348 or CS4348 or SE4348 or equivalent programming experience"
        ],
        "cs4395"=> [
            "prereq"=> "(CS3341 or SE3341) and (CE3345 or CS3345 or SE3345) "
        ],
        "cs4396"=> [
            "prereq"=> "CS4390 "
        ],
        "cs4397"=> [
            "prereq"=> "(CE4348 or CS4348 or SE4348) "
        ],
        "cs4398"=> [
            "prereq"=> "(CE4348 or CS4348 or SE4348) and (CE4390 or CS4390) "
        ],
        "cs4475"=> [
            "prereq"=> "STAT4355 and CS4375"
        ],
        "cs4485"=> [
            "prereq"=> "(CE3345 or CS3345 or SE3345) and (CE3354 or CS3354 or SE3354)  "
        ],
        "cs4v95"=> [
            "prereq"=> "SPX prerequisite=> (CE3345 or CS3345 or SE3345) and instructor consent required"
        ], 
        "math2413"=> [
            "prereq"=> "SPX prerequisite=> ALEKS score required or a grade of at least a C- in MATH2306 or MATH2312"
        ],
        "math2414"=> [
            "prereq"=> " MATH2417 or  MATH2413 "
        ],
        "math2415"=> [
            "prereq"=> "SPX prerequisite=> A grade of C- or better in MATH2414"
        ],
        "math2417"=> [
            "prereq"=> "SPX prerequisite=> ALEKS score required or a grade of at least a C- in MATH2306 or MATH2312"
        ],
        "math2418"=> [
            "prereq"=> "  MATH2306 or MATH2413 or MATH2417"
        ],
        "math2419"=> [
            "prereq"=> " MATH2417"
        ],      
        "phys2125"=> [
            "coreq"=> "PHYS1301 or PHYS2325 or PHYS2421"
        ],
        "phys2126"=> [
            "coreq"=> "PHYS1302 or PHYS2326 or PHYS2422"
        ],
        "phys2325"=> [
            "coreq"=> "(MATH2414 or MATH2419) and (PHYS2121 or PHYS2125)"
        ],
        "phys2326"=> [
            "coreq"=> "PHYS2126"
        ],
        "univ1010"=> [
            "coreq"=> "ARHM1100 or ATCM1100 or BA1100 or BBSU1100 or BCOM1300 or BIS1100 or ECS1100 or EPPS1110 or NATS1101 or NATS1142 or UNIV1100"
        ],
        "univ1100"=> [
            "coreq"=> "UNIV1010"
        ],
    ];

    return $arr;
    }  
}
