<table id="dg" class="easyui-datagrid" style="height: 100%;">
    <thead>
        <tr>
            <th data-options="field:'nama'" sortable="true">Nama</th>
            <th data-options="field:'tahun'" sortable="true">Tahun</th>
            <th data-options="
                field:'aktif',
                align:'center',
                formatter: function(value, row, index) {
                    return value == 1 ? 'Ya' : 'Tidak'
                },
                styler: function(value,row,index) {
                    return value !== 1 ? 'background-color:red;color:white;' : ''
                },
            "
            sortable="true">Aktif</th>
        </tr>
    </thead>
</table>
<div id="tb" style="padding:2px 5px;">
    <input id="ss" class="easyui-searchbox" style="width:30%">
</div>