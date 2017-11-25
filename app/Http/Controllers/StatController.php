<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Log;

class StatController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $begin = date("m/d/Y",time());
        $end = date("m/d/Y",time());

        //dd();
        //获取sp
        $sp = DB::select('select `code_num`,`code_name` from `exinco_code_type` where `dis`=1 and `del`=0');
        //获取cp
        $cp = DB::select('select `channel_id`,`channel_name` from `exinco_channel` where `status`=1 and `del`=0');

        return view('stat',['sps'=>$sp,'cps'=>$cp,'begin'=>$begin,'end'=>$end]);
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
        if($input = Input::all()) {
            $begin=$input['begin'];
            $end=$input['end'];
            $unix_begin = strtotime($input['begin'] . ' 00:00:00') * 1000;
            $unix_end = strtotime($input['end'] . ' 23:59:59') * 1000 + 999;//1510415999999
            $sp = $input['sp'];
            $cp = $input['cp'];
/*
            if ($cp) {
                $gamelists = DB::table('exinco_deducts')->where('channel_id', $cp)->lists('game_num');
                //dd($gamelists);
                foreach ($gamelists as $key => $value) {
                    //dd($value);
                    $itemlists = DB::table('exinco_item_info')->where('game_num', $value)->get();
                    foreach ($itemlists as $k => $v) {
                        foreach ($v as $kk => $vv) {
                            if($kk=='param'){

                            } else {
                                $arr[$kk] = urlencode($vv);
                            }
                            if ($kk == 'item_num') {
                                //计费请求总数
                                $arr['mo'] = urlencode(DB::table('exinco_requests')
                                    ->where('cid', $cp)
                                    ->where('itemnum', $vv)
                                    ->where('ptime', '>=', $begin)
                                    ->where('ptime', '<', $end)
                                    ->count());
                                //转发数
                                $arr['zfmr'] = urlencode(DB::table('exinco_requests')
                                    ->where('cid', $cp)
                                    ->where('itemnum', $vv)
                                    ->where('status', 1)
                                    ->where('send', 1)
                                    ->where('ptime', '>=', $begin)
                                    ->where('ptime', '<', $end)
                                    ->count());
                                //扣量数
                                $arr['klmr'] = urlencode(DB::table('exinco_requests')
                                    ->where('cid', $cp)
                                    ->where('itemnum', $vv)
                                    ->where('status', 1)
                                    ->where('send', 0)
                                    ->where('ptime', '>=', $begin)
                                    ->where('ptime', '<', $end)
                                    ->count());
                            }
                        }
                        $arr_temp[] = $arr;
                    }
                }

                foreach ($arr_temp as $key_1 => $value){

                }


                $result["total"] = urlencode(count($item));
                $result["rows"] = $item;

                $data = urldecode(json_encode($result));

                //$data = '{"total":"1","rows":[{"id":"4","game_num":"1001","item_num":"1001001","mo":"0","zfmr":"0","klmr":"0","item_name":"2元","param":"1","fee":"200","status":"1","del":"0"}]}';
                //dd($data);

            } else {

            }*/

            $date = $this->getdate($begin,$end);//获取开始日期与结束日期之间所有日期

            foreach ($date as $d_k => $d_v){

                $this->getdata($cp,$d_v);
                dd($d_v);
            }
        }
        //dd($date);
       return $data;

        //dd($fee);
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

    /**
     * 获取指定日期段内每一天的日期
     * @param  Date  $startdate 开始日期
     * @param  Date  $enddate   结束日期
     * @return Array
     */
    public function getdate($startdate, $enddate){

        $stimestamp = strtotime($startdate);
        $etimestamp = strtotime($enddate);

        // 计算日期段内有多少天
        $days = ($etimestamp-$stimestamp)/86400+1;

        // 保存每天日期
        $date = array();

        for($i=0; $i<$days; $i++){
            $date[] = date('Y-m-d', $stimestamp+(86400*$i));
        }

        return $date;
    }

    public function getdata($cp,$date){
        $bdate = strtotime($date . ' 00:00:00') * 1000;
        $edate = strtotime($date . ' 23:59:59') * 1000 + 999;

        if ($cp){
            // 获取渠道下的道具编号与资费
            //DB::table()

            $rs = DB::table('exinco_requests')->where('cid',$cp)->where('ptime','>=',$bdate)->where('ptime','<=',$edate)->get();
            //dd($rs);
            foreach ($rs as $r_k => $r_v){

            }
        } else {

        }
    }
}
