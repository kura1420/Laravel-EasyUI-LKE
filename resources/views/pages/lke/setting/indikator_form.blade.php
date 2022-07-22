<div class="easyui-panel" data-options="title:'Form',border:false,">
    <form id="ffIndikator" method="post">
        <p style="display: none;">
            <input name="i_id" id="i_id" class="easyui-textbox" data-options="label:'ID',width:500,required:false,labelAlign:'right',max:36,readonly:true,">
        </p>

        <table width="100%" border="0" cellspacing="10">
            <tr>
                <td colspan="2">
                    <input name="i_lke_id" id="i_lke_id" class="easyui-combobox" data-options="label:'LKE',width:800,required:true,labelAlign:'right',readonly:true,">
                    <input name="i_parent" id="i_parent" class="easyui-combotree" data-options="label:'Parent',width:800,required:false,labelAlign:'right',">
                </td>
            </tr>

            <tr>
                <td colspan="2">
                    <input name="i_urutan" id="i_urutan" class="easyui-numberbox" data-options="label:'Urutan',width:300,required:true,labelAlign:'right',">
                    <input name="i_kode" id="i_kode" class="easyui-textbox" data-options="label:'Kode',required:true,labelAlign:'right',width:300,">

                    <input name="i_urutan_tampilkan" id="i_urutan_tampilkan" class="easyui-switchbutton" data-options="label:'Urutan Ditampilkan',labelAlign:'right',labelWidth:150," value="1">
                    <input name="i_aktif" id="i_aktif" class="easyui-switchbutton" data-options="label:'Aktif',labelAlign:'right'," value="1">
                </td>
            </tr>

            <tr>
                <td colspan="2">
                    <input name="i_alias" id="i_alias" class="easyui-textbox" data-options="label:'Alias',required:true,labelAlign:'right',width:500,">
                    <input name="i_tipe_jawaban" id="i_tipe_jawaban" class="easyui-combobox" data-options="label:'Tipe Jawaban',width:300,required:false,labelAlign:'right',labelWidth:120,">
                    <input name="i_nilai" id="i_nilai" class="easyui-numberbox" data-options="label:'Nilai Bobot',required:false,labelAlign:'right',width:300,">
                </td>
            </tr>

            <tr>
                <td width="50%">
                    <input name="i_indikator" id="i_indikator" class="easyui-textbox" data-options="label:'Indikator',required:true,labelAlign:'right',multiline:true," style="height: 150px;width:100%">
                </td>
                <td>
                    <input name="i_penjelasan" id="i_penjelasan" class="easyui-textbox" data-options="label:'Penjelasan',required:false,labelAlign:'right',multiline:true," style="height: 150px;width:100%">                
                </td>
            </tr>

            <tr>
                <td>
                    <span class="easyui-tooltip" title="Save" style="padding-left: 10%;">
                        <a id="btnSaveIndikator" href="javascript:void(0)" class="easyui-linkbutton" data-options="plain:false,iconCls:'icon-save',">Save</a>
                    </span>
                    <span class="easyui-tooltip" title="Clear" style="padding-left: 5%;">
                        <a id="btnClearIndikator" href="javascript:void(0)" class="easyui-linkbutton c2" data-options="plain:false,iconCls:'icon-clear',">Clear</a>
                    </span>
                </td>
            </tr>
        </table>
    </form>
</div>