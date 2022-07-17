<form id="ff" method="post">
    <p style="display: none;">
        <input name="id" id="id" class="easyui-textbox" data-options="label:'ID',width:500,required:false,labelAlign:'right',max:36,readonly:true,">
    </p>

    <p>
        <input name="nama" id="nama" class="easyui-textbox" data-options="label:'Nama',width:800,required:true,labelAlign:'right',disabled:true,">
    </p>
    <p>
        <input name="tahun" id="tahun" class="easyui-numberbox" data-options="label:'Tahun',width:800,required:true,labelAlign:'right',disabled:true,">
    </p>
    <p>
        <input name="keterangan" id="keterangan" class="easyui-textbox" data-options="label:'Keterangan',width:800,required:false,labelAlign:'right',disabled:true,multiline:true," style="height: 180px;">
    </p>
    <p>
        <input name="aktif" id="aktif" class="easyui-switchbutton" data-options="label:'Aktif',labelAlign:'right',disabled:true" value="1">
    </p>
</form>

<div class="easyui-tabs" data-options="fit:true" style="padding-top: 5%;">

    <div title="Predikat">
        <table id="dgPredikat" class="easyui-datagrid" style="height: 56%;">
            <thead>
                <tr>
                    <th data-options="field:'predikat_nama'" sortable="true">Predikat</th>
                    <th data-options="field:'predikat_usulan'" sortable="true">Usulan</th>
                    <th data-options="field:'nilai_minimal'" sortable="true">Nilai Minimal</th>
                </tr>
            </thead>
        </table>

        <div id="tbPredikat" style="padding:2px 5px;">
            <span class="easyui-tooltip" title="Create">
                <a id="btnAddPredikat" href="javascript:void(0)" class="easyui-linkbutton" data-options="disabled:true,plain:true,iconCls:'icon-add',">Create</a>
            </span>
            
            <span class="easyui-tooltip" title="Edit">
                <a id="btnEditPredikat" href="javascript:void(0)" class="easyui-linkbutton" data-options="disabled:true,plain:true,iconCls:'icon-edit',">Edit</a>
            </span>
            
            <span class="easyui-tooltip" title="Remove">
                <a id="btnRemovePredikat" href="javascript:void(0)" class="easyui-linkbutton" data-options="disabled:true,plain:true,iconCls:'icon-remove',">Remove</a>
            </span>
        </div>

        <div id="wPredikat" class="easyui-window" title="Form Predikat" data-options="modal:true,closed:true," style="width:800px;height:400px;padding:10px;">
            <div class="easyui-layout" data-options="fit:true,border:false,">
                <form id="ffPredikat" method="post">
                    <div data-options="region:'center'" style="padding:10px;">
                        <p>
                            <input name="p_predikat" id="p_predikat" class="easyui-combogrid" data-options="label:'Predikat',width:600,required:true,labelAlign:'right',labelWidth:120,">
                        </p>
                        <p>
                            <input name="p_nilai_minimal" id="p_nilai_minimal" class="easyui-numberbox" data-options="label:'Nilai Minimum',width:600,required:true,labelAlign:'right',labelWidth:120,">
                        </p>
                    </div>
                    <div data-options="region:'south',border:false" style="text-align:right;padding:5px 0 0;">
                        <a id="btnOkPredikat" class="easyui-linkbutton" data-options="iconCls:'icon-ok'" href="javascript:void(0)">Ok</a>
                        <a id="btnCancelPredikat" class="easyui-linkbutton" data-options="iconCls:'icon-cancel'" href="javascript:void(0)">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>

</div>