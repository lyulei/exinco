<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;

class ItemInfoController extends Controller
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
            if($key == 'id'){
                $id = $value;
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
                        if ($key_1 != 'item_name' and $key_1 != 'item_num' and $key_1 != 'fee' and $key_1 != 'status'){
                            $arr_temp[] = array($key_1=>urlencode($value_1));
                        } elseif ($key_1 == 'status') {
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
                $keystr = $keystr.'`param`,`game_num`';
                $valuestr = $valuestr.'"'.$arr_temp.'",'.$id;
                $sqlstr = 'insert into `exinco_item_info` ('.$keystr.') values ('.$valuestr.')';
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
                        if($key_1 != "id" and $key_1 != "item_name" and $key_1 != "item_num" and $key_1 != "game_num" and $key_1 != "fee" and $key_1 != "status" and $key_1 != "del"){
                            $arr_temp[] = array($key_1=>$value_1);
                        } elseif ($key_1 == 'status'){
                            if($value_1 == 'Yes'){$value_1 = 1;}else{$value_1 = 0;}
                            $keystr .='`'.$key_1.'`="'.$value_1.'",';
                        } elseif ($key_1 == "id" or $key_1 == "game_num" or $key_1 == "del") {
                            $keystr .='';
                        } else {
                            $keystr .='`'.$key_1.'`="'.$value_1.'",';
                        }
                    }
                }
                $arr_temp = addslashes(urldecode(json_encode($arr_temp)));
                //dd($arr_temp);
                if($id){
                    $keystr = $keystr.'`param`="'.$arr_temp.'"';
                    $sqlstr = 'update `exinco_item_info` set '.$keystr.' where (`id`='.$id.')';
                    //dd($sqlstr);
                    $result = DB::update($sqlstr);
                } else {
                    $keystr = '';
                    $valuestr = '';
                    $arr_temp = '';
                    foreach($arr as $key => $value){
                        foreach($value as $key_1 => $value_1){
                            if ($key_1 != 'id' and $key_1 != 'game_num' and $key_1 != 'item_name' and $key_1 != 'item_num' and $key_1 != 'fee' and $key_1 != 'status'){
                                $arr_temp[] = array($key_1=>urlencode($value_1));
                            } elseif ($key_1 == 'status') {
                                if($value_1 == 'Yes'){$value_1 = 1;}else{$value_1 = 0;}
                                $keystr .= '`'.$key_1.'`,';
                                $valuestr .='"'.$value_1.'",';
                            } elseif ($key_1 == 'id') {
                                $keystr .= '';
                                $valuestr .='';
                            } else {
                                $keystr .= '`'.$key_1.'`,';
                                $valuestr .='"'.$value_1.'",';
                            }
                        }
                    }
                    $arr_temp = addslashes(urldecode(json_encode($arr_temp)));
                    $keystr = $keystr.'`param`';
                    $valuestr = $valuestr.'"'.$arr_temp.'"';
                    $sqlstr = 'insert into `exinco_item_info` ('.$keystr.') values ('.$valuestr.')';
                    //dd(stripslashes($arr_temp));
                    //dd($sqlstr);
                    $result = DB::insert($sqlstr);
                }
                //dd($id);

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
                $sqlstr = 'update `exinco_item_info` set `del`="1" where (`id`='.$id.')';

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
        //
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
