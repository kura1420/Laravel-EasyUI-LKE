"use strict";
$(document).ready(function () {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
        }
    });    

    const _rest = URL_REST + '/lke-indikator-jawaban'

    let _dg = $('#dgJawaban');
    let _w = $('#wJawaban');
    let _ff = $('#ffJawaban');
    
    let _btnAdd = $('#btnAddJawaban');
    let _btnSave = $('#btnSaveJawaban');
    let _btnEdit = $('#btnEditJawaban');
    let _btnCopy = $('#btnCopyJawaban');
    let _btnCancel = $('#btnCancelJawaban');
    let _btnRemove = $('#btnRemoveJawaban');

    let _id = $('#j_id');
    let _urutan = $('#j_urutan');
    let _jawaban = $('#j_jawaban');
    let _nilai = $('#j_nilai');
    let _penjelasan = $('#j_penjelasan');
    let _aktif = $('#j_aktif');

    _dg.datagrid({
        fit:true,
        singleSelect:true,
        collapsible:true,
        border:false,
        fitColumns:true,
        pagination:false,
        rownumbers:true,
        border:false,
        toolbar:'#tbJawaban',
    });

    _btnAdd.linkbutton({
        onClick: function() {
            let indikator_id = $('#f_indikator_id').combotree('getValue');
            let tipe_jawaban = $('#f_tipe_jawaban').combobox('getValue');
            
            if (tipe_jawaban === 'pilihan') {
                if (!indikator_id) {
                    Alert('warning', 'Silahkan pilih indikator target terlebih dahulu');
                } else {
                    _w.window('open');
        
                    _ff.form('clear');
                }
            } else {
                Alert('warning', 'Tipe jawaban bukan pilihan');                
            }            
        }
    });

    _btnSave.linkbutton({
        onClick: function() {
            $.messager.progress();
    
            _ff.form('submit', {
                url: _rest,
                onSubmit: function(param) {
                    var isValid = $(this).form('validate');
                    if (!isValid){
                        $.messager.progress('close');
                    }
    
                    param.id = _id.textbox('getValue')
                    param.lke_id = $('#f_lke_id').combobox('getValue');
                    param.lke_indikator_id = $('#f_indikator_id').combotree('getValue');
                    param.aktif = _aktif.switchbutton('options').checked;

                    param._token = $('meta[name="csrf-token"]').attr('content')
    
                    return isValid;
                },
                success: function(res) {
                    $.messager.progress('close');
    
                    let {status, data} = JSON.parse(res)
    
                    if (status == 'NOT') {
                        let msg = []
                        for (var d in data) {
                            msg.push(data[d].toString())
                        }
    
                        Alert('warning', msg.join('<br />'))
                    } else {
                        let indikator_id = $('#f_indikator_id').combotree('getValue');

                        loadData({
                            lke_indikator_id:  indikator_id,
                        })

                        _w.window('close');
    
                        $.messager.show({
                            title:'Info',
                            msg:'Data saved.',
                            timeout:5000,
                            showType:'slide'
                        })
                    }
                },
            })
        }
    });
    
    _btnEdit.linkbutton({
        onClick: function() {
            let row = _dg.datagrid('getSelected');

            let indikator_id = $('#f_indikator_id').combotree('getValue');
            let tipe_jawaban = $('#f_tipe_jawaban').combobox('getValue');

            if (tipe_jawaban === 'pilihan') {            
                if (!indikator_id) {
                    Alert('warning', 'Silahkan pilih indikator target terlebih dahulu');
                } else {      
                    getData(row)
                }                
            } else {
                Alert('warning', 'Tipe jawaban bukan pilihan');                 
            }
        }
    });
    
    _btnCopy.linkbutton({
        onClick: function () {  
            let row = _dg.datagrid('getSelected')
        
            if (row) {
                $.get(_rest + "/" + row.id,
                    function (data, textStatus, jqXHR) {
                        delete data.id
                        
                        let {
                            urutan,
                            jawaban,
                            nilai,
                            penjelasan,
                            aktif,
                        } = data
    
                        _w.window('open');

                        _ff.form('load', {
                            j_urutan: urutan,
                            j_jawaban: jawaban,
                            j_nilai: nilai,
                            j_penjelasan: penjelasan,
                            j_aktif: aktif,
                        });
                    },
                    "json"
                );
            } else {
                Alert('warning', 'No selected data')
            }
        }
    });

    _btnRemove.linkbutton({
        onClick: function() {
            let row = _dg.datagrid('getSelected')
    
            if (row) {
                $.messager.confirm('Confirmation', 'Are you sure delete this data?', function(r){
                    if (r){
                        $.ajax({
                            type: "delete",
                            url: _rest + '/' + row.id,
                            dataType: "json",
                            success: function (response) {
                                let indikator_id = $('#f_indikator_id').combotree('getValue');
        
                                loadData({
                                    lke_indikator_id:  indikator_id,
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
                    }
                });
            } else {
                Alert('warning', 'No selected data')
            }
        }
    });

    _btnCancel.linkbutton({
        onClick: function () {
            _w.window('close');

            _ff.form('clear');
        }
    });

    var loadData = (params) => {
        _dg.datagrid({
            method: 'get',
            url: _rest,
            queryParams: params,
            onDblClickRow: function (index, row) {
                getData(row);
            },
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

    var getData = (row) => {
        if (row) {  
            $.ajax({
                type: "get",
                url: _rest + '/' + row.id,
                dataType: "json",
                success: function (response) {
                    let {
                        id,
                        urutan,
                        jawaban,
                        nilai,
                        penjelasan,
                        aktif,
                    } = response

                    _w.window('open');  

                    _ff.form('load', {
                        j_id: id,
                        j_urutan: urutan,
                        j_jawaban: jawaban,
                        j_nilai: nilai,
                        j_penjelasan: penjelasan,
                        j_aktif: aktif,
                    });
                }
            });
        } else {
            Alert('warning', 'ID not found')
        }
    }
});