<div class="easyui-panel" data-options="fit:true,title:'List',border:false,">
    <table id="dgIndikator" class="easyui-treegrid" style="height: 100%;">
        <thead>
            <tr>
                <th data-options="field:'urutan'," sortable="true">Urutan</th>
                <th data-options="field:'kode'," sortable="true">Kode</th>
                <th data-options="field:'indikator'," sortable="true">Indikator</th>
                <th data-options="field:'nilai',align:'center'," sortable="true">Nilai Bobot</th>
                <!-- <th data-options="
                    field:'aktif',
                    formatter: function(value, row, index) {
                        return value == 1 ? 'Ya' : 'Tidak'
                    },
                " sortable="true">Aktif</th> -->
            </tr>
        </thead>
    </table>
    <div id="tbIndikator" style="padding:2px 5px;">
        <input id="ssIndikator" class="easyui-searchbox" data-options="width:800,">

        <span class="easyui-tooltip" title="Edit">
            <a id="btnEditIndikator" href="javascript:void(0)" class="easyui-linkbutton" data-options="plain:false,iconCls:'icon-edit'">Edit</a>
        </span>
        
        <span class="easyui-tooltip" title="Duplicate">
            <a id="btnCopyIndikator" href="javascript:void(0)" class="easyui-linkbutton" data-options="plain:false,iconCls:'icon-copy'">Copy</a>
        </span>
        
        <span class="easyui-tooltip" title="Remove">
            <a id="btnRemoveIndikator" href="javascript:void(0)" class="easyui-linkbutton" data-options="plain:false,iconCls:'icon-remove'">Remove</a>
        </span>
    </div>
</div>