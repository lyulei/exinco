<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;

class GameItemController extends Controller
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
//        dd(Input::all());
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
        $arr = json_decode($pd);
        switch ($op) {
            case "inserted":
                foreach($arr as $key => $value){
                    foreach($value as $key_1 => $value_1){
                        if($key_1 != 'param_name'){
                            $keystr .= '`'.$key_1.'`,';
                            $valuestr .='"'.$value_1.'",';
                        }
                    }
                }
                $keystr .= '`code_num`';
                $valuestr .= '"'.$code_num.'"';

                $sqlstr = 'insert into `exinco_game_item` ('.$keystr.') values ('.$valuestr.')';

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
                foreach($arr as $key => $value){
                    foreach($value as $key_1 => $value_1){
                        if($key_1 == 'id')
                            $id = $value_1;

                        if($key_1 != 'id' and $key_1 != 'param_name'){
                            $keystr .='`'.$key_1.'`="'.$value_1.'",';
                        }
                    }
                }
                if($id){
                    $keystr = substr($keystr,0,strlen($keystr)-1);
                    $sqlstr = 'update `exinco_game_item` set '.$keystr.' where (`id`='.$id.')';
                    $result = DB::update($sqlstr);
                } else {
                    $keystr = '';
                    $valuestr = '';
                    foreach($arr as $k => $v){
                        foreach($v as $k_1 => $v_1){
                            if($k_1 != 'id' and $k_1 != 'param_name'){
                                $keystr .= '`'.$k_1.'`,';
                                $valuestr .='"'.$v_1.'",';
                            }
                        }
                    }
                    $keystr = substr($keystr,0,strlen($keystr)-1);
                    $valuestr = substr($valuestr,0,strlen($valuestr)-1);
                    $sqlstr = 'insert into `exinco_game_item` ('.$keystr.') values ('.$valuestr.')';

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
                foreach($arr as $key => $value){
                    foreach($value as $key_1 => $value_1){
                        if($key_1 == 'code_num'){
                            $code_num = $value_1;
                        }
                    }
                }
                $sqlstr = 'update `exinco_code_type` set `del`="1" where (`code_num`='.$code_num.')';

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
