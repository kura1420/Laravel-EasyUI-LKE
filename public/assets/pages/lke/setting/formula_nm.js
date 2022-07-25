"use strict"
$(document).ready(function () {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
        }
    });

    const _rest = URL_REST + '/lke-indikator-nilai'

    var rowIndex = undefined;

    let _dg = $('#dgNilaiMinimal');
    
    let _btnAdd = $('#btnAddNilaiMinimal');
    let _btnOk = $('#btnOkNilaiMinimal');
    let _btnEdit = $('#btnEditNilaiMinimal');
    let _btnCancel = $('#btnCancelNilaiMinimal');
    let _btnRemove = $('#btnRemoveNilaiMinimal');

    let _id = $('#f_id');
    let _lke_id = $('#f_lke_id');
    let _indikator_id = $('#f_indikator_id');

    _lke_id.combobox({
        valueField:'id',
        textField:'nama',
        url: URL_REST + '/lke/lists'
    });

    _dg.datagrid({
        fit:true,
        singleSelect:true,
        collapsible:true,
        border:false,
        fitColumns:true,
        pagination:false,
        rownumbers:true,
        border:false,
        toolbar:'#tbNilaiMinimal',
        onDblClickRow: function (index, row) {
            editRow()
        },
        onEndEdit: function (index, row) {
            var ed = $(this).datagrid('getEditor', {
                index: index, 
                field: 'lke_predikat_id',
            });
    
            row.predikat_nama = $(ed.target).combobox('getText')
        },
        onBeforeSelect: function (index, row) {
            if (index !== rowIndex) {
                setTimeout(function(){
                    _dg.datagrid('selectRow', rowIndex);
                },0);
            }
        },
        columns: [[
            {
                field: 'lke_predikat_id', title: 'Predikat', width: 300,
                editor: {
                    type: 'combobox',           
                    options: {
                        required: true,
                        method: 'get',
                    },
                },
                formatter:function(value,row){
                    return row.predikat_nama;
                },
            },
            {
                field: 'nilai', title: 'Nilai Minimal', width: 300,
                editor: {
                    type: 'numberbox',
                    options: {
                        required:true,
                    },
                },
            },
        ]],
    });

    _btnAdd.linkbutton({
        onClick: function () {
            if (rowIndex == undefined) {
                prepareEditing()
            } else {
                setTimeout(function(){
                    _dg.datagrid('selectRow', rowIndex);
                },0);                
            }
        }
    });

    _btnOk.linkbutton({
        onClick: function () {
            if (rowIndex !== undefined) {
                if (endEditing()) {
                    $.messager.progress();

                    let row = _dg.datagrid('getSelected');

                    $.ajax({
                        type: "post",
                        url: _rest,
                        data: {
                            nilai: row.nilai,
                            lke_predikat_id: row.lke_predikat_id,
                            lke_id: _lke_id.combobox('getValue'),
                            lke_indikator_id: _indikator_id.combobox('getValue'),
                        },
                        dataType: "json",
                        success: function (response) {
                            $.messager.progress('close');

                            rowIndex = undefined
    
                            $.messager.show({
                                title:'Info',
                                msg:'Data saved.',
                                timeout:5000,
                                showType:'slide'
                            })                        
                        },
                        error: function (xhr, error) {
                            $.messager.progress('close'); 
                            
                            prepareEditing(row)

                            let {status, responseJSON} = xhr

                            if (status == 422) {
                                let msg = []
                                for (var d in responseJSON.data) {
                                    msg.push(responseJSON.data[d].toString())
                                }

                                Alert('warning', msg.join('<br />'));
                            } else {
                                Alert('warning', 'Internal Server Error')
                            }
                        }
                    });
                }
            } else {
                Alert('warning', 'No selected data');                
            }
        }
    });

    _btnEdit.linkbutton({
        onClick: function () {
            editRow()
        }
    });

    _btnCancel.linkbutton({
        onClick: function () {
            _dg.datagrid('rejectChanges');

            rowIndex = undefined;
        }
    });


    _btnRemove.linkbutton({
        onClick: function () {
            if (rowIndex == undefined) {
                let row = _dg.datagrid('getSelected')

                if (row) {
                    rowIndex = _dg.datagrid('getRowIndex', row)

                    $.messager.confirm('Confirmation', 'Are you sure delete this data?', function(r){
                        if (r){
                            if (row.id) {
                                $.ajax({
                                    type: "delete",
                                    url: _rest + '/' + row.id,
                                    dataType: "json",
                                    success: function (response) {
                                        loadData({
                                            lke_indikator_id: _indikator_id.combobox('getValue'),                                            
                                        })

                                        $.messager.show({
                                            title:'Info',
                                            msg:'Data deleted.',
                                            timeout:5000,
                                            showType:'slide'
                                        })
                                    },
                                    error: function (xhr, status, error) {
                                        let {statusText, responseJSON} = xhr

                                        Alert('error', responseJSON, statusText)
                                    }
                                });
                            } else {
                                _dg.datagrid('cancelEdit', rowIndex)
                                        .datagrid('deleteRow', rowIndex);

                                $.messager.show({
                                    title:'Info',
                                    msg:'Data deleted.',
                                    timeout:5000,
                                    showType:'slide'
                                });
                            }
                        }

                        rowIndex = undefined;
                    });
                } else {
                    Alert('warning', 'No selected data'); 
                }
            } else {   
                setTimeout(function(){
                    _dg.datagrid('selectRow', rowIndex);
                },0);              
            }
        }
    });

    var editRow = () => {
        if (rowIndex == undefined) {
            let row = _dg.datagrid('getSelected');

            if (row) {
                prepareEditing(row)
            }
        } else {
            setTimeout(function(){
                _dg.datagrid('selectRow', rowIndex);
            },0);             
        }
    }

    var prepareEditing = (row = null) => {
        if (row) {
            rowIndex = _dg.datagrid('getRowIndex', row);

            _dg.datagrid('selectRow', rowIndex)
                .datagrid('beginEdit', rowIndex);

            let ed = _dg.datagrid('getEditor', {
                index: rowIndex,
                field: 'lke_predikat_id'
            })

            if (ed) {
                $(ed.target).combobox({         
                    valueField:'id',
                    textField:'predikat_nama',
                    url: URL_REST + '/lke/predikat/' + _lke_id.combobox('getValue')
                })
            } else {
                Alert('warning', 'Combobox Predikat LKE tidak terformat')               
            }            
        } else {
            _dg.datagrid('appendRow', {
                nilai: 0,
            });

            rowIndex = _dg.datagrid('getRows').length-1;

            _dg.datagrid('selectRow', rowIndex)
                .datagrid('beginEdit', rowIndex);

            let ed = _dg.datagrid('getEditor', {
                index: rowIndex,
                field: 'lke_predikat_id'
            })
            
            if (ed) {
                $(ed.target).combobox({         
                    valueField:'id',
                    textField:'predikat_nama',
                    url: URL_REST + '/lke/predikat/' + _lke_id.combobox('getValue')
                })
            } else {
                Alert('warning', 'Combobox Predikat LKE tidak terformat')                    
            }
        }
    }

    var endEditing = () => {
        if (rowIndex == undefined) { return true }
        if (_dg.datagrid('validateRow', rowIndex)) {
            _dg.datagrid('endEdit', rowIndex);

            return true;
        } else {
            return false;
        }
    }

    var loadData = (params) => {
        _dg.datagrid({
            method: 'get',
            url: _rest,
            queryParams: params,
            loader: function (param, success, error) {
                let {method, url} = $(this).datagrid('options')

                if (method==null || url==null) return false

                $.ajax({
                    method: method,
                    url: url,
                    data: param,
                    dataType: 'json',
                    success: function (res) {
                        success(res)
                    },
                    error: function (xhr, status) {
                        error(xhr)
                    }
                })
            },
            onLoadError: function (objs) {
                let {statusText, responseJSON} = objs

                Alert('error', responseJSON, statusText)
            },
        });

        _dg.datagrid('fixColumnSize');
        _dg.datagrid('fixRowHeight');
    }
    
});