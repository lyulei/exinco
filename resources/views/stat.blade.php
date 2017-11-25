@extends('layouts')
@section('center')
    <div style="margin:10px;">
        <form id="search" method="post">
        <div id="p" class="easyui-panel" title="Basic Panel" style="height:auto;padding:10px;float: left;">
            <table cellpadding="5"><input type="hidden" name="_token" value="{{csrf_token()}}">
                <tr>
                    <td>开始日期:</td>
                    <td><input name="begin" class="easyui-datebox" value="{{$begin}}"></input></td>
                    <td>结束日期:</td>
                    <td><input name="end" class="easyui-datebox" value="{{$begin}}"></input></td>
                </tr>
                <tr>
                    <td>SP:</td>
                    <td><select class="easyui-combobox" name="sp" style="width: auto">
                            <option value="">全部</option>
                            @foreach ($sps as $value)
                                <option value="{{$value->code_num}}">{{$value->code_name}}</option>
                            @endforeach
                        </select></td>
                </tr>
                <tr>
                    <td>CP:</td>
                    <td><select class="easyui-combobox" name="cp" style="width: auto">
                            <option value="">全部</option>
                            @foreach ($cps as $value)
                                <option value="{{$value->channel_id}}">{{$value->channel_name}}</option>
                            @endforeach
                        </select></td>
                </tr>
                <tr>
                    <td></td>
                    <td><input type="submit" value="Submit"></input></td>
                </tr>
            </table>
        </div>
        </form>
    </div>
    <div style="margin:10px;">
        <table id="dg" class="easyui-datagrid" title="Basic Panel">
            {{--<thead>
            <tr>
                <th field="id" hidden="true">编号</th>
                <th field="game_num" hidden="true">游戏编号</th>
                <th field="param" hidden="true">参数</th>
                <th field="status" hidden="true">状态</th>
                <th field="del" hidden="true">是否删除</th>
                <th field="item_num">道具编号</th>
                <th field="item_name">道具名称</th>
                <th field="fee">道具资费</th>
                <th field="mo">MO条数</th>
                <th field="mo_fee">MO金额</th>
                <th field="zfmr">转发MR条数</th>
                <th field="klmr">扣量MR条数</th>
            </tr>
            </thead>--}}
        </table>
    </div>
    <script>
        $('#search').form({
                onSubmit: function(){
                    $.post('Stat',$("#search").serialize());
            },
            success:function(data){
                $('#dg').datagrid({title: '扣量比例',
                    iconCls: 'icon-edit',
                    singleSelect: true,
                    onClickRow: function (index) {},
                    columns: [[
                        {field:"item_num",title:"道具编号"},
                        {field:"item_name",title:"道具名称"},
                        {field:"fee",title:"道具资费"},
                        {field:"mo",title:"MO条数"},
                        {field:"zfmr",title:"转发MR条数"},
                        {field:"klmr",title:"扣量MR条数"},
                    ]]
                });
                data = JSON.parse(data);
                $('#dg').datagrid('loadData',data);
            }
        });
    </script>
@endsection