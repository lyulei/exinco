@extends('layouts')
@section('center')
    <div style="margin:10px;">
        <table id="channel" style="padding:5px;width: 100%;height:auto;"></table>
    </div>
    <script>
        var editIndex = undefined;

        function endEditing() {
            if (editIndex == undefined) {
                return true
            }
            if ($('#channel').datagrid('validateRow', editIndex)) {
                var ed = $('#channel').datagrid('getEditor', {index: editIndex, field: 'channel_id'});
                //alert(ed);
                var channel_id = $(ed.target).combobox('getText');
                //alert(game_name);
                $('#channel').datagrid('getRows')[editIndex]['channel_id'] = channel_id;
                $('#channel').datagrid('endEdit', editIndex);
                editIndex = undefined;
                return true;
            } else {
                return false;
            }
        }

        $('#channel').datagrid({
            title: '渠道配置管理',
            iconCls: 'icon-edit',
//                    width:600,
//                    height:500,
            singleSelect: true,
            toolbar: [{
                text: '新增',
                iconCls: 'icon-add',
                handler: function () {
                    if (endEditing()) {
                        $('#channel').datagrid('appendRow', {status: 'Yes'});
                        editIndex = $('#channel').datagrid('getRows').length - 1;
                        $('#channel').datagrid('selectRow', editIndex)
                            .datagrid('beginEdit', editIndex);
                    }
                }
            }, {
                text: '删除',
                iconCls: 'icon-remove',
                handler: function () {
                    if (editIndex == undefined) {
                        return
                    }
                    $('#channel').datagrid('cancelEdit', editIndex)
                        .datagrid('deleteRow', editIndex);
                    editIndex = undefined;
                }
            }, {
                text: '保存',
                iconCls: 'icon-save',
                handler: function () {
                    if (endEditing()) {
                        var rows = $('#channel').datagrid('getChanges');
                        var $dg = $('#channel');
                        var rows = $dg.datagrid('getChanges');
                        if (rows.length) {
                            var inserted = $dg.datagrid('getChanges', "inserted");
                            var deleted = $dg.datagrid('getChanges', "deleted");
                            var updated = $dg.datagrid('getChanges', "updated");
                            var effectRow = new Object();
                            if (inserted.length) {
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
                        $.post("{{url('Channel')}}", effectRow, function (data) {
                            if (data.status == 1) {
                                $('#channel').datagrid('acceptChanges');
                                //location.href = location.href;
                                $("#channel").datagrid('reload');
                            }
                            else {
                                //$("#dg").datagrid('reload');
                                //location.href = location.href;
                            }
                        });
                    }
                }
            }, {
                text: '撤销',
                iconCls: 'icon-undo',
                handler: function () {
                    $('#channel').datagrid('rejectChanges');
                    editIndex = undefined;
                }
            }],
            url: '{{url('getchannel')}}',
            method: 'get',
            onClickRow: function (index) {},
            onDblClickRow: function (index) {
                if (editIndex != index) {
                    if (endEditing()) {
                        $('#channel').datagrid('selectRow', index)
                            .datagrid('beginEdit', index);
                        editIndex = index;
                    } else {
                        $('#channel').datagrid('selectRow', editIndex);
                    }
                }
            },
            columns: [[
                /*{field:'id',title:'ID',hidden:true},*/
                {field:'id',title:'ID'},
                {field:'channel_id',title:'渠道编号',editor:'numberbox'},
                {field:'channel_name',title:'渠道名称',editor:'textbox'},
                {field:'mo',title:'回传地址（MO/一次）',editor:'textbox'},
                {field:'mr',title:'回传地址（MR）',editor:'textbox'},
                {field:'remarks',title:'备注信息',editor:'textbox'},
                {field:'cb',title:'是否回传',editor:'textbox'},
                {field:'cbfail',title:'是否回传失败',editor:'textbox'},
                {field:'dedup',title:'是否流水号去重',editor:'textbox'},
                {field:'lac',title:'是否验证LAC',editor:'textbox'},
                {field:'ip',title:'是否限制IP',editor:'textbox'},
                {field:'status',title:'激活状态',editor:'textbox'}
            ]]
        });
    </script>
@endsection