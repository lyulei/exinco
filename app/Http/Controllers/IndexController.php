<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;

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
                        if($value_1){
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
            $data = '{"total":0,"rows":[{"id":"","code_num":"'.$id.'","game_name":"","status":""}]}';
        }

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

    public function gettree(){
        $begin = '[';
        $code = '{"id":1, "text":"代码管理", "children":[{"id":11, "name":"CodeSort", "text":"代码分类管理"},{"id":12, "name":"CodeType", "text":"代码类型管理"}]},';
        $data = '{"id":2, "text":"数据管理", "children":[{'.$this->gettreestr('CodeInfo').']}]},';
        $channel = '{"id":3, "text":"渠道管理", "children":[{'.$this->gettreestr('Channel').']},{"id":32,"text":"渠道配置管理","name":"Channel"}]},';
        $stat = '{"id":4,"text":"数据管理","children":[{"id":41,"text":"数据管理","name":"Stat"}]}';
        $end = ']';

        return $begin.$code.$data.$channel.$stat.$end;
    }

    public function gettreestr($param){
        $rs = DB::select('select * from `exinco_code_type` as a inner join `exinco_code_sort` as b where a.`del`=0 and b.`del`=0 and a.`dis`=1 and a.`code_sort` = b.`id`');
        foreach($rs as $key => $value){
            $result[$value->parentname][$value->type_name][] = array("id"=>$value->code_num,"name"=>$value->code_name);
        }
        $str = '';
        $num = 1;

        foreach($result as $kk => $vv){
            $num1 =1;
            $key = '2'.$num++;

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
                    $i = $num2++;
                    $key2 = $key1.$i;
                    if($i == $o){
                        $str .='"text": "'.$vvvv['id'].'-'.$vvvv['name'].'","id": '.$key2.',"name":"'.$param.'/'.$vvvv['id'].'"}]},{';
                    } else {
                        $str .='"text": "'.$vvvv['id'].'-'.$vvvv['name'].'","id": '.$key2.',"name":"'.$param.'/'.$vvvv['id'].'"},{';
                    }
                }
            }
        }
        $str = substr($str,0,strlen($str)-2);

        return $str;
    }

    public function getgame($id){
        $num = DB::table('exinco_game_info')->where('code_num',$id)->where('status',1)->where('del','=',0)->count();

        if ($num == 0) {
            $data = '{"total":0,"rows":[{"game_name":"","item_num":"","item_name":""}]}';
        } else {
            $arr = DB::table('exinco_game_info')->where('code_num',$id)->where('status',1)->where('del',0)->lists('game_name','id');
            //dd($arr);
            foreach ($arr as $key => $value){
                $itemlists = DB::table('exinco_item_info')->where('game_num',$key)->where('status',1)->where('del',0)->get();
                foreach ($itemlists as $ikey => $ivalue){
                    $item[] = array('game_name'=>urlencode($value),'item_num'=>urlencode($ivalue->item_num),'item_name'=>urlencode($ivalue->item_name));
                }
            }
            $result["total"] = count($item);
            $result["rows"] = $item;
            $data = urldecode(json_encode($result));
        }
        return $data;
    }

    public function getcp(){
        $result["total"] = DB::table('exinco_channel')->where('status',1)->where('del','=',0)->count();
        if ($result["total"] == 0) {
            $data = '{"total":0,"rows":[{"channel_id":"","channel_name":""}]}';
        } else {
            $arr = DB::table('exinco_channel')->where('status',1)->where('del',0)->lists('channel_name','channel_id');
            foreach($arr as $k => $v){
                $item[] = array('channel_id'=>$k,'channel_name'=>urlencode($v));
            }
            $result["rows"] = $item;
            $data = urldecode(json_encode($result));
        }
        return $data;
    }

    public function setdeduct($param){
        $array = explode('-',$param);
        $item_num = $array[0];
        $channel_id = $array[1];
        $result["total"] = DB::table('exinco_deducts')->where('channel_id',$channel_id)->where('item_num',$item_num)->count();

        if ($result["total"] == 0) {
            $data = '{"total":1,"rows":[{"id":"","channel_id":"'.$channel_id.'","item_num":"'.$item_num.'","deduct":""}]}';
        } else {
            $rs = DB::table('exinco_deducts')->where('channel_id',$channel_id)->where('item_num',$item_num)->get();
            //dd($arr);
            foreach($rs as $k => $v){
                foreach ($v as $kk => $vv){
                    $arr[$kk] = urlencode($vv);
                }
                $item[] = $arr;
            }
            $result["rows"] = $item;
            $data = urldecode(json_encode($result));
        }

        return $data;
    }

    public function deduct(Request $request){
        foreach (Input::all() as $key => $value){
            $op = $key;
            $pd = $value;
        }
        $keystr = '';
        $valuestr = '';
        $arr = json_decode($pd);
        switch ($op) {
            case "updated":
                foreach($arr as $key => $value){
                    foreach($value as $key_1 => $value_1){
                        if($key_1 == 'id')
                            $id = $value_1;

                        if($key_1 != 'id' and $key_1 != 'del'){
                            $keystr .='`'.$key_1.'`="'.$value_1.'",';
                        }
                    }
                }
                if($id){
                    $keystr = substr($keystr,0,strlen($keystr)-1);
                    $sqlstr = 'update `exinco_deducts` set '.$keystr.' where (`id`='.$id.')';
                    //dd($sqlstr);
                    $result = DB::update($sqlstr);
                } else {
                    $keystr = '';
                    $valuestr = '';
                    foreach($arr as $k => $v){
                        foreach($v as $k_1 => $v_1){
                            //if($k_1 != 'id' and $k_1 != 'param_name'){
                            $keystr .= '`'.$k_1.'`,';
                            $valuestr .='"'.$v_1.'",';
                            //}
                        }
                    }
                    $keystr = substr($keystr,0,strlen($keystr)-1);
                    $valuestr = substr($valuestr,0,strlen($valuestr)-1);
                    $sqlstr = 'insert into `exinco_deducts` ('.$keystr.') values ('.$valuestr.')';
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
                foreach($arr as $key => $value){
                    foreach($value as $key_1 => $value_1){
                        if($key_1 == 'id'){
                            $id = $value_1;
                        }
                    }
                }
                $sqlstr = 'update `exinco_channel` set `del`="1" where (`id`='.$id.')';
//dd($sqlstr);
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

    public function test(){

    }
}
