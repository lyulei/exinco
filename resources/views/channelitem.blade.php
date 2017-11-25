@extends('layouts')
@section('center')
    <div style="width:100%;height: 100%;">
        <div style="width: 33%; height: auto; float: left;">
            <div style="margin:10px;">
                <table id="game" style="padding:5px;width: 100%;height:auto;"></table>
            </div>
        </div>
        <div style="width: 33%; height: auto; float: left;">
            <div style="margin:10px 10px 10px 0px;">
                <table id="channel" style="padding:5px;width: 100%;height:auto;"></table>
            </div>
        </div>
        <div style="width: 33%; height: auto; float: left;">
            <div style="margin:10px 10px 10px 0px;">
                <table id="deduct" style="padding:5px;width: 100%;height:auto;"></table>
            </div>
        </div>
    </div>
    <script>
        var code_num = {{$results["code_num"]}};
        var editIndex = undefined;
        $('#game').datagrid({
            title: '游戏 - 基本信息',
            iconCls: 'icon-edit',
            singleSelect: true,
            url: '{{url('getgame')}}/' + code_num,
            method: 'get',
            onClickRow: function (index) {
                var row = $('#game').datagrid('getSelected');
                var id = row.item_num;
                if(id){
                    linkchannel(id);
                }
            },
            columns: [[
                {field:"game_name",title:"游戏名称"},
                {field:"item_num",title:"道具编号"},
                {field:"item_name",title:"道具名称"}
            ]]
        })

        function linkchannel(id) {
            var item_num = id;
            $('#channel').datagrid({
                title: '渠道 - 基本信息',
                iconCls: 'icon-edit',
                singleSelect: true,
                url: '{{url('getcp')}}',
                method: 'get',
                onClickRow: function (index) {
                    var row = $('#channel').datagrid('getSelected');
                    var id = row.channel_id;
                    if(id){
                        setdeduct(item_num+'-'+id);
                    }
                },
                columns: [[
                    {field:"channel_id",title:"渠道编号"},
                    {field:"channel_name",title:"渠道名称"}
                ]]
            })
        }

        function endEditing() {
            if (editIndex == undefined) {
                return true
            }
            if ($('#deduct').datagrid('validateRow', editIndex)) {
                var ed = $('#deduct').datagrid('getEditor', {index: editIndex, field: 'id'});
                //alert(ed);
                var id = $(ed.target).combobox('getText');
                //alert(deduct);
                $('#deduct').datagrid('getRows')[editIndex]['deduct'] = id;
                $('#deduct').datagrid('endEdit', editIndex);
                editIndex = undefined;
                return true;
            } else {
                return false;
            }
        }

        function setdeduct(param) {
            $('#deduct').datagrid({
                title: '扣量比例',
                iconCls: 'icon-edit',
                singleSelect: true,
                toolbar: [{
                    text:'新增',
                    iconCls:'icon-add',
                    // 禁止使用新增按钮
                    disabled:true
                },{
                    text:'删除',
                    iconCls:'icon-remove',
                    // 禁止使用新增按钮
                    disabled:true
                },{
                    text:'保存',
                    iconCls:'icon-save',
                    handler:function(){
                        if (endEditing()) {
                            var $dg = $('#deduct');
                            var rows = $dg.datagrid('getChanges');
                            if (rows.length) {
                                var inserted = $dg.datagrid('getChanges', "inserted");
                                var deleted = $dg.datagrid('getChanges', "deleted");
                                var updated = $dg.datagrid('getChanges', "updated");
                                var effectRow = new Object();
                                if (inserted.length) {
                                    effectRow["id"] = index;
                                    effectRow["inserted"] = JSON.stringify(inserted);
                                }
                                if (deleted.length) {
                                    effectRow["deleted"] = JSON.stringify(deleted);
                                }
                                if (updated.length) {
                                    effectRow["updated"] = JSON.stringify(updated);
                                }
                            }
                        }
                        if (effectRow == undefined) {
                        } else {
                            $.post("{{url('deduct')}}", effectRow, function (data) {
                                if (data.status == 1) {
                                    $('#deduct').datagrid('acceptChanges');
                                    //location.href = location.href;
                                    $("#deduct").datagrid('reload');
                                }
                                else {
                                    //$("#dg").datagrid('reload');
                                    //location.href = location.href;
                                }
                            });
                        }
                    }
                },{
                    text:'撤销',
                    iconCls:'icon-undo',
                    handler:function(){
                        $('#deduct').datagrid('rejectChanges');
                        editIndex = undefined;
                    }
                }],
                url: '{{url('setdeduct')}}/'+param,
                method: 'get',
                onClickRow: function (index) {},
                onDblClickRow:function (index){
                    if (editIndex != index){
                        if (endEditing()){
                            $('#deduct').datagrid('selectRow', index)
                                .datagrid('beginEdit', index);
                            editIndex = index;
                        } else {
                            $('#deduct').datagrid('selectRow', editIndex);
                        }
                    }
                },
                columns: [[
                    {field:"id",title:"编号",hidden:true,editor:"textbox"},
                    {field:"channel_id",title:"渠道编号"},
                    {field:"item_num",title:"道具编号"},
                    {field:"deduct",title:"扣量比例（0-100整数）",editor:"numberbox"},
                ]]
            })
        }
    </script>
@endsection