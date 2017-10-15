<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;

class CodeInfoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //dd(Input::all());
        foreach (Input::all() as $key => $value){
            if($key == 'code_num'){
                $code_num = $value;
            } else {
                $op = $key;
                $pd = $value;
            }
        }
        $keystr = '';
        $valuestr = '';
        $arr_temp = '';
        $arr = json_decode($pd);
        //dd($arr);
        switch ($op) {
            case "inserted":
                foreach($arr as $key => $value){
                    foreach($value as $key_1 => $value_1){
                        //dd($key_1);
                        if($key_1 != 'game_name' and $key_1 != 'status'){
                            $arr_temp[] = array($key_1=>urlencode($value_1));
                        } elseif($key_1 == 'status') {
                            if($value_1 == 'Yes'){$value_1 = 1;}else{$value_1 = 0;}

                            $keystr .= '`'.$key_1.'`,';
                            $valuestr .='"'.$value_1.'",';
                        } else {
                            $keystr .= '`'.$key_1.'`,';
                            $valuestr .='"'.$value_1.'",';
                        }
                    }
                }
                $arr_temp = addslashes(urldecode(json_encode($arr_temp)));
                $keystr = $keystr.'`param`,`code_num`';
                $valuestr = $valuestr.'"'.$arr_temp.'",'.$code_num;
                $sqlstr = 'insert into `exinco_game_info` ('.$keystr.') values ('.$valuestr.')';
                //dd(stripslashes($arr_temp));
                //dd($sqlstr);
                $result = DB::insert($sqlstr);
                if($result){
                    $data = [
                        'status' => 1,
                        'message' => '新增成功！',
                    ];
                } else {
                    $data = [
                        'status' => 0,
                        'message' => '新增失败！',
                    ];
                }
                break;
            case "updated":
                //dd($arr);
                foreach($arr as $key => $value){
                    foreach($value as $key_1 => $value_1){
                        if ($key_1 == "id"){
                            $id = $value_1;
                        }
                        if($key_1 != "id" and $key_1 != "game_name" and $key_1 != "code_num" and $key_1 != "status" and $key_1 != "del"){
                            $arr_temp[] = array($key_1=>$value_1);
                        } elseif ($key_1 == 'status'){
                            if($value_1 == 'Yes'){$value_1 = 1;}else{$value_1 = 0;}
                            $keystr .='`'.$key_1.'`="'.$value_1.'",';
                        } else {
                            $keystr .='`'.$key_1.'`="'.$value_1.'",';
                        }
                    }
                }
                $arr_temp = addslashes(urldecode(json_encode($arr_temp)));
                if ($id) {
                    $keystr = $keystr.'`param`="'.$arr_temp.'"';
                    $sqlstr = 'update `exinco_game_info` set '.$keystr.' where (`id`='.$id.')';
                    $result = DB::update($sqlstr);
                } else {
                    $keystr = '';
                    $valuestr = '';
                    $arr_temp = '';
                    foreach($arr as $key => $value){
                        foreach($value as $key_1 => $value_1){
                            //dd($key_1);
                            if($key_1 != 'id' and $key_1 != 'game_name' and $key_1 != 'status' and $key_1 !='code_num'){
                                $arr_temp[] = array($key_1=>urlencode($value_1));
                            } elseif($key_1 == 'status') {
                                if($value_1 == 'Yes'){$value_1 = 1;}else{$value_1 = 0;}

                                $keystr .= '`'.$key_1.'`,';
                                $valuestr .='"'.$value_1.'",';
                            } elseif ($key_1 == 'id') {
                                $keystr = '';
                                $valuestr = '';
                            } else {
                                $keystr .= '`'.$key_1.'`,';
                                $valuestr .='"'.$value_1.'",';
                            }
                        }
                    }
                    $arr_temp = addslashes(urldecode(json_encode($arr_temp)));
                    $keystr = $keystr.'`param`';
                    $valuestr = $valuestr.'"'.$arr_temp.'"';
                    $sqlstr = 'insert into `exinco_game_info` ('.$keystr.') values ('.$valuestr.')';
                    //dd(stripslashes($arr_temp));
                    //dd($sqlstr);
                    $result = DB::insert($sqlstr);
                }

                if($result){
                    $data = [
                        'status' => 1,
                        'message' => '修改成功！',
                    ];
                } else {
                    $data = [
                        'status' => 0,
                        'message' => '修改失败！',
                    ];
                }
                break;
            case "deleted":
                //dd(Input::all());
                foreach($arr as $key => $value){
                    foreach($value as $key_1 => $value_1){
                        if($key_1 == 'id'){
                            $id = $value_1;
                        }
                    }
                }
                $sqlstr = 'update `exinco_game_info` set `del`="1" where (`id`='.$id.')';

                $result = DB::update($sqlstr);
                if($result){
                    $data = [
                        'status' => 1,
                        'message' => '删除成功！',
                    ];
                } else {
                    $data = [
                        'status' => 0,
                        'message' => '删除失败！',
                    ];
                }
                break;
            default:
                echo 3;
                break;
        }

        return $data;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //------------ 游戏信息表头 ------------
        $results["columns"] = '{field:"id",title:"游戏编号"},{field:"game_name",title:"游戏名称",editor:"textbox"},';
        //dd($id);
        $rs = DB::select('select `field_name`,`param_remarks` from `exinco_game_item` where `code_num` = '.$id.' and `param_type`=1 and `del`=0');
        if ($rs){
            foreach ($rs as $key => $value){
                $results["columns"] .= '{field:"'.$value->field_name.'",title:"'.$value->param_remarks.'",editor:"textbox"},';
            }
        } else {
            $results["columns"] .= '';
        }
        $results["columns"] .= '{field:"status",title:"激活状态",editor:{type:"checkbox",options:{on:"Yes",off:"No"}}}';
        $results["code_num"] = $id;
        //------------ 道具信息表头 ------------
        $results["itemcolumns"] = '{field:"id",title:"ID",hidden:true},{field:"item_num",title:"道具编号",editor:"textbox"},{field:"item_name",title:"道具名称",editor:"textbox"},';
        $rs = DB::select('select `field_name`,`param_remarks` from `exinco_game_item` where `code_num` = '.$id.' and `param_type`=2 and `del`=0');
        if ($rs){
            foreach ($rs as $key => $value){
                $results["itemcolumns"] .= '{field:"'.$value->field_name.'",title:"'.$value->param_remarks.'",editor:"textbox"},';
            }
        } else {
            $results["itemcolumns"] .= '';
        }
        $results["itemcolumns"] .= '{field:"fee",title:"资费：分",editor:"textbox"},{field:"status",title:"激活状态",editor:{type:"checkbox",options:{on:"Yes",off:"No"}}}';
        //------------ 代码日限信息表头 ------------
        $results["limitcolumns"] = '{field:"id",title:"ID",hidden:true},{field:"game_num",title:"游戏编号",hidden:true},{field:"begin_date",title:"开始日期",editor:"numberbox"},{field:"end_date",title:"结束日期（月底请统一使用31表示）",editor:"numberbox"},{field:"fee_limit",title:"计费上限（分）",editor:"numberbox"},';

            //dd($results);
        return view('codeinfo',['results'=>$results]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
