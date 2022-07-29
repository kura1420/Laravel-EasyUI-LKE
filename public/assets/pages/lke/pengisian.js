"use strict"
$(document).ready(function () {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
        }
    });

    const _rest = URL_REST + '/lke-jawaban'

    let _tbs = $('#tbs');
    let _dg = $('#dg');
    let _ff = $('#ff');
    let _ss_lke_id = $('#ss_lke_id');
    let _ss = $('#ss');
    
    let _btnSave = $('#btnSave');
    let _btnEdit = $('#btnEdit');
    
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
                        loadData()
    
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
    
            getData(row)
        }
    });

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

    var formReset = () => {
        // _ff.form('clear')

        // _btnSave.linkbutton({disabled:true})
        // _btnEdit.linkbutton({disabled:false})
        // _btnCopy.linkbutton({disabled:false})

        // _aktif.switchbutton({disabled:true})
        // _satker_id.combobox({disabled:true})
        // _lke_id.combobox({disabled:true})
        // _predikat_id.combobox({disabled:true})
    }

    var formEdit = () => {
        // _btnSave.linkbutton({disabled:false})
        // _btnEdit.linkbutton({disabled:true})
        // _btnCopy.linkbutton({disabled:true})

        // _aktif.switchbutton({disabled:false})
        // _satker_id.combobox({disabled:false})
        // _lke_id.combobox({disabled:false})
        // _predikat_id.combobox({disabled:false})
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
                }
            });
        } else {
            Alert('warning', 'ID not found')
        }
    }

    // loadData()
});