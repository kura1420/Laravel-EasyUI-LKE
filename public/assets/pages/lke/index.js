"use strict"
$(document).ready(function () {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
        }
    });

    const _rest = URL_REST + '/lke'

    var rowIndexPredikat = undefined

    let _tbs = $('#tbs');
    let _dg = $('#dg');
    let _ff = $('#ff');
    let _ss = $('#ss');

    let _dgPredikat = $('#dgPredikat');
    let _ffPredikat = $('#ffPredikat');
    let _wPredikat = $('#wPredikat');
    
    let _btnAdd = $('#btnAdd');
    let _btnSave = $('#btnSave');
    let _btnEdit = $('#btnEdit');
    let _btnCopy = $('#btnCopy');
    let _btnRemove = $('#btnRemove');

    let _btnAddPredikat = $('#btnAddPredikat');
    let _btnEditPredikat = $('#btnEditPredikat');
    let _btnRemovePredikat = $('#btnRemovePredikat');
    let _btnOkPredikat = $('#btnOkPredikat');
    let _btnCancelPredikat = $('#btnCancelPredikat');
    
    let _id = $('#id');
    let _nama = $('#nama');
    let _aktif = $('#aktif');
    let _keterangan = $('#keterangan');
    let _tahun = $('#tahun');

    let _p_predikat = $('#p_predikat');
    let _p_nilai_minimal = $('#p_nilai_minimal');

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

    _dgPredikat.datagrid({
        singleSelect:true,
        collapsible:true,
        border:false,
        fitColumns:true,
        pagination:true,
        rownumbers:true,
        toolbar:'#tbPredikat',
        onDblClickRow: function () {
            rowIndexPredikat = undefined

            let row = _dgPredikat.datagrid('getSelected');
            rowIndexPredikat = _dgPredikat.datagrid('getRowIndex', row);

            _wPredikat.window('open');

            _p_predikat.combogrid({
                panelWidth:800,
                fitColumns:true,
                idField:'id',
                textField:'text',
                method:'post',
                url: URL_REST + '/predikat/lists',
                columns:[[
                    {field:'nama',title:'Nama'},
                    {field:'usulan',title:'Usulan'},
                    {field:'keterangan',title:'Keterangan'},
                ]],
            });

            _ffPredikat.form('load', {
                p_predikat: row.predikat_id,
                p_nilai_minimal: row.nilai_minimal
            });
        }
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

            _dgPredikat.datagrid('loadData', [])
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
                    param.aktif = _aktif.switchbutton('options').checked

                    param.predikats = JSON.stringify(_dgPredikat.datagrid('getRows'))

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
                        let parse = JSON.parse(res)
                        
                        loadData()
                        loadDataPredikat(parse.id)
    
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

    _btnAddPredikat.linkbutton({
        onClick: function () {
            _wPredikat.window('open');

            _p_predikat.combogrid({
                panelWidth:600,
                fitColumns:true,
                idField:'id',
                textField:'text',
                method:'post',
                url: URL_REST + '/predikat/lists',
                columns:[[
                    {field:'nama',title:'Nama'},
                    {field:'usulan',title:'Usulan'},
                    {field:'keterangan',title:'Keterangan'},
                ]],
            });
        }
    });

    _btnEditPredikat.linkbutton({
        onClick: function () {  
            let row = _dgPredikat.datagrid('getSelected')

            if (row) {
                rowIndexPredikat = _dgPredikat.datagrid('getRowIndex', row)

                _wPredikat.window('open')

                _ffPredikat.form('load', {
                    p_predikat: row.predikat_id,
                    p_nilai_minimal: row.nilai_minimal,
                })
            } else {
                Alert('warning', 'No Data selected');                
            }
        }
    });

    _btnOkPredikat.linkbutton({
        onClick: function () {
            if (_ffPredikat.form('validate')) {
                let g = _p_predikat.combogrid('grid');
                let r = g.datagrid('getSelected');

                if (rowIndexPredikat !== undefined) {
                    _dgPredikat.datagrid('updateRow', {
                        index: rowIndexPredikat,
                        row: {
                            predikat_id: r.id,
                            predikat_nama: r.nama,
                            predikat_usulan: r.usulan,
                            nilai_minimal: _p_nilai_minimal.numberbox('getValue'),
                        }
                    });
                } else {
                    _dgPredikat.datagrid('appendRow', {
                        id: null,
                        
                        predikat_id: r.id,
                        predikat_nama: r.nama,
                        predikat_usulan: r.usulan,
                        nilai_minimal: _p_nilai_minimal.numberbox('getValue'),
                    })
                }

                rowIndexPredikat = undefined

                _dgPredikat.datagrid('fixColumnSize');
                _dgPredikat.datagrid('fixRowHeight');

                _wPredikat.window('close');
                _ffPredikat.form('clear');
            }
        }
    });

    _btnCancelPredikat.linkbutton({
        onClick: function () {
            _wPredikat.window('close');

            _ffPredikat.form('clear');

            rowIndexPredikat = undefined;
        }
    });

    _btnRemovePredikat.linkbutton({
        onClick: function () {
            let row = _dgPredikat.datagrid('getSelected');

            if (row) {
                rowIndexPredikat = _dgPredikat.datagrid('getRowIndex', rowIndexPredikat);

                $.messager.confirm('Confirmation', 'Are you sure delete this data?', function(r){
                    if (r){
                        if (row.id) {
                            $.ajax({
                                type: "delete",
                                url: _rest + '/predikat/' + row.id,
                                dataType: "json",
                                success: function (response) {
                                    loadDataPredikat(_id.textbox('getValue'))

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
                            _dgPredikat.datagrid('cancelEdit', rowIndexPredikat)
                                .datagrid('deleteRow', rowIndexPredikat);

                            $.messager.show({
                                title:'Info',
                                msg:'Data deleted.',
                                timeout:5000,
                                showType:'slide'
                            });
                        }
                    }

                    rowIndexPredikat = undefined;
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

    var loadDataPredikat = (fk) => {
        _dgPredikat.datagrid({
            method: 'get',
            url: _rest + '/predikat/' + fk,
            loader: function (param, success, error) {
                let {method, url} = $(this).datagrid('options')

                if (method==null || url==null) return false

                $.ajax({
                    method: method,
                    url: url,
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

        _dgPredikat.datagrid('fixColumnSize');
        _dgPredikat.datagrid('fixRowHeight');
    }

    var formReset = () => {
        _ff.form('clear')

        _dgPredikat.datagrid('loadData', [])

        _btnSave.linkbutton({disabled:true})
        _btnEdit.linkbutton({disabled:false})
        _btnCopy.linkbutton({disabled:false})

        _btnAddPredikat.linkbutton({disabled:true})
        _btnEditPredikat.linkbutton({disabled:true})
        _btnRemovePredikat.linkbutton({disabled:true})

        _nama.textbox({disabled:true})
        _aktif.switchbutton({disabled:true})
        _keterangan.textbox({disabled:true})
        _tahun.numberbox({disabled:true})
    }

    var formEdit = () => {
        _btnSave.linkbutton({disabled:false})
        _btnEdit.linkbutton({disabled:true})
        _btnCopy.linkbutton({disabled:true})

        _btnAddPredikat.linkbutton({disabled:false})
        _btnEditPredikat.linkbutton({disabled:false})
        _btnRemovePredikat.linkbutton({disabled:false})

        _nama.textbox({disabled:false})
        _aktif.switchbutton({disabled:false})
        _keterangan.textbox({disabled:false})
        _tahun.numberbox({disabled:false})
    }

    var getData = (row) => {
        if (row) {  
            _ff.form('load', _rest + '/' + row.id)
    
            _tbs.tabs({
                selected: 1
            })
    
            formEdit()

            loadDataPredikat(row.id)
        } else {
            Alert('warning', 'ID not found')
        }
    }

    loadData()
});