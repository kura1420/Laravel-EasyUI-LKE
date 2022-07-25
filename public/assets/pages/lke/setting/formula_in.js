"use strict"
$(document).ready(function () {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
        }
    });

    const _rest = URL_REST + '/lke-indikator-formula'

    let _dg = $('#dgIndikatorFormula');
    let _w = $('#wIndikatorFormula');
    let _ff = $('#ffIndikatorFormula');
    
    let _btnAdd = $('#btnAddIndikatorFormula');
    let _btnSave = $('#btnSaveIndikatorFormula');
    let _btnEdit = $('#btnEditIndikatorFormula');
    let _btnCopy = $('#btnCopyIndikatorFormula');
    let _btnCancel = $('#btnCancelIndikatorFormula');
    let _btnRemove = $('#btnRemoveIndikatorFormula');

    let _id = $('#f_id');
    let _urutan = $('#f_urutan');
    let _rumus = $('#f_rumus');
    let _lke_indikator_id_target = $('#f_lke_indikator_id_target');
    let _nilai_maksimal = $('#f_nilai_maksimal');
    let _nilai_maksimal_mengurangi = $('#f_nilai_maksimal_mengurangi');
    let _tipe_penilaian = $('#f_tipe_penilaian');
    let _nilai_bilangan = $('#f_nilai_bilangan');
    let _nilai_bawaaan = $('#f_nilai_bawaaan');
    let _keterangan = $('#f_keterangan');

    _dg.datagrid({
        fit:true,
        singleSelect:true,
        collapsible:true,
        border:false,
        fitColumns:true,
        pagination:false,
        rownumbers:true,
        border:false,
        toolbar:'#tbIndikatorFormula',
    });

    _rumus.combobox({
        valueField:'id',
        textField:'text',
        data: [
            {
                id: 'tambah',
                text: 'Penjumlahan'
            },
            {
                id: 'kurang',
                text: 'Pengurangan',
            },
            {
                id: 'kali',
                text: 'Perkalian',
            },
            {
                id: 'bagi',
                text: 'Pembagian',
            },
            {
                id: 'percent',
                text: 'Persentase',
            },
            {
                id: 'samadengan',
                text: 'Sama Dengan',
            },
        ],
    });

    _tipe_penilaian.combobox({
        valueField:'id',
        textField:'text',
        data: [
            {
                id: 'pembobotan',
                text: 'Hasil Pembobotan'
            },
            {
                id: 'jawaban',
                text: 'Jawaban',
            }
        ],
    });

    _btnAdd.linkbutton({
        onClick: function() {
            let indikator_id = $('#f_indikator_id').combotree('getValue');
            
            if (!indikator_id) {
                Alert('warning', 'Silahkan pilih indikator target terlebih dahulu')                
            } else {
                _w.window('open');
    
                _ff.form('clear');                

                _lke_indikator_id_target.combotree({
                    valueField:'id',
                    textField:'text',
                    method: 'get',
                    url: URL_REST + '/lke-indikator/parent/' + $('#f_lke_id').combobox('getValue'),
                });
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
                    param.nilai_maksimal = _nilai_maksimal.switchbutton('options').checked;
                    param.nilai_maksimal_mengurangi = _nilai_maksimal_mengurangi.switchbutton('options').checked;

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
            let row = _dg.datagrid('getSelected')

            let indikator_id = $('#f_indikator_id').combotree('getValue');
            
            if (!indikator_id) {
                Alert('warning', 'Silahkan pilih indikator target terlebih dahulu')                
            } else {      
                getData(row)
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
    
                        _w.window('open');
    
                        _ff.form('load', data)
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
                        rumus,
                        lke_indikator_id_target,
                        nilai_maksimal,
                        nilai_maksimal_mengurangi,
                        tipe_penilaian,
                        nilai_bilangan,
                        nilai_bawaaan,
                        keterangan
                    } = response

                    _w.window('open');  
                        
                    _lke_indikator_id_target.combotree({
                        valueField:'id',
                        textField:'text',
                        method: 'get',
                        url: URL_REST + '/lke-indikator/parent/' + $('#f_lke_id').combobox('getValue'),
                    });

                    _ff.form('load', {
                        f_id: id,
                        f_urutan: urutan,
                        f_rumus: rumus,
                        f_lke_indikator_id_target: lke_indikator_id_target,
                        f_nilai_maksimal: nilai_maksimal,
                        f_nilai_maksimal_mengurangi: nilai_maksimal_mengurangi,
                        f_tipe_penilaian: tipe_penilaian,
                        f_nilai_bilangan: nilai_bilangan,
                        f_nilai_bawaaan: nilai_bawaaan,
                        f_keterangan: keterangan,
                    });
                }
            });
        } else {
            Alert('warning', 'ID not found')
        }
    }    
});