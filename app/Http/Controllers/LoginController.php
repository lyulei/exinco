<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;

class LoginController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function login()
    {
        /*
        $input = Input::all();

        $data = 1;

        return $data;
        //dd($input);

        if ($input = Input::all()) {
            if ($input['account'] != '' and $input['password'] != '') {

            } else {
                return back()->with('messages','用户名密码不能为空！');
            }
            $user = DB::table('exinco_users')
                ->where('account', $input['account'])
                ->where('status','=',1)
                ->first();
            //dd($rs);
            if ($user) {
                if (Crypt::decrypt($user->password) == $input['password']) {
                    //dd(Crypt::encrypt('123456'));
                    session(['user'=>$user]);
                    //dd(session('user'));
                    return redirect('/');
                } else {
                    return back()->with('messages','密码错误！');
                }
            } else {
                return back()->with('messages','用户名不存在！');
            }
        } else {
            return view('login');
        }
        */
        return view('login');
    }

    public function loginverify(){
        $input = Input::all();
        //dd($input);
        if ($input = Input::all()) {
            $user = DB::table('exinco_users')
                ->where('account', $input['account'])
                ->where('status','=',1)
                ->first();
            //dd($rs);
            if ($user) {
                if (Crypt::decrypt($user->password) == $input['password']) {
                    //dd(Crypt::encrypt('123456'));
                    session(['user'=>$user]);
                    $data['status'] = 1;
                    $data['message'] = '';
                    //dd(session('user'));
                    //return redirect('/');
                } else {
                    $data['status'] = 0;
                    $data['message'] = urlencode('密码错误！');
                    //return back()->with('messages','密码错误！');
                }
            } else {
                $data['status'] = 0;
                $data['message'] = urlencode('用户名不存在！');
                //return back()->with('messages','用户名不存在！');
            }
        }
        $data = urldecode(json_encode($data));
        return $data;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function logout()
    {
        session(['user'=>null]);
        return redirect('Login');
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
