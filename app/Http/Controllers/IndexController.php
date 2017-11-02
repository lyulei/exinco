<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class IndexController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //dd($str);
        return view('index');
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
        //
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

    public function gettree(){
        $rs = DB::select('select * from `exinco_code_type` as a inner join `exinco_code_sort` as b where a.`del`=0 and b.`del`=0 and a.`dis`=1 and a.`code_sort` = b.`id`');
        foreach($rs as $key => $value){
            $result[$value->parentname][$value->type_name][] = array("id"=>$value->code_num,"name"=>$value->code_name);
        }
        //$url = 'http://'.$_SERVER['HTTP_HOST'];
        $beginstr = '[{"id":1, "text":"代码管理", "children":[{"id":11, "name":"CodeSort", "text":"代码分类管理"},{"id":12, "name":"CodeType", "text":"代码类型管理"}]},{"id":2, "text":"数据管理", "children":[{';
        $str = '';
        $num = 1;
//dd($result);
        foreach($result as $kk => $vv){
            $num1 =1;
            $key = '2'.$num++;
            //dd($vv);
            if($str){
                $str = substr($str,0,strlen($str)-3).'}]}, {';
            }
            $str .= '"text": "'.$kk.'","id": '.$key.',"children": [{';

            foreach ($vv as $kkk => $vvv){

                $num2 =1;
                $ii = $num1++;
                $key1 = $key.$ii;
                $o = count($vvv);

                $str .='"text": "'.$kkk.'","id": '.$key1.',"children": [{';
                foreach($vvv as $kkkk => $vvvv){
                    //echo "key->".$kkkk.",value->".$vvvv."<br>";
                    //echo "key->".$vvv['id'].",value->".$vvv['name']."<br>";
                    $i = $num2++;
                    $key2 = $key1.$i;
                    //echo $i ."=". $o;
                    if($i == $o){
                        $str .='"text": "'.$vvvv['id'].'-'.$vvvv['name'].'","id": '.$key2.',"name":"CodeInfo/'.$vvvv['id'].'"}]},{';
                    } else {
                        $str .='"text": "'.$vvvv['id'].'-'.$vvvv['name'].'","id": '.$key2.',"name":"CodeInfo/'.$vvvv['id'].'"},{';
                    }
                }
            }
        }
        /**
         *  不包含管理渠道内容的tree
         */
        //$str = substr($str,0,strlen($str)-2).']}]';


        /**
         * 新增管理渠道内容的tree
         */
        $str = substr($str,0,strlen($str)-2).']}]';
        $str .= '},{"id":3, "text":"渠道管理", "children":[{"id":31,"text":"渠道配置管理","name":"Channel"},{"id":4,"text":"数据管理","children":[{"id":41,"text":"数据管理","name":"Data"}]}]';

        $tree = $beginstr.$str."}]";

        return $tree;
    }

    public function getcode(){
        $result["total"] = DB::table('exinco_code_type')->where('del','=',0)->count();

        $rs = DB::select('select a.id,a.`code_num`,a.`code_sort`,b.`type_name`,a.`code_name`,a.`dis` from `exinco_code_type` as a INNER JOIN `exinco_code_sort` as b on a.`code_sort`=b.`id` where a.del = 0 ');

        if($rs){
            foreach ($rs as $key => $value) {
                foreach($value as $key_1 => $value_1){
                    $arr[$key_1] = urlencode($value_1);
                }
                $item[] =$arr;
            }
            $result["rows"] = $item;
            $data = urldecode(json_encode($result));
        } else {
            $data = '{"total":0,"rows":[{"id":"","code_num":"","code_sort":"","type_name":"","code_name":"","dis":""}]}';
        }

        return $data;
    }
    public function getcodetype(){
        $rs = DB::select('select `id` as `code_sort`,`type_name` from `exinco_code_sort` where `del`=0');
        foreach ($rs as $key => $value) {
            foreach($value as $key_1 => $value_1){
                $arr[$key_1] = urlencode($value_1);
            }
            $item[] =$arr;
        }
        $data = urldecode(json_encode($item));
        return $data;
    }

    public function getparam($id){
        $result["total"] = DB::table('exinco_game_item')->where('del','=',0)->count();
        $rs = DB::select('select a.id,a.code_num,a.param_type,a.field_name,a.param_remarks,b.param_name from exinco_game_item as a INNER JOIN exinco_param_type as b where a.code_num='.$id.' and a.del=0 and b.del=0 and a.param_type=b.id');
        if($rs){
            foreach ($rs as $key => $value) {
                foreach($value as $key_1 => $value_1){
                    $arr[$key_1] = urlencode($value_1);
                }
                $item[] =$arr;
            }
            $result["rows"] = $item;
            $data = urldecode(json_encode($result));
        } else {
            $data = '{"total":0,"rows":[{"id":"","code_num":"'.$id.'","param_type":"","field_name":"","param_remarks":""}]}';
        }

        return $data;
    }

    public function getparamtype(){
        $rs = DB::select('select `id` as `param_type`,`param_name` from `exinco_param_type` where `del` = 0');
        foreach ($rs as $key => $value) {
            foreach($value as $key_1 => $value_1){
                $arr[$key_1] = urlencode($value_1);
            }
            $item[] =$arr;
        }
        $data = urldecode(json_encode($item));
        return $data;
    }

    public function getgameinfo($id){
        $result["total"] = DB::table('exinco_game_info')->where('del','=',0)->where('code_num','=',$id)->count();
        $rs = DB::select('select * from exinco_game_info where `del`=0 and `code_num`='.$id);
        //dd($rs);
        if($rs){
            foreach ($rs as $key => $value) {
                foreach($value as $key_1 => $value_1){
                    if($key_1 == 'param'){
                        foreach (json_decode($value_1) as $k=>$v){
                            foreach ($v as $k1 => $v2){
                                $arr[$k1] = urlencode($v2);
                            }
                        }
                    } else {
                        $arr[$key_1] = urlencode($value_1);
                    }
                }
                $item[] =$arr;
            }
            //dd($item);
            $result["rows"] = $item;
            $data = urldecode(json_encode($result));
        } else {
            $data = '{"total":0,"rows":[{"id":"","code_num":"'.$id.'","game_name":"","status":""}]}';
        }
        //dd($data);
        return $data;
    }

    public function getiteminfo($id){
        $result["total"] = DB::table('exinco_item_info')->where('del','=',0)->where('game_num','=',$id)->count();
        $rs = DB::select('select * from `exinco_item_info` where `del`=0 and `game_num` ='.$id);
//dd($rs);
        if($rs){
            foreach ($rs as $key => $value) {
                foreach($value as $key_1 => $value_1){
                    if($key_1 == 'param'){
                        //dd($value_1);
                        if ($value_1 != '""') {
                            foreach (json_decode($value_1) as $k=>$v){
                                foreach ($v as $k1 => $v2){
                                    $arr[$k1] = urlencode($v2);
                                }
                            }
                        }
                    } else {
                        $arr[$key_1] = urlencode($value_1);
                    }
                }
                $item[] =$arr;
            }
            //dd($item);
            $result["rows"] = $item;
            $data = urldecode(json_encode($result));
        } else {
            $data = '{"total":0,"rows":[{"id":"","item_name":"","game_num":"'.$id.'","item_name":"","status":"","fee":""}]}';
        }
        return $data;
    }

    public function getcodelimit($id){
        $result["total"] = DB::table('exinco_code_limit')->where('del','=',0)->where('game_num','=',$id)->count();
        if ($result["total"] == 0) {
            $data = '{"total":1,"rows":[{"id":"","game_num":"'.$id.'","begin_date":"1","end_date":"31","fee_limit":"1000000"}]}';
        } else {
            $rs = DB::select('select * from `exinco_code_limit` where `del`=0 and `game_num` ='.$id);
            //dd($rs);
            foreach ($rs as $key => $value) {
                foreach($value as $key_1 => $value_1){
                    if($key_1 != 'del'){
                        //dd($value_1);
                        $arr[$key_1] = urlencode($value_1);
                    }
                }
                $item[] =$arr;
            }
            $result["rows"] = $item;
            $data = urldecode(json_encode($result));
        }
        //dd($result);
        return $data;
    }

    public function getchannel(){
        $result["total"] = DB::table('exinco_channel')->where('del','=',0)->count();

        if ($result["total"] == 0) {
            //$data = '{"total":1,"rows":[{"id":"","game_num":"'.$id.'","begin_date":"1","end_date":"31","fee_limit":"1000000"}]}';
            $data = '{"total":0,"rows":[{"id":"","channel_id":"","channel_name":"","mo":"","mr":"","remarks":"","cb":"","cbfail":"","dedup":"","lac":"","ip":"","status":""}]}';
        } else {
            $rs = DB::table('exinco_channel')->where('del','=',0)->get();
            //dd($rs);
            foreach ($rs as $key => $value) {
                foreach($value as $key_1 => $value_1){
                    if($key_1 != 'del'){
                        //dd($value_1);
                        $arr[$key_1] = urlencode($value_1);
                    }
                }
                $item[] =$arr;
            }
            $result["rows"] = $item;
            $data = urldecode(json_encode($result));
        }
        //dd($result);
        return $data;

    }
}
