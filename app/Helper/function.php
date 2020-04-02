<?php
function searchinarray($wrong,$correct,$id)
{
foreach ($wrong as $key => $value) {
    if($id==$key)
    {
      return $value;
    }
}
foreach ($correct as $key => $value) {
    if($id==$key)
    {
      return $value;
    }
}
}
function check($i,$wrong,$correct,$id,$correctanswer)
{
if ($i==searchinarray($wrong,$correct,$id) && $correctanswer== searchinarray($wrong,$correct,$id)) {
   return  "checked style=background:green";
}
if ($i==searchinarray($wrong,$correct,$id) && $correctanswer!= searchinarray($wrong,$correct,$id)) {
    return "checked style=background:red";
 }
 if ($i==$correctanswer) {
    return "style=background:green";
 }

}
function sorteimage($despath,$req_file_img){
  $destinationPath =$despath;
  $files = $req_file_img;
  $file_name =time() . $files->getClientOriginalName();
  $files->move($destinationPath, $file_name);
  return $file_name;
}
function find_in_array($value,$columnname,$arrayobject)
{
    $arr=array();
    foreach ($arrayobject as $key => $item) {
        $arr[]=$item->$columnname;
    }
    if(in_array($value,$arr))
    {
      return 1;
    }
    return 0;
}
function get_array_search_table($arrayobject,$columnname,$table,$columnnametable)
{
    $arr=array();
    foreach ($arrayobject as $key => $item) {
        $arr[]=$item->$columnname;
    }
    if($arr!=null)
    {
      return $table::whereIn($columnnametable,$arr)->get();
    }
    return $table;
}
function get_table_search_table($table1,$columnnametable1,$table2,$columnnametable2)
{
    $arr=array();
    foreach ($table1::all() as $key => $item) {
        $arr[]=$item->$columnnametable1;
    }
    if($arr!=null)
    {
      return $table2::whereIn($columnnametable2,$arr)->get();
    }
    return $table2;
}
 function gettable($table,$columnnametable1=null,$operation1=null,$value1=null,$columnnametable2=null,$operation2=null,$value2=null,$columnnametable3=null,$operation3=null,$value3=null)
 {
    if($operation1==null)
    {
        return $table::all();
    }
    elseif($operation2==null)
    {
        return $table::$operation1($columnnametable1,$value1)->get();
    }
    elseif($operation3==null)
    {
        return $table::$operation1($columnnametable1,$value1)->$operation2($columnnametable2,$value2)->get();
    }
    else
    {
        return $table::$operation1($columnnametable1,$value1)->$operation2($columnnametable2,$value2)->$operation3($columnnametable3,$value3)->get();
    }


 }
 function getsinglerow($table,$columnnametable1=null,$operation1=null,$value1=null,$columnnametable2=null,$operation2=null,$value2=null,$columnnametable3=null,$operation3=null,$value3=null)
 {
    if($operation1==null)
    {
        return $table::first();
    }
    elseif($operation2==null)
    {
        return $table::$operation1($columnnametable1,$value1)->first();
    }
    elseif($operation3==null)
    {
        return $table::$operation1($columnnametable1,$value1)->$operation2($columnnametable2,$value2)->first();
    }
    else
    {
        return $table::$operation1($columnnametable1,$value1)->$operation2($columnnametable2,$value2)->$operation3($columnnametable3,$value3)->first();
    }
 }

