"use strict"
$(document).ready(function () {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
        }
    });

    const _rest_indikator = URL_REST + '/lke-indikator'
    const _rest_formula = URL_REST + '/lke-formula'

    let _w_sett_lke = $('#w_sett_lke');
    let _c_lke_id = $('#c_lke_id');
    let _btnChooseLKE = $('#btnChooseLKE');

    _c_lke_id.combobox({
        valueField:'id',
        textField:'nama',
        url: URL_REST + '/lke/lists'
    });

    _btnChooseLKE.linkbutton({
        onClick: function () {
            let value = _c_lke_id.combobox('getValue')

            $('#i_lke_id').combobox('setValue', value)
            $('#f_lke_id').combobox('setValue', value)

            _w_sett_lke.window('close')

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
        }
    });
});