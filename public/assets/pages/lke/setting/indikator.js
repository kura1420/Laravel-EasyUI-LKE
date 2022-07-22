"use strict"
$(document).ready(function () {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
        }
    });

    const _rest = URL_REST + '/lke-indikator'

    let _dg = $('#dgIndikator');
    let _ff = $('#ffIndikator');
    let _ss = $('#ssIndikator');
    
    let _btnSave = $('#btnSaveIndikator');
    let _btnClear = $('#btnClearIndikator');
    let _btnEdit = $('#btnEditIndikator');
    let _btnCopy = $('#btnCopyIndikator');
    let _btnRemove = $('#btnRemoveIndikator');

    let _id = $('#i_id');
    let _urutan = $('#i_urutan');
    let _urutan_tampilkan = $('#i_urutan_tampilkan');
    let _kode = $('#i_kode');
    let _alias = $('#i_alias');
    let _indikator = $('#i_indikator');
    let _penjelasan = $('#i_penjelasan');
    let _aktif = $('#i_aktif');
    let _nilai = $('#i_nilai');
    let _parent = $('#i_parent');
    let _tipe_jawaban = $('#i_tipe_jawaban');
    let _lke_id = $('#i_lke_id');

    _lke_id.combobox({
        valueField:'id',
        textField:'nama',
        url: URL_REST + '/lke/lists'
    });

    _tipe_jawaban.combobox({
        valueField:'id',
        textField:'text',
        data: [
            {
                id: 'angka',
                text: 'Angka'
            },
            {
                id: 'pilihan',
                text: 'Pilihan',
            },
        ],
    });

    _dg.treegrid({
        singleSelect:true,
        collapsible:true,
        border:false,
        fitColumns:true,
        pagination:false,
        rownumbers:true,
        idField:'id',
        treeField:'urutan',
        lines:true,
        toolbar:'#tbIndikator',
    });

    _ss.searchbox({
        prompt: 'Search',
        searcher: function (value, name) {
            let lke_id = _lke_id.combobox('getValue')

            if (lke_id) {
                if (!value) return loadDataIndikator()

                $.ajax({
                    method: 'get',
                    url: _rest,
                    data: {
                        lke_id: lke_id,
                        search: value,
                    },
                    dataType: 'json',
                    success: function (res) {
                        _dg.treegrid('loadData', res)
                    },
                    error: function (xhr, status, error) {
                        let {statusText, responseJSON} = xhr

                        Alert('error', responseJSON, statusText)
                    }
                })
            } else {
                Alert('warning', 'Silahkan pilih LKE terlebih dahulu')                
            }
        },
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
                    param.urutan_tampilkan = _urutan_tampilkan.switchbutton('options').checked
                    param.aktif = _aktif.switchbutton('options').checked

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
                        params = {
                            lke_id: _lke_id.combobox('getValue')
                        }

                        loadData(params)

                        formReset()
    
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

    _btnClear.linkbutton({
        onClick: function () {
            formReset();
        }
    });
    
    _btnEdit.linkbutton({
        onClick: function() {
            let row = _dg.treegrid('getSelected')
    
            getData(row)
        }
    });
    
    _btnCopy.linkbutton({
        onClick: function () {  
            let row = _dg.treegrid('getSelected')
        
            if (row) {
                $.get(_rest + "/" + row.id,
                    function (data, textStatus, jqXHR) {
                        delete data.id
                        

                        _ff.form('load', {
                            i_urutan: data.urutan,
                            i_urutan_tampilkan: data.urutan_tampilkan,
                            i_kode: data.kode,
                            i_alias: data.alias,
                            i_indikator: data.indikator,
                            i_penjelasan: data.penjelasan,
                            i_aktif: data.aktif,
                            i_nilai: data.nilai,
                            i_parent: data.parent,
                            i_tipe_jawaban: data.tipe_jawaban,
                            // i_lke_i: lke_id
                        })
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
            let row = _dg.treegrid('getSelected')
    
            if (row) {
                $.messager.confirm('Confirmation', 'Are you sure delete this data?', function(r){
                    if (r){
                        $.ajax({
                            type: "delete",
                            url: _rest + '/' + row.id,
                            dataType: "json",
                            success: function (response) {
                                params = {
                                    lke_id: _i_lke_id.combobox('getValue')
                                }

                                loadData(params)
    
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

    var formReset = () => {
        _id.textbox('clear');
        _urutan.numberbox('clear');
        _urutan_tampilkan.switchbutton('clear');
        _kode.textbox('clear');
        _alias.textbox('clear');
        _indikator.textbox('clear');
        _penjelasan.textbox('clear');
        _aktif.switchbutton('clear');
        _nilai.numberbox('clear');
        _parent.combotree('clear');
        _tipe_jawaban.combobox('clear');
    }

    var loadData = (params) => {
        _dg.treegrid({
            method: 'get',
            url: _rest,
            queryParams: params,
            onDblClickRow: function (row) {
                getData(row)
            },
            loader: function (param, success, error) {

                let {method, url} = $(this).treegrid('options')
                
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

        _dg.treegrid('fixColumnSize');
        _dg.treegrid('fixRowHeight');
    }

    var getData = (row) => {
        if (row) {    
            $.ajax({
                type: "GET",
                url: _rest + '/' + row.id,
                dataType: "json",
                success: function (response) {
                    let {
                        id,
                        urutan,
                        urutan_tampilkan,
                        kode,
                        alias,
                        indikator,
                        penjelasan,
                        aktif,
                        nilai,
                        parent,
                        tipe_jawaban,
                        lke_id
                    } = response

                    _ff.form('load', {
                        i_id: id,
                        i_urutan: urutan,
                        i_urutan_tampilkan: urutan_tampilkan,
                        i_kode: kode,
                        i_alias: alias,
                        i_indikator: indikator,
                        i_penjelasan: penjelasan,
                        i_aktif: aktif,
                        i_nilai: nilai,
                        i_parent: parent,
                        i_tipe_jawaban: tipe_jawaban,
                        // i_lke_i: lke_id
                    })
                },
            });
        } else {
            Alert('warning', 'ID not found')
        }
    }
});