@extends('layouts')
@section('center')
    <div style="width:100%;height: 100%;">
        <div style="width: 70%; height: auto; float: left;">
            <div style="margin:10px;">
                <table id="game" style="padding:5px;width: 100%;height:auto;"></table>
            </div>
            <div style="margin:10px;">
                <table id="item" style="padding:5px;width: 100%;height:auto;"></table>
            </div>
        </div>
        <div style="width: 30%; height: auto; float: left;">
            <div style="margin:10px 10px 10px 0px;">
                <table id="limit" style="padding:5px;width: 100%;height:auto;"></table>
            </div>
        </div>
    </div>
    <script>
        var code_num =
                {{$results["code_num"]}}
        var editIndex = undefined;

        function endEditing() {
            if (editIndex == undefined) {
                return true
            }
            if ($('#game').datagrid('validateRow', editIndex)) {
                var ed = $('#game').datagrid('getEditor', {index: editIndex, field: 'game_name'});
                //alert(ed);
                var game_name = $(ed.target).combobox('getText');
                //alert(game_name);
                $('#game').datagrid('getRows')[editIndex]['game_name'] = game_name;
                $('#game').datagrid('endEdit', editIndex);
                editIndex = undefined;
                return true;
            } else {
                return false;
            }
        }

        function onDblClickRow(index) {
            if (editIndex != index) {
                if (endEditing()) {
                    $('#game').datagrid('selectRow', index)
                        .datagrid('beginEdit', index);
                    editIndex = index;
                } else {
                    $('#game').datagrid('selectRow', editIndex);
                }
            }
        }

        $('#game').datagrid({
            title: '游戏 - 基本信息',
            iconCls: 'icon-edit',
//                    width:600,
//                    height:500,
            singleSelect: true,
            toolbar: [{
                text: '新增',
                iconCls: 'icon-add',
                handler: function () {
                    if (endEditing()) {
                        $('#game').datagrid('appendRow', {status: 'Yes'});
                        editIndex = $('#game').datagrid('getRows').length - 1;
                        $('#game').datagrid('selectRow', editIndex)
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
                    $('#game').datagrid('cancelEdit', editIndex)
                        .datagrid('deleteRow', editIndex);
                    editIndex = undefined;
                }
            }, {
                text: '保存',
                iconCls: 'icon-save',
                handler: function () {
                    if (endEditing()) {
                        var rows = $('#game').datagrid('getChanges');
                        var $dg = $('#game');
                        var rows = $dg.datagrid('getChanges');
                        if (rows.length) {
                            var inserted = $dg.datagrid('getChanges', "inserted");
                            var deleted = $dg.datagrid('getChanges', "deleted");
                            var updated = $dg.datagrid('getChanges', "updated");
                            var effectRow = new Object();
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
                    if (effectRow == undefined) {

                    } else {
                        $.post("{{url('CodeInfo')}}", effectRow, function (data) {
                            if (data.status == 1) {
                                $('#game').datagrid('acceptChanges');
                                //location.href = location.href;
                                $("#game").datagrid('reload');
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
                    $('#game').datagrid('rejectChanges');
                    editIndex = undefined;
                }
            }],
            url: '{{url('getgameinfo')}}/' + code_num,
            method: 'get',
            onClickRow: function (index) {
                //alert(index);
                var row = $('#game').datagrid('getSelected');
                var id = row.id;
                if(id){
                    itemdg(id);
                    limitdg(id);
                }
            },
            onDblClickRow: function (index) {
                if (editIndex != index) {
                    if (endEditing()) {
                        $('#game').datagrid('selectRow', index)
                            .datagrid('beginEdit', index);
                        editIndex = index;
                    } else {
                        $('#game').datagrid('selectRow', editIndex);
                    }
                }
            },
            columns: [[
                {!!$results["columns"]!!}
            ]]
        });
//------ item dg begin -----------------------
        function itemdgendEditing() {
            if (editIndex == undefined) {
                return true
            }
            if ($('#item').datagrid('validateRow', editIndex)) {
                var ed = $('#item').datagrid('getEditor', {index: editIndex, field: 'item_name'});
                //alert(ed);
                var item_name = $(ed.target).combobox('getText');
                //alert(game_name);
                $('#item').datagrid('getRows')[editIndex]['item_name'] = item_name;
                $('#item').datagrid('endEdit', editIndex);
                editIndex = undefined;
                return true;
            } else {
                return false;
            }
        }
        function itemdg(index){
            //alert(index);
            $('#item').datagrid({
                title:'道具/代码 - 基本信息',
                iconCls:'icon-edit',
//                    width:600,
//                    height:500,
                singleSelect:true,
                toolbar: [{
                    text:'新增',
                    iconCls:'icon-add',
                    handler:function(){
                        if (endEditing()) {
                            $('#item').datagrid('appendRow', {status: 'Yes'});
                            editIndex = $('#item').datagrid('getRows').length - 1;
                            $('#item').datagrid('selectRow', editIndex)
                                .datagrid('beginEdit', editIndex);
                        }
                    }
                },{
                    text:'删除',
                    iconCls:'icon-remove',
                    handler:function(){
                        if (editIndex == undefined) {
                            return
                        }
                        $('#item').datagrid('cancelEdit', editIndex)
                            .datagrid('deleteRow', editIndex);
                        editIndex = undefined;
                    }
                },{
                    text:'保存',
                    iconCls:'icon-save',
                    handler:function(){
                        if (itemdgendEditing()) {
                            var rows = $('#item').datagrid('getChanges');
                            var $dg = $('#item');
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
                            $.post("{{url('ItemInfo')}}", effectRow, function (data) {
                                if (data.status == 1) {
                                    $('#item').datagrid('acceptChanges');
                                    //location.href = location.href;
                                    $("#item").datagrid('reload');
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
                        $('#item').datagrid('rejectChanges');
                        editIndex = undefined;
                    }
                }],
                url:'{{url('getiteminfo')}}/'+index,
                method: 'get',
                //onClickRow:'onClickRow',
                onClickRow:function (index){},
                onDblClickRow:function (index){
                    if (editIndex != index){
                        if (itemdgendEditing()){
                            $('#item').datagrid('selectRow', index)
                                .datagrid('beginEdit', index);
                            editIndex = index;
                        } else {
                            $('#item').datagrid('selectRow', editIndex);
                        }
                    }
                },
                columns:[[
                    {!!$results["itemcolumns"]!!}
                ]]
            });
        }
//------ limit dg begin -----------------------
        function limitdgendEditing() {
            if (editIndex == undefined) {
                return true
            }
            if ($('#limit').datagrid('validateRow', editIndex)) {
                var ed = $('#limit').datagrid('getEditor', {index: editIndex, field: 'begin_date'});
                //alert(ed);
                var begin_date = $(ed.target).combobox('getText');
                //alert(game_name);
                $('#limit').datagrid('getRows')[editIndex]['begin_date'] = begin_date;
                $('#limit').datagrid('endEdit', editIndex);
                editIndex = undefined;
                return true;
            } else {
                return false;
            }
        }
        function limitdg(index){
            //alert(index);
            $('#limit').datagrid({
                title:'代码日限（金额）',
                iconCls:'icon-edit',
//                    width:600,
//                    height:500,
                singleSelect:true,
                toolbar: [{
                    text:'新增',
                    // 禁止使用新增按钮
                    disabled:true,
                    iconCls:'icon-add',
                    handler:function(){
                        if (limitdgendEditing()) {
                            $('#limit').datagrid('appendRow', {status: 'Yes'});
                            editIndex = $('#limit').datagrid('getRows').length - 1;
                            $('#limit').datagrid('selectRow', editIndex)
                                .datagrid('beginEdit', editIndex);
                        }
                    }
                },{
                    text:'删除',
                    // 禁止使用新增按钮
                    disabled:true,
                    iconCls:'icon-remove',
                    handler:function(){
                        if (editIndex == undefined) {
                            return
                        }
                        $('#limit').datagrid('cancelEdit', editIndex)
                            .datagrid('deleteRow', editIndex);
                        editIndex = undefined;
                    }
                },{
                    text:'保存',
                    iconCls:'icon-save',
                    handler:function(){
                        if (limitdgendEditing()) {
                            var rows = $('#limit').datagrid('getChanges');
                            var $dg = $('#limit');
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
                            $.post("{{url('CodeLimit')}}", effectRow, function (data) {
                                if (data.status == 1) {
                                    $('#limit').datagrid('acceptChanges');
                                    //location.href = location.href;
                                    $("#limit").datagrid('reload');
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
                        $('#limit').datagrid('rejectChanges');
                        editIndex = undefined;
                    }
                }],
                url:'{{url('getcodelimit')}}/'+index,
                method: 'get',
                //onClickRow:'onClickRow',
                onClickRow:function (index){},
                onDblClickRow:function (index){
                    if (editIndex != index){
                        if (limitdgendEditing()){
                            $('#limit').datagrid('selectRow', index)
                                .datagrid('beginEdit', index);
                            editIndex = index;
                        } else {
                            $('#limit').datagrid('selectRow', editIndex);
                        }
                    }
                },
                columns:[[
                    {!!$results["limitcolumns"]!!}
                ]]
            });
        }
    </script>
@endsection