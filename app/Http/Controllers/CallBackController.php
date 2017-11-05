<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Log;

class CallBackController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(){
        $input = Input::all();
        Log::info($input);
    }

    public function indexbak()
    {


        $param = '?';
        $keystr = '';
        $valuestr = '';
        $cb = 0;
        $cb_status = 0;

        if($input = Input::all()) {
            foreach ($input as $key => $value) {
                if ($key == 'CPParam') {
                    $channelid = substr($value, 0, 3);
                }
                if ($key == 'siteid') {
                    $param .= $key . '=' . $channelid . '&';
                }
                $param .= $key . '=' . $value . '&';
                $keystr .= '`'.$key.'`,';
                $valuestr .= '"'.$value.'",';
            }
            $param = substr($param, 0, strlen($param) - 1);
        }
//dd($param);
        $random[0] = 0;
        $random[1] = 1;
        $random[2] = 1;
        $random[3] = 1;
        $random[4] = 1;
        $random[5] = 1;
        $random[6] = 1;
        $random[7] = 1;
        $random[8] = 1;
        $random[9] = 0;
        $seed = rand(0,9);

        if ($r = $random[$seed]){
            //dd($random[$seed]);
            //$rs = DB::select('select mo from exinco_channel ');
            $url = DB::table('exinco_channel')
                ->where('channel_id','=',$channelid)
                ->where('del','=','0')
                ->pluck('mo');
            //dd($rs);
            $url = $url . $param;
            /**
             *  回传计费成功数据给渠道 PE生产环境 TE测试环境
             */
            /** 测试关闭
            $curl = curl_init(); // 启动一个CURL会话
            curl_setopt($curl, CURLOPT_URL, $url);
            curl_setopt($curl, CURLOPT_HEADER, false);
            curl_setopt($curl, CURLOPT_TIMEOUT, 30);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false); //不验证证书
            curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false); //不验证证书
            //curl_setopt($curl, CURLOPT_HTTPHEADER,array('Content-Type: application/json'));
            //curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false); // 跳过证书检查
            //curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, true);  // 从证书中检查SSL加密算法是否存在
            curl_setopt($curl, CURLOPT_NOSIGNAL, 1);
            $result = curl_exec($curl);
            curl_close($curl);//关闭URL请求
            */
            $result = true;
            $cb = 1;
            if ($result) {
                $cb_status = 1;
            } else {
                $cb_status = 0;
            }
        }

        $sqlstr = 'insert into `exinco_callbake` ('.$keystr.'`channelid`,`cb`,`cb_status`,`rtime`) values ('.$valuestr.'"'.$channelid.'","'.$cb.'","'.$cb_status.'","'.time().'")';
        //dd($sqlstr);
        $rs = DB::insert($sqlstr);

        if ($rs) {
            return "ok";
        }


        /*
        // 概率测试
        $random[0] = 0;
        $random[1] = 1;
        $random[2] = 1;
        $random[3] = 1;
        $random[4] = 1;
        $random[5] = 1;
        $random[6] = 1;
        $random[7] = 1;
        $random[8] = 1;
        $random[9] = 0;

        $a = 1;
        $b = 1;
        $i = 1000;
        for($i=0;$i<1000;$i++){
            $seed = rand(0,9);
            if($random[$seed] == 0){
                $num['扣量条数'] = $a++;
            } else {
                $num['同步条数'] = $b++;
            }
        }
        $num['成功总条数'] = $i;
        dd($num);
        */
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
}
