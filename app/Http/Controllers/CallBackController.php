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

        $deduct[100] = 10;//cid 100 深圳欣夕信
        $deduct[101] = 0;//cid 101 北京萌游
        $deduct[102] = 0;//cid 102 指动之间
        $deduct[103] = 0;//cid 103 烁游
        $deduct[105] = 0;//cid 105 上海燕芮


        $input = Input::all();

        Log::info('接收到的MR状态报告参数：'.json_encode($input));
        if (!empty($input) and !empty($mtid = @$input['mtid'])) { //@表示不进行错误提示
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
                        $rid = $this->rate($deduct[$cid]);
                        if ($rid) {
                            $param = '?';
                            foreach ($input as $k => $v) {
                                if ($k == 'sid' or $k == 'pid' or $k == 'ppid') {
                                    //$param .= '';
                                } else {
                                    $param .= 'cid='.urlencode($cid).'&itemnum='.urlencode($itemnum).'&'.$k .'=' .urlencode($v).'&';
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
            foreach ($input as $k => $v) {
                $input_tmp[$k] = urlencode($v);
            }
            //将MR请求数据转为json格式并准备存入数据库
            $mr_json = json_encode($input_tmp);
            $mr = urldecode(json_encode($mr_json));

            //dd($mr);
            //$rs = DB::select('SELECT * from exinco_requests where psid="' . $mtid.'"');
            $rs = DB::table('exinco_requests')->where('psid',$input['CPParam'])->get();

            if ($rs){
                foreach ($rs as $key => $value) {
                    $id = $value->id; //计费请求id
                    $cid = $value->cid; //渠道id
                    $itemnum = $value->itemnum; // 道具编号
                    $status = $value->status; //计费请求结果 1成功 0未更新状态
                }
                //dd($status);
                if ($status == 0) {
                    //获取渠道数据
                    $mr_url = DB::table('exinco_channel')->where('status', '1')->where('del', '0')->where('channel_id', $cid)->pluck('mr');
                    if($mr_url){
                        //num：扣量概率，如20则代表扣20%的量，如num=0则不扣量全部转发。rid = 0 则不转发 rid = 1 则转发，补充：实际上num应该是根据渠道id获取到的
                        $rid = $this->rate($deduct[$cid]);
                        if ($rid) {
                            $param = '?cid='.urlencode($cid).'&itemnum='.urlencode($itemnum).'&';
                            foreach ($input as $k => $v) {
                                if ($k <> 'codeid' and $k <> 'siteid' and $k <> 'mobile' and $k <> 'type' and $k <> 'stat'){
                                    $param .= $k .'=' .urlencode($v).'&';
                                } elseif ($k == 'mobile'){
                                    $param .= 'num=' .urlencode($v).'&';
                                } elseif ($k == 'stat'){
                                    $param .= 'status=' .urlencode($v).'&';
                                }
                            }
                            //dd($input);
                            dd($mr_url.$param);
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
                            //$s_result = 'ok';

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
                        // 渠道的MR URL为空或不存在
                        $send = 0;
                        $stime = NULL;
                    }
                    $sqlstr = 'update `exinco_requests` set `status`="' . $input['stat'] . '",`mr` =' . $mr . ',`send`="'.$send.'",`stime`="'.$stime.'" where `id`=' . $id;
                    //dd($sqlstr);
                    $result = DB::update($sqlstr);
                    Log::info('update sql：' . $sqlstr.', result：'.$result);
                } else {
                    Log::info('MR返回的CPParam已更新状态：|' . json_encode($input));
                    return '{"statemsg":"miss parameters!","state":"993"}';//MR返回的mtid已更新状态
                }
            }

            //return '{"statemsg":"miss parameters!","state":"995"}';//参数不正确，非易讯MDO代码MR请求，如接入新代码可在此位置进行调整
        }
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
