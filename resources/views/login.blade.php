{{--
<form method="POST" action="Login">
    {!! csrf_field() !!}
@if(session('messages'))
    {{session('messages')}}
    @endif
    <div>
        用户名：
        <input type="text" name="account">
    </div>

    <div>
        密码：
        <input type="password" name="password" id="password">
    </div>

    <div>
        <button type="submit">Login</button>
    </div>
</form>--}}
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <title>EXINCO计费平台</title>

    <link rel="stylesheet" type="text/css" href="{{ URL::asset('easyui/themes/default/easyui.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ URL::asset('easyui/themes/icon.css') }}">

    <script type="text/javascript" src="{{ URL::asset('easyui/jquery.min.js') }}"></script>
    <script type="text/javascript" src="{{ URL::asset('easyui/jquery.easyui.min.js') }}"></script>
</head>
<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
</script>
<body id="cc" class="easyui-layout">
<div style="position:absolute; left:50%; top:30%; margin-left:-150px; margin-top:-100px;">
<div id="p" class="easyui-panel" title="请登录" style="width:280px;padding:10px;">
    <form id="login">
        <table cellpadding="3">
            <tr>
                <td>账户:</td>
                <td><input class="easyui-textbox" type="text" id="account" name="account" data-options="required:true"></input></td>
            </tr>
            <tr>
                <td>密码:</td>
                <td><input class="easyui-textbox" type="password" id="password" name="password" data-options="required:true"></input></td>
            </tr>
        </table>
    </form>
    <div style="text-align:center;padding:5px">
        <a href="javascript:void(0)" class="easyui-linkbutton" onclick="login()"> 登 录 </a>
    </div>
</div>
</div>
<script>
    function login(){
        //$('#login').form('submit');
        $('#login').form('submit', {
            url:'{{url('loginverify')}}',
            method: 'get',
            onSubmit: function(){
                var isValid = $(this).form('validate');//验证表单中的一些控件的值是否填写正确，比如某些文本框中的内容必须是数字
                if (!isValid) {
                }
                return isValid; // 如果验证不通过，返回false终止表单提交
        },
        success:function(data){
            data = JSON.parse( data );
            //alert(data.status);
            if (data.status == 1) {
                location.href ='/'
            }
            else {
                //alert(data.message);
                $.messager.alert('Info', data.message, 'info');
                //$("#dg").datagrid('reload');
                //location.href = location.href;
            }
        }
        });
    }
</script>
</body>