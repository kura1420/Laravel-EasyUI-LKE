"use strict"
$(document).ready(function () {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
        }
    });

    const _rest_indikator = URL_REST + '/lke-indikator'

    let _w = $('#w_sett_lke');
    let _dg = $('#dgLke');
    let _btnChooseLKE = $('#btnChooseLKE');

    _dg.datagrid({
        singleSelect:true,
        collapsible:true,
        border:false,
        fitColumns:true,
        pagination:true,
        rownumbers:true,
        remoteSort:false,
        fit:true,
        url: URL_REST + '/lke/lists-total-indikator',
    });

    _btnChooseLKE.linkbutton({
        onClick: function () {
            let row = _dg.datagrid('getSelected')

            if (row) {
                let value = row.id

                $('#i_lke_id').combobox('setValue', value)
                $('#f_lke_id').combobox('setValue', value)

                _w.window('close')

                $('#i_parent').combotree({
                    valueField:'id',
                    textField:'text',
                    method: 'get',
                    url: _rest_indikator + '/parent/' + value,
                });

                $('#f_indikator_id').combotree({
                    valueField:'id',
                    textField:'text',
                    method: 'get',
                    url: _rest_indikator + '/parent/' + value,
                });

                $('#dgIndikator').treegrid({
                    method: 'get',
                    url: _rest_indikator,
                    queryParams: {
                        lke_id: value
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
        
                $('#dgIndikator').treegrid('fixColumnSize');
                $('#dgIndikator').treegrid('fixRowHeight');
            } else {
                Alert('warning', 'Silahkan Pilih LKE')
            }
        }
    });

    $('#f_indikator_id').combotree({
        onChange: function (newValue, oldValue) {
            if (newValue) {
                let params = {
                    lke_indikator_id: newValue,
                };

                loadDataNilaiMinimal(params)

                loadDataIndikatorFormula(params);

                loadDataJawaban(params);
            } else {
                Alert('warning', 'Silahkan Pilih indikator')                
            }
        }
    });

    var loadDataNilaiMinimal = (params) => {
        $('#dgNilaiMinimal').datagrid({
            method: 'get',
            url: URL_REST + '/lke-indikator-nilai',
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

        $('#dgNilaiMinimal').datagrid('fixColumnSize');
        $('#dgNilaiMinimal').datagrid('fixRowHeight');
    }

    var loadDataIndikatorFormula = (params) => {
        $('#dgIndikatorFormula').datagrid({
            method: 'get',
            url: URL_REST + '/lke-indikator-formula',
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

        $('#dgIndikatorFormula').datagrid('fixColumnSize');
        $('#dgIndikatorFormula').datagrid('fixRowHeight');
    }

    var loadDataJawaban = (params) => {
        $('#dgJawaban').datagrid({
            method: 'get',
            url: URL_REST + '/lke-indikator-jawaban',
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

        $('#dgJawaban').datagrid('fixColumnSize');
        $('#dgJawaban').datagrid('fixRowHeight');
    }
});