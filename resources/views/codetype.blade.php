@extends('layouts')
@section('center')
    <div style="width:98%;float:left">
        <div style="margin:10px;width:30%;float: left">
        <table id="dg" class="easyui-datagrid" title="代码类型管理" style="width:98%;height:auto"
               data-options="
				iconCls: 'icon-edit',
				singleSelect: true,
				toolbar: '#tb',
				url: '{{url('getcode')}}',
				method: 'get',
				onClickRow:onClickRow,
				onDblClickRow: onDblClickRow
			">
            <thead>
            <tr>
                <th data-options="field:'id'">ID</th>
                <th data-options="field:'code_num',editor:'numberbox'">代码编号</th>
                {{--<th data-options="field:'type_name',width:100,editor:'textbox'">类型</th>--}}
                <th data-options="field:'code_sort',
						formatter:function(value,row){
							return row.type_name;
						},
						editor:{
							type:'combobox',
							options:{
								valueField:'code_sort',
								textField:'type_name',
								method:'get',
								url:'{{url('getcodetype')}}',
								required:true
							}
						}">代码类型</th>
                <th data-options="field:'code_name',editor:'textbox'">代码名称</th>
                <th data-options="field:'dis',editor:{type:'checkbox',options:{on:'Yes',off:'No'}}">是否显示</th>
            </tr>
            </thead>
        </table>

        <div id="tb" style="height:auto">
            <a href="javascript:void(0)" class="easyui-linkbutton" data-options="iconCls:'icon-add',plain:true" onclick="append()">新增</a>
            <a href="javascript:void(0)" class="easyui-linkbutton" data-options="iconCls:'icon-remove',plain:true" onclick="removeit()">删除</a>
            <a href="javascript:void(0)" class="easyui-linkbutton" data-options="iconCls:'icon-save',plain:true" onclick="accept()">保存</a>
            <a href="javascript:void(0)" class="easyui-linkbutton" data-options="iconCls:'icon-undo',plain:true" onclick="reject()">撤销</a>
            {{--<a href="javascript:void(0)" class="easyui-linkbutton" data-options="iconCls:'icon-search',plain:true" onclick="getChanges()">GetChanges</a>--}}
        </div>
        </div>

        <div style="margin:10px;width:30%;float: left">
            <table id="dg1"></table>
        </div>

        {{--<div style="margin:10px;width:30%;float: left">--}}
            {{--<table id="dg2"></table>--}}
        {{--</div>--}}

        <script type="text/javascript">
            var editIndex = undefined;
            function endEditing(){
                if (editIndex == undefined){return true}
                if ($('#dg').datagrid('validateRow', editIndex)){
                    var ed = $('#dg').datagrid('getEditor', {index:editIndex,field:'code_sort'});
                    var type_name = $(ed.target).combobox('getText');
                    $('#dg').datagrid('getRows')[editIndex]['type_name'] = type_name;
                    $('#dg').datagrid('endEdit', editIndex);
                    editIndex = undefined;
                    return true;
                } else {
                    return false;
                }
            }
            function dg1endEditing(){
                if (editIndex == undefined){return true}
                if ($('#dg1').datagrid('validateRow', editIndex)){
                    var ed = $('#dg1').datagrid('getEditor', {index:editIndex,field:'param_type'});
                    var param_name = $(ed.target).combobox('getText');
                    $('#dg1').datagrid('getRows')[editIndex]['param_name'] = param_name;
                    $('#dg1').datagrid('endEdit', editIndex);
                    editIndex = undefined;
                    return true;
                } else {
                    return false;
                }
            }
            function onDblClickRow(index){
                if (editIndex != index){
                    if (endEditing()){
                        $('#dg').datagrid('selectRow', index)
                            .datagrid('beginEdit', index);
                        editIndex = index;
                    } else {
                        $('#dg').datagrid('selectRow', editIndex);
                    }
                }
            }
            function onClickRow(index) {
                //alert(index);
                var row = $('#dg').datagrid('getSelected');
                var code_num = row.code_num;
                $('#dg1').datagrid({
                    title:'游戏/道具参数设置',
                    iconCls:'icon-edit',
//                    width:600,
//                    height:500,
                    singleSelect:true,
                    toolbar: [{
                        text:'新增',
                        iconCls:'icon-add',
                        handler:function(){
                            if (dg1endEditing()){
                                //alert(index);
                                $('#dg1').datagrid('appendRow',{param_remarks:''});
                                editIndex = $('#dg1').datagrid('getRows').length-1;
                                $('#dg1').datagrid('selectRow', editIndex)
                                    .datagrid('beginEdit', editIndex);
                            }
                        }
                    },{
                        text:'删除',
                        iconCls:'icon-remove',
                        handler:function(){
                            if (editIndex == undefined){return}
                            $('#dg1').datagrid('cancelEdit', editIndex)
                                .datagrid('deleteRow', editIndex);
                            editIndex = undefined;
                        }
                    },{
                        text:'保存',
                        iconCls:'icon-save',
                        handler:function(){
                            //alert(code_num)
                            if (dg1endEditing()) {
                                var rows = $('#dg1').datagrid('getChanges');
                                var $dg = $('#dg1');
                                var rows = $dg.datagrid('getChanges');
                                if (rows.length) {
                                    var inserted = $dg.datagrid('getChanges', "inserted");
                                    var deleted = $dg.datagrid('getChanges', "deleted");
                                    var updated = $dg.datagrid('getChanges', "updated");
                                    var effectRow = new Object();
                                    //effectRow["code_num"] = code_num;
                                    //var obj = JSON.stringify(inserted);
                                    //obj['code_num']=code_num;
                                   //alert(inserted.text);
                                    if (inserted.length) {
                                        effectRow["code_num"] = code_num;
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
                            if(effectRow == undefined){

                            } else {


                                $.post("{{url('GameItem')}}",effectRow, function(data){

                                    if(data.status == 1){
                                        $('#dg1').datagrid('acceptChanges');
                                        //location.href = location.href;
                                        $("#dg1").datagrid('reload');
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
                            $('#dg1').datagrid('rejectChanges');
                            editIndex = undefined;
                        }
                    }],
                    url:'{{url('getparam')}}/'+code_num,
                    method: 'get',
                    //onClickRow:'onClickRow',
                    onClickRow:function (index){},
                    onDblClickRow:function (index){
                        if (editIndex != index){
                            if (dg1endEditing()){
                                $('#dg1').datagrid('selectRow', index)
                                    .datagrid('beginEdit', index);
                                editIndex = index;
                            } else {
                                $('#dg1').datagrid('selectRow', editIndex);
                            }
                        }
                    },
                    columns:[[
                        {field:'id',title:'ID'},
                        {field:'code_num',title:'代码编号',hidden:true},
                        {field:'param_type',title:'参数类型',
                            formatter:function(value,row){
                                return row.param_name;
                            },editor:{
                            type:'combobox',options:{
                                valueField:'param_type',
                                textField:'param_name',
                                method:'get',
                                url:'{{url('getparamtype')}}',
                                required:true
                            }
                        }},
                        {field:'field_name',title:'字段名',editor:'textbox'},
                        {field:'param_remarks',title:'参数备注',editor:'textbox'}
                    ]]
                });
                //dg2(code_num);
            }
            function append(){
                if (endEditing()){
                    //$('#dg').datagrid('appendRow',{status:'P'});
                    $('#dg').datagrid('appendRow',{del:'NO'});
                    editIndex = $('#dg').datagrid('getRows').length-1;
                    $('#dg').datagrid('selectRow', editIndex)
                        .datagrid('beginEdit', editIndex);
                }
            }
            function removeit(){
                if (editIndex == undefined){return}
                $('#dg').datagrid('cancelEdit', editIndex)
                    .datagrid('deleteRow', editIndex);
                editIndex = undefined;
            }
            function accept(){
                if (endEditing()) {
                    var rows = $('#dg').datagrid('getChanges');
                    var $dg = $('#dg');
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
                if(effectRow == undefined){

                } else {
                    $.post("{{url('CodeType')}}",effectRow, function(data){

                        if(data.status == 1){
                            $('#dg').datagrid('acceptChanges');
                            //location.href = location.href;
                            $("#dg").datagrid('reload');
                        }
                        else {
                            //$("#dg").datagrid('reload');
                            //location.href = location.href;
                        }
                    });
                }
            }
            function reject(){
                $('#dg').datagrid('rejectChanges');
                editIndex = undefined;
            }
            function dg2(code_num){
                //alert(code_num);
                $('#dg2').datagrid({
                    title:'Editable DataGrid 2',
                    iconCls:'icon-edit',
//                    width:600,
//                    height:500,
                    singleSelect:true,
                    toolbar: [{
                        text:'新增',
                        iconCls:'icon-add',
                        handler:function(){
                            alert('add')
                        }
                    },{
                        text:'删除',
                        iconCls:'icon-remove',
                        handler:function(){
                            alert('remove')
                        }
                    },{
                        text:'保存',
                        iconCls:'icon-save',
                        handler:function(){
                            alert('save')
                        }
                    },{
                        text:'撤销',
                        iconCls:'icon-undo',
                        handler:function(){
                            alert('undo')
                        }
                    }],
                    url:'{{url('getparam')}}/'+code_num,
                    method: 'get',
                    //onClickRow:'onClickRow',
                    onClickRow:function (index){},
                    onDblClickRow:function (index){
                        if (editIndex != index){
                            if (dg1endEditing()){
                                $('#dg1').datagrid('selectRow', index)
                                    .datagrid('beginEdit', index);
                                editIndex = index;
                            } else {
                                $('#dg1').datagrid('selectRow', editIndex);
                            }
                        }
                    },
                    columns:[[
                        {field:'id',title:'ID'},
                        {field:'param_type',title:'参数类型',
                            formatter:function(value,row){
                                return row.param_name;
                            },editor:{
                            type:'combobox',options:{
                                valueField:'param_type',
                                textField:'param_name',
                                method:'get',
                                url:'{{url('getparamtype')}}',
                                required:true
                            }
                        }},
                        {field:'field_name',title:'字段名',editor:'textbox'},
                        {field:'param_remarks',title:'参数备注',editor:'textbox'}
                    ]]
                });
            }
        </script>
    </div>
@endsection