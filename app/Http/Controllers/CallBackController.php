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
    public function index()
    {
        /* 扣量概率测试
        $a = 1;
        $b = 1;
        for($i=1;$i<=10000;$i++){
            $rid = $this->rate(0); //根据概率获取奖项id,如num=0则不扣量全部转发
            if($rid){
                $r_result['转发'] = $a++;
            } else {
                $r_result['扣量'] = $b++;
            }
        }
        dd($r_result);
        */

        if (!empty($input = Input::all()) and !empty($mtid = $input['mtid'])) {
            Log::info('接收到的MR状态报告参数：'.json_encode($input));
            foreach ($input as $k => $v) {
                $input_tmp[$k] = urlencode($v);
            }
            //将MR请求数据转为json格式并准备存入数据库
            $mr_json = json_encode($input_tmp);
            $mr = urldecode(json_encode($mr_json));

            $rs = DB::select('SELECT * from exinco_requests where psid="' . $mtid.'"');

            if ($rs) {
                foreach ($rs as $key => $value) {
                    $id = $value->id; //计费请求id
                    $cid = $value->cid; //渠道id
                    $itemnum = $value->itemnum; // 道具编号
                    $status = $value->status; //计费请求结果 1成功 0未更新状态
                }
                //dd($rs);
                if ($status == 0) {
                    //获取渠道数据
                    $c_rs = DB::table('exinco_channel')->where('status', '1')->where('del', '0')->where('channel_id', $cid)->get();
                    //dd($c_rs);
                    if ($c_rs) {
                        foreach ($c_rs as $key_1 => $value_1) {
                            $mr_url = $value_1->mr;
                        }
                        //num：扣量概率，如20则代表扣20%的量，如num=0则不扣量全部转发。rid = 0 则不转发 rid = 1 则转发，补充：实际上num应该是根据渠道id获取到的
                        $rid = $this->rate(0);
                        if ($rid) {
                            $param = '?';
                            foreach ($input as $k => $v) {
                                if ($k == 'sid' or $k == 'pid' or $k == 'ppid') {
                                    //$param .= '';
                                } else {
                                    $param .= 'cid='.$cid.'&itemnum='.$itemnum.'&'.$k .'=' .$v.'&';
                                }
                            }
                            //dd($param);
                            $curl = curl_init(); // 启动一个CURL会话
                            curl_setopt($curl, CURLOPT_URL, $mr_url.$param);
                            curl_setopt($curl, CURLOPT_HEADER, false);
                            curl_setopt($curl, CURLOPT_TIMEOUT, 30);
                            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
                            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false); //不验证证书
                            curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false); //不验证证书
                            curl_setopt($curl, CURLOPT_NOSIGNAL, 1);
                            $s_result = curl_exec($curl);
                            curl_close($curl);//关闭URL请求

                            //if ($s_result == 'success') {
                            if ($s_result == 'ok') {
                                $send = 1;
                                //当前时间转13位毫秒级时间戳
                                list($t1, $t2) = explode(' ', microtime());
                                $stime = sprintf('%.0f', (floatval($t1) + floatval($t2)) * 1000);//整型，格式：1509894548868
                                Log::info('转发MR状态报告参数：['.$s_result.']'.$param.'|send='.$send.'stime='.$stime);
                            } else {
                                $s_result = 'fail';
                                $send = 0;
                                $stime = NULL;
                                Log::info('转发MR状态报告参数：['.$s_result.']'.$param.'|send='.$send.'stime='.$stime);
                            }
                        } else {
                            $send = 0;
                            $stime = NULL;
                        }
                    } else {
                        $send = 0;
                        $stime = NULL;
                    }

                    $sqlstr = 'update `exinco_requests` set `status`="' . $input['status'] . '",`fee`="' . $input['fee'] . '",`city`="' . $input['city'] . '",`province`="' . $input['province'] . '",`mr` =' . $mr . ',`time`="' . $input['time'] . '",`send`="'.$send.'",`stime`="'.$stime.'" where `id`=' . $id;
                    $result = DB::update($sqlstr);
                    Log::info('update sql：' . $sqlstr.', result：'.$result);
                } else {
                    Log::info('MR返回的mtid已更新状态：|' . json_encode($input));
                    return '{"statemsg":"miss parameters!","state":"993"}';//MR返回的mtid已更新状态
                }
            } else {
                Log::info('MR返回的mtid不存在：|' . json_encode($input));
                return '{"statemsg":"miss parameters!","state":"994"}';//MR返回的mtid不存在
            }
        } else {
            return '{"statemsg":"miss parameters!","state":"995"}';//参数不正确，非易讯MDO代码MR请求，如接入新代码可在此位置进行调整
        }
    }

    public function indexbak()
    {


        $param = '?';
        $keystr = '';
        $valuestr = '';
        $cb = 0;
        $cb_status = 0;

        if ($input = Input::all()) {
            foreach ($input as $key => $value) {
                if ($key == 'CPParam') {
                    $channelid = substr($value, 0, 3);
                }
                if ($key == 'siteid') {
                    $param .= $key . '=' . $channelid . '&';
                }
                $param .= $key . '=' . $value . '&';
                $keystr .= '`' . $key . '`,';
                $valuestr .= '"' . $value . '",';
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
        $seed = rand(0, 9);

        if ($r = $random[$seed]) {
            //dd($random[$seed]);
            //$rs = DB::select('select mo from exinco_channel ');
            $url = DB::table('exinco_channel')
                ->where('channel_id', '=', $channelid)
                ->where('del', '=', '0')
                ->pluck('mo');
            //dd($rs);
            $url = $url . $param;
            /**
             *  回传计费成功数据给渠道 PE生产环境 TE测试环境
             */
            /** 测试关闭
             * $curl = curl_init(); // 启动一个CURL会话
             * curl_setopt($curl, CURLOPT_URL, $url);
             * curl_setopt($curl, CURLOPT_HEADER, false);
             * curl_setopt($curl, CURLOPT_TIMEOUT, 30);
             * curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
             * curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false); //不验证证书
             * curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false); //不验证证书
             * //curl_setopt($curl, CURLOPT_HTTPHEADER,array('Content-Type: application/json'));
             * //curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false); // 跳过证书检查
             * //curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, true);  // 从证书中检查SSL加密算法是否存在
             * curl_setopt($curl, CURLOPT_NOSIGNAL, 1);
             * $result = curl_exec($curl);
             * curl_close($curl);//关闭URL请求
             */
            $result = true;
            $cb = 1;
            if ($result) {
                $cb_status = 1;
            } else {
                $cb_status = 0;
            }
        }

        $sqlstr = 'insert into `exinco_callbake` (' . $keystr . '`channelid`,`cb`,`cb_status`,`rtime`) values (' . $valuestr . '"' . $channelid . '","' . $cb . '","' . $cb_status . '","' . time() . '")';
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
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function rate($num)
    {
        if ($num) {
            $m_num = 100 - $num;
            $prize_arr = array(
                '0' => array('id' => 0, 'zf' => 'false', 'v' => $num),
                '1' => array('id' => 1, 'zf' => 'true', 'v' => $m_num),
            );

            foreach ($prize_arr as $key => $val) {
                $arr[$val['id']] = $val['v'];
            }

            $result = '';
            //概率数组的总概率精度
            $proSum = array_sum($arr);
            //概率数组循环
            foreach ($arr as $key => $proCur) {
                $randNum = mt_rand(1, $proSum);
                if ($randNum <= $proCur) {
                    $result = $key;
                    break;
                } else {
                    $proSum -= $proCur;
                }
            }
            unset ($arr);
        } else {
            $result = 1;
        }

        return $result;
    }
}
