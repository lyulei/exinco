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
         * Init?op=getcmd&sitid=100&pid=1111
         */
        $URL_CONF['getcmd'] = 'http://101.200.191.80:50080/api/getcmd';//易讯请求计费接口
        $URL_CONF['vcode'] = 'http://101.200.191.80:50080/api/vcode';//验证码提交接口

        $param = '?';
        $keystr = '';
        $valuestr = '';

        if (!empty($input = Input::all())) {
            //dd($input);
            if (!empty($input['op'])) {
                foreach ($input as $key => $value) {
                    if ($key == 'op') {
                        $url = $URL_CONF[$value];
                    } elseif ($key == 'cid') { //即channel id
                        $keystr .= '`' . $key . '` ,';
                        $valuestr .= "'" . $value . "' ,";
                    } elseif ($key == 'itemnum') {
                        $item_num = $value;//即item num
                        // 根据item num获取pid
                        $param_json = DB::table('exinco_item_info')->where('item_num', $item_num)->where('status', 1)->where('del', 0)->pluck('param');
                        // 处理param中的json 并获取pid
                        if ($param_json) {
                            $param_array = json_decode($param_json, true);
                            foreach ($param_array as $v) {
                                $pid = $v['pid'];
                            };
                            $param .= 'pid=' . $pid . '&';
                            $keystr .= '`itemnum` ,';
                            $valuestr .= "'" . $value . "' ,";
                        } else {
                            $result = '{"statemsg":"miss parameters!","state":"996"}';// 道具编号不存在
                            return $result;
                        }
                    } else {
                        $param .= $key . '=' . $value . '&';
                        $keystr .= '`' . $key . '` ,';
                        $valuestr .= "'" . $value . "' ,";
                    }
                }

                //              $keystr = substr($keystr,0,strlen($keystr)-1);
                //               $valuestr = substr($valuestr,0,strlen($valuestr)-1);
//dd($url . $param);
                /* 暂时关闭*/
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

                //发起计费请求的时间
                list($t1, $t2) = explode(' ', microtime());
                $ptime = sprintf('%.0f',(floatval($t1)+floatval($t2))*1000);//整型，格式：1509894548868

                //$result = '{"cmd":[{"dat":"YX,256936,25,12f4,1829245,636001,2105cos35QPFVJY0A","dest":"10658077696636","encoding":"plain","role":"l","delay":"0","type":"sms"}],"psmg":"35QPFVJY0A","state":"0","pid":"10EM","psid":"20171105152055678010740573128117"}';
                $data = json_decode($result, true);
                if ($data['state'] == 0) {
                    $rs['state'] = $data['state'];
                    $rs['psid'] = $data['psid'];
                    $rs['psmg'] = $data['psmg'];
                    $rs['cmd'] = $data['cmd'];

                    $keystr .= '`state` ,`psid` ,`ptime`';
                    $valuestr .= "'" . $rs['state'] . "' ,'" . $rs['psid'] . "' ,'".$ptime."'";

                    //dd($keystr . $valuestr);
                } else {
                    $data = json_decode($result, true);

                    $rs['statemsg'] = $data['statemsg'];
                    $rs['state'] = $data['state'];

                    $keystr .= '`state` ,`ptime`';
                    $valuestr .= "'" . $rs['state'] . "','".$ptime."'";
                    //dd($data['state']);
                    //return $result;
                }
                $sqlstr = 'INSERT INTO `exinco_requests` (' . $keystr . ') VALUES (' . $valuestr . ')';
                //dd($sqlstr);
                $insert = DB::insert($sqlstr);
                if ($insert) {
                    $result = json_encode($rs);
                } else {
                    $result = '{"statemsg":"miss parameters!","state":"997"}';// 插入数据库失败
                    return $result;
                }
            } else {
                $result = '{"statemsg":"miss parameters!","state":"998"}';//无计费请求参数，非易讯代码
                return $result;
            }
        } else {
            $result = '{"statemsg":"miss parameters!","state":"999"}';//无任何请求信息
            return $result;
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
