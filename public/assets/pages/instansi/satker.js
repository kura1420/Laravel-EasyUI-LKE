"use strict"
$(document).ready(function () {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
        }
    });

    const _rest = URL_REST + '/satker'

    let _tbs = $('#tbs');
    let _dg = $('#dg');
    let _ff = $('#ff');
    let _ss = $('#ss');
    
    let _btnAdd = $('#btnAdd');
    let _btnSave = $('#btnSave');
    let _btnEdit = $('#btnEdit');
    let _btnCopy = $('#btnCopy');
    let _btnRemove = $('#btnRemove');
    
    let _id = $('#id');
    let _kode = $('#kode');
    let _nama = $('#nama');
    // let _provinsi = $('#provinsi');
    // let _kota = $('#kota');
    let _alamat = $('#alamat');
    let _email = $('#email');
    let _telp = $('#telp');

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
            if (!value) return loadData()

            $.ajax({
                method: 'get',
                url: _rest,
                data: {
                    search: value,
                },
                dataType: 'json',
                success: function (res) {
                    let {data} = res

                    _dg.datagrid('loadData', data)
                },
                error: function (xhr, status, error) {
                    let {statusText, responseJSON} = xhr

                    Alert('error', responseJSON, statusText)
                }
            })
        },
    });

    _tbs.tabs({
        onSelect: function (title, index) {
            if (index == 0) {
                formReset()
            }
        }
    });

    _btnAdd.linkbutton({
        onClick: function() {
            _tbs.tabs({
                selected: 1
            })
        
            formEdit()

            _kode.textbox('readonly', false)

            // _provinsi.combobox({
            //     valueField:'id',
            //     textField:'text',
            //     url: _rest + '/provinsi',
            //     onLoadSuccess: function () {
            //         _brand.combo('clear')
            //     }
            // })

            // _kota.combobox({
            //     valueField:'id',
            //     textField:'text',
            //     url: _rest + '/kota',
            //     onLoadSuccess: function () {
            //         _brand.combo('clear')
            //     }
            // });
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
                    // param.provinsi = _provinsi.combo('getText')
                    // param.kota = _kota.combo('getText')

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
    
    _btnCopy.linkbutton({
        onClick: function () {  
            let row = _dg.datagrid('getSelected')
        
            if (row) {
                $.get(_rest + "/" + row.id,
                    function (data, textStatus, jqXHR) {
                        delete data.id
    
                        formEdit()
    
                        _ff.form('load', data)
    
                        _tbs.tabs({
                            selected: 1
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
            let row = _dg.datagrid('getSelected')
    
            if (row) {
                $.messager.confirm('Confirmation', 'Are you sure delete this data?', function(r){
                    if (r){
                        $.ajax({
                            type: "delete",
                            url: _rest + '/' + row.id,
                            dataType: "json",
                            success: function (response) {
                                loadData()
    
                                _tbs.tabs({
                                    selected: 0
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

    var loadData = () => {
        _dg.datagrid({
            method: 'get',
            url: _rest,
            onDblClickRow: function (index, row) {
                getData(row)
            },
            loader: function (param, success, error) {
                let {method, url, pageNumber, pageSize, sortOrder, sortName} = $(this).datagrid('options')
                
                if (method==null || url==null) return false

                $.ajax({
                    method: method,
                    url: url,
                    data: {
                        page: pageNumber,
                        rows: pageSize,
                        sortOrder: sortOrder,
                        sortName: sortName,
                    },
                    dataType: 'json',
                    success: function (res) {
                        let {total, data} = res

                        success({
                            total: total,
                            rows: data
                        })
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
        _ff.form('clear')

        _btnSave.linkbutton({disabled:true})
        _btnEdit.linkbutton({disabled:false})
        _btnCopy.linkbutton({disabled:false})

        _kode.textbox({disabled:true})
            .textbox('readonly', true)
        _nama.textbox({disabled:true})
        // _provinsi.combobox({disabled:true})
        // _kota.combobox({disabled:true})
        _alamat.textbox({disabled:true})
        _email.textbox({disabled:true})
        _telp.numberbox({disabled:true})
    }

    var formEdit = () => {
        _btnSave.linkbutton({disabled:false})
        _btnEdit.linkbutton({disabled:true})
        _btnCopy.linkbutton({disabled:true})
    
        _kode.textbox({disabled:false})
            .textbox('readonly')
        _nama.textbox({disabled:false})
        // _provinsi.combobox({disabled:false})
        // _kota.combobox({disabled:false})
        _alamat.textbox({disabled:false})
        _email.textbox({disabled:false})
        _telp.numberbox({disabled:false})
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
                        kode,
                        nama,
                        // provinsi,
                        // kota,
                        alamat,
                        email,
                        telp,
                    } = response

                    _tbs.tabs({
                        selected: 1
                    })
            
                    formEdit()

                    // _kota.combobox({
                    //     valueField:'id',
                    //     textField:'text',
                    //     url: _rest + '/kota',
                    //     onLoadSuccess: function () {
                    //         _kota.combo('setText', kota)
                    //     }
                    // })
                
                    // _provinsi.combobox({
                    //     valueField:'id',
                    //     textField:'text',
                    //     url: _rest + '/provinsi',
                    //     onLoadSuccess: function () {
                    //         _provinsi.combo('setText', provinsi)
                    //     }
                    // })

                    _kode.textbox('readonly')

                    _ff.form('load', {
                        id: id,
                        kode: kode,
                        nama: nama,
                        // provinsi: provinsi,
                        // kota: kota,
                        alamat: alamat,
                        email: email,
                        telp: telp,
                    })
                }
            });
        } else {
            Alert('warning', 'ID not found')
        }
    }

    loadData()
});