<table id="dg" class="easyui-datagrid" style="height: 100%;">
    <thead>
        <tr>
            <th data-options="field:'satker_nama'" sortable="true">Satker</th>
            <th data-options="field:'predikat_nama'" sortable="true">Predikat</th>
            <th data-options="
                field:'aktif',
                formatter: function(value, row, index) {
                    return value == 1 ? 'Ya' : 'Tidak'
                },
            " sortable="true">Aktif</th>
        </tr>
    </thead>
</table>
<div id="tb" style="padding:2px 5px;">
    <input id="ss" class="easyui-searchbox" style="width:30%">
</div>