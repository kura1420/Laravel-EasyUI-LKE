"use strict"
$(document).ready(function () {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
        }
    });

    const _rest = URL_REST + '/lke-jawaban';

    var _penjelasanJawaban = [];

    let _tbs = $('#tbs');
    let _dg = $('#dg');
    let _ff = $('#ff');
    let _ss_lke_id = $('#ss_lke_id');
    let _ss = $('#ss');

    let _dgIndikator = $('#dgIndikator');
    let _ssIndikator = $('#ssIndikator');
    let _btnEditIndikator = $('#btnEditIndikator');
    let _wIndikator = $('#wIndikator');
    let _formIndikator = $('#formIndikator');
    let _btnCancelIndikator = $('#btnCancelIndikator');
    let _btnSaveIndikator = $('#btnSaveIndikator');
    
    let _id = $('#id');

    _ss_lke_id.combobox({
        prompt: 'Pilih LKE',
        valueField:'id',
        textField:'nama',
        width: 500,
        url: URL_REST + '/lke/lists',
        onChange: function (newValue, oldValue) {
            if (newValue) {
                loadData(newValue);
            } else {
                Alert('warning', 'Silahkan pilih LKE terlebih dahulu')
            }
        }
    });

    _dg.datagrid({
        singleSelect:true,
        collapsible:true,
        border:false,
        fitColumns:true,
        pagination:true,
        rownumbers:true,
        remoteSort:true,
        toolbar:'#tb',
    });

    _ss.searchbox({
        prompt: 'Search',
        searcher: function (value, name) {
            let ssLkeIDValue = _ss_lke_id.combobox('getValue');
            let ssValue = value;
            
            if (ssLkeIDValue !== '' && ssValue == '') {
                loadData(ssLkeIDValue);
            } else if (ssLkeIDValue !== '' && ssValue !== '') {
                loadData(ssLkeIDValue, ssValue);
            } else {
                Alert('warning', 'Silahkan pilih LKE terlebih dahulu');
            }
        },
    });

    _tbs.tabs({
        onSelect: function (title, index) {
            if (index == 0) {
                formReset()
            }
        }
    });

    _dgIndikator.treegrid({
        singleSelect:true,
        collapsible:true,
        border:false,
        fitColumns:true,
        pagination:false,
        rownumbers:true,
        idField:'id',
        treeField:'kode',
        lines:true,
        toolbar:'#tbIndikator',
        onDblClickRow: function (row) {
            getDataIndikator(row)
        },
    });

    _ssIndikator.searchbox({
        prompt: 'Search',
        searcher: function (value, name) {
            let lke_pengusulan_id = _id.textbox('getValue')

            if (lke_pengusulan_id) {
                // if (!value) return loadDataIndikator()

                // $.ajax({
                //     method: 'get',
                //     url: _rest,
                //     data: {
                //         lke_pengusulan_id: lke_pengusulan_id,
                //         search: value,
                //     },
                //     dataType: 'json',
                //     success: function (res) {
                //         _dgIndikator.treegrid('loadData', res)
                //     },
                //     error: function (xhr, status, error) {
                //         let {statusText, responseJSON} = xhr

                //         Alert('error', responseJSON, statusText)
                //     }
                // });
            } else {
                Alert('warning', 'Silahkan pilih LKE terlebih dahulu')                
            }
        },
    });

    _btnEditIndikator.linkbutton({
        onClick: function () {
            let row = _dgIndikator.treegrid('getSelected')
    
            getDataIndikator(row)
        }
    });

    _btnCancelIndikator.linkbutton({
        onClick: function () {
            _wIndikator.window('close');

            _formIndikator.form('clear');

            $('#section_jawaban').html('');
        }
    });

    // _btnSave.linkbutton({
    //     onClick: function() {
    //         $.messager.progress();
    
    //         _ff.form('submit', {
    //             url: _rest,
    //             onSubmit: function(param) {
    //                 var isValid = $(this).form('validate');
    //                 if (!isValid){
    //                     $.messager.progress('close');
    //                 }
    
    //                 param.id = _id.textbox('getValue')

    //                 param._token = $('meta[name="csrf-token"]').attr('content')
    
    //                 return isValid;
    //             },
    //             success: function(res) {
    //                 $.messager.progress('close');
    
    //                 let {status, data} = JSON.parse(res)
    
    //                 if (status == 'NOT') {
    //                     let msg = []
    //                     for (var d in data) {
    //                         msg.push(data[d].toString())
    //                     }
    
    //                     Alert('warning', msg.join('<br />'))
    //                 } else {
    //                     loadData()
    
    //                     $.messager.show({
    //                         title:'Info',
    //                         msg:'Data saved.',
    //                         timeout:5000,
    //                         showType:'slide'
    //                     })
    //                 }
    //             },
    //         })
    //     }
    // });
    
    // _btnEdit.linkbutton({
    //     onClick: function() {
    //         let row = _dg.datagrid('getSelected')
    
    //         getData(row)
    //     }
    // });

    var loadData = (lke_id, search = null) => {
        _dg.datagrid({
            method: 'get',
            url: URL_REST + '/lke-pengusulan/list-pengisian/' + lke_id,
            onDblClickRow: function (index, row) {
                getData(row)
            },
            queryParams: {
                search: search
            },
            loader: function (param, success, error) {
                let {method, url, pageNumber, pageSize, sortOrder, sortName} = $(this).datagrid('options')
                
                if (method==null || url==null) return false

                $.ajax({
                    method: method,
                    url: url,
                    data: param,
                    dataType: 'json',
                    success: function (res) {
                        success(res);
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

    var loadDataIndikator = (objs) => {
        _dgIndikator.treegrid('loadData', objs);
        _dgIndikator.treegrid('fixColumnSize');
        _dgIndikator.treegrid('fixRowHeight');
    }

    var formReset = () => {
        _ff.form('clear');

        _dgIndikator.treegrid('loadData', []);
    }

    var formEdit = () => {
        
    }

    var getData = (row) => {
        if (row) {    
            $.ajax({
                type: "get",
                url: _rest + '?lke_pengusulan_id=' + row.id,
                dataType: "json",
                success: function (response) {
                    let {
                        satker, 
                        lke_pengisian,
                    } = response

                    _tbs.tabs({
                        selected: 1
                    });

                    _ff.form('load', satker);

                    loadDataIndikator(lke_pengisian);
                }
            });
        } else {
            Alert('warning', 'ID not found')
        }
    }

    var getDataIndikator = (row) => {
        if (row) {   
            $('#section_jawaban').append('<input type="text" name="i_jawaban" id="i_jawaban">');

            switch (row.tipe_jawaban) {
                case 'angka':
                    $.ajax({
                        type: "GET",
                        url: URL_REST + "/lke-indikator-jawaban?lke_indikator_id=" + row.id,
                        dataType: "json",
                        success: function (response) {
                            console.log(response);

                            $('#i_jawaban').numberbox({label:'Jawaban',required:true,labelAlign:'right',width:700,});
                        }
                    });
                    break;

                case 'pilihan':
                    $.ajax({
                        type: "GET",
                        url: URL_REST + "/lke-indikator-jawaban?lke_indikator_id=" + row.id,
                        dataType: "json",
                        success: function (response) {
                            $.each(response, function (key, val) {
                                _penjelasanJawaban.push(`${val.jawaban}, ${val.penjelasan ?? 'tidak ada penjelasan'}.`);
                            });

                            $('#i_penjelasan_jawaban').textbox('setValue', _penjelasanJawaban.join("\n"));

                            var jawabanOpt = {
                                label:'Jawaban',
                                required:true,
                                labelAlign:'right',
                                width:700,
                                valueField:'id',
                                textField:'jawaban',
                                data: response,
                            };

                            $('#i_jawaban').combobox(jawabanOpt);
                        }
                    });
                    break;
            
                default:
                    $('#i_jawaban').textbox({label:'Jawaban',required:true,labelAlign:'right',width:700,});
                    break;
            }

            _wIndikator.window('open');
            
            _formIndikator.form('load', {
                i_id: row.id,
                i_kode: row.kode,
                i_alias: row.alias,
                i_indikator: row.indikator,
                i_penjelasan: row.penjelasan,
            });
        } else {
            Alert('warning', 'ID not found')
        }
    }
});