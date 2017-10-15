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
<body id="cc" class="easyui-layout">
<div data-options="region:'north',border:false" style="height:60px;background:#B3DFDA;padding:10px">EXINCO计费平台<div style="float:right;margin-top:12px;">管理员：吕雷 | 修改密码 | <a href="{{url('Logout')}}">退出</a></div></div>

<!-- 左边树状菜单 开始 -->
<div data-options="region:'west',split:true,title:'功能菜单'" style="width:15%;padding:10px;">
    <div class="easyui-panel" style="padding:5px;border:0;">
        {{--<ul id="tree" data-options="url:'{{ URL::asset('data/tree_data.json') }}',method:'get'"></ul>--}}
        <ul id="tree" data-options="url:'{{ url('gettree') }}',method:'get'"></ul>
    </div>
</div>
<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $('#tree').tree({
        onClick: function(node){
            location.href ='/'+node.name;
            node.checked == true;
        }
    });
</script>
<!-- 左边树状菜单 结束 -->

<div data-options="region:'south',border:false" style="height:50px;background:#A9FACD;padding:10px;">北京奕信时刻信息科技有限公司</div>

<!-- 右边内容 开始 -->
{{--<div data-options="region:'center',title:'Center',href:'{{url('SpConf')}}'">--}}
<div data-options="region:'center',title:'功能区'">
    @yield('center')
</div>
<!-- 右边内容 开始 -->

</body>
</html>