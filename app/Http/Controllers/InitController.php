<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;

class InitController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        /**
         * 易讯无限MDO配置
         * op（易讯分配的接口名称）
         * pid（易讯分配产品ID 不用体现）
         * ppid（易讯分配计费点ID 不用体现）
         * sitid（奕信分配的代码ID）
         */
        $PID_CONF[100] = '1234';//数字100代表渠道编号，后面的4位数字为易讯分配的PID
        $URL_CONF['getcmd'] = 'http://101.200.191.80:50080/api/getcmd';//易讯请求计费接口
        $URL_CONF['vcode'] = 'http://101.200.191.80:50080/api/vcode';//验证码提交接口
        $ppid = '123456';//易讯分配计费点ID
        $param = '?';
        $keystr = '';
        $valuestr = '';

        if (!empty($input = Input::all())) {
            if (!empty($input['op'])) {
                foreach ($input as $key => $value) {
                    if ($key == 'op') {
                        $url = $URL_CONF[$value];
                    } elseif ($key == 'sitid') {
                        $param .= 'pid=' . $PID_CONF[$value] . '&';
                    } else {
                        $param .= $key . '=' . $value . '&';
                    }
                }

                $curl = curl_init(); // 启动一个CURL会话
                curl_setopt($curl, CURLOPT_URL, $url . $param);
                curl_setopt($curl, CURLOPT_HEADER, false);
                curl_setopt($curl, CURLOPT_TIMEOUT, 30);
                curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false); //不验证证书
                curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false); //不验证证书
                curl_setopt($curl, CURLOPT_NOSIGNAL, 1);
                $result = curl_exec($curl);
                curl_close($curl);//关闭URL请求
            } else {
                $result = '{"statemsg":"miss parameters!","state":"998"}';
            }
        } else {
            $result = '{"statemsg":"miss parameters!","state":"999"}';
        }
        return $result;
/*
        dd($URL_CONF[$input['op']]);

        $url = 'http://ivas.iizhifu.com/init.php?';
        $param = '';
        $siteid = 123;//由上家提供
        $keystr = '';
        $valuestr = '';

        if (!empty($input = Input::all())) {
            //dd(1);
            foreach ($input as $key => $value) {
                if ($key == 'siteid') {
                    $channelid = $value;
                } else {
                    $param .= $key . '=' . $value . '&';
                    $keystr .= '`' . $key . '`,';
                    $valuestr .= '"' . $value . '",';
                }
            }
            $param .= 'siteid=' . $siteid;
            $keystr .= '`siteid`,`channelid`';
            $valuestr .= '"' . $siteid . '","' . $channelid . '"';
            //dd($param);
            //dd(date('Y-m-d H:i:s', time()));

            //$param = substr($param, 0, strlen($param) - 1);

            $url = $url . $param;
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

            if ($result) {
                $arr = json_decode($result);
                //dd($arr);
                $hRet = $arr->hRet;
                $sqlstr = 'INSERT INTO `exinco_requests` (' . $keystr . ',`hRet`,`ptime`) VALUES (' . $valuestr . ',"' . $hRet . '","' . time() . '")';
                //dd($sqlstr);
            } else {
                $sqlstr = 'INSERT INTO `exinco_requests` (' . $keystr . ',`hRet`,`ptime`) VALUES (' . $valuestr . ',"206","' . time() . '")';
            }
            $rs = DB::insert($sqlstr);
        } else {
            $result = '{"hRet":"-9998"}';
        }
        //dd($res)
        return $result;
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
}
