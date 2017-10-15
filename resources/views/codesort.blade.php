@extends('layouts')
@section('center')
    <div style="margin:10px;">
    <table id="dg" class="easyui-datagrid" title="代码分类管理" style="width:100%;height:auto"
           data-options="
				iconCls: 'icon-edit',
				singleSelect: true,
				toolbar: '#tb',
				url: '{{url('CodeSort/show')}}',
				method: 'get',
				onDblClickRow: onDblClickRow
			">
        <thead>
        <tr>
            <th data-options="field:'id'">ID</th>
            <th data-options="field:'type_name',editor:'textbox'">类型</th>
            <th data-options="field:'parentid',
						formatter:function(value,row){
							return row.parentname;
						},
						editor:{
							type:'combobox',
							options:{
								valueField:'parentid',
								textField:'parentname',
								method:'get',
								url:'data/codes.json',
								required:true
							}
						}">父类</th>
        </tr>
        </thead>
    </table>

    <div id="tb" style="height:auto">
        <a href="javascript:void(0)" class="easyui-linkbutton" data-options="iconCls:'icon-add',plain:true" onclick="append()">新增</a>
        <a href="javascript:void(0)" class="easyui-linkbutton" data-options="iconCls:'icon-remove',plain:true" onclick="removeit()">删除</a>
        <a href="javascript:void(0)" class="easyui-linkbutton" data-options="iconCls:'icon-save',plain:true" onclick="accept()">保存</a>
        <a href="javascript:void(0)" class="easyui-linkbutton" data-options="iconCls:'icon-undo',plain:true" onclick="reject()">刷新</a>
        {{--<a href="javascript:void(0)" class="easyui-linkbutton" data-options="iconCls:'icon-search',plain:true" onclick="getChanges()">GetChanges</a>--}}
    </div>
    </div>
    <script type="text/javascript">
        var editIndex = undefined;
        function endEditing(){
            if (editIndex == undefined){return true}
            if ($('#dg').datagrid('validateRow', editIndex)){
                var ed = $('#dg').datagrid('getEditor', {index:editIndex,field:'parentid'});
                var parentname = $(ed.target).combobox('getText');
                $('#dg').datagrid('getRows')[editIndex]['parentname'] = parentname;
                $('#dg').datagrid('endEdit', editIndex);
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
                $.post("{{url('CodeSort')}}",effectRow, function(data){

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
        function getChanges(){
            var rows = $('#dg').datagrid('getChanges');
            alert(rows.length+' rows are changed!');
        }
    </script>
@endsection