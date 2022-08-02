<div class="easyui-panel" data-options="title:'Informasi LKE',border:false,collapsible:true,">
    <form id="ff" method="post">
        <p style="display: none;">
            <input name="id" id="id" class="easyui-textbox" data-options="label:'ID',width:500,required:false,labelAlign:'right',max:36,readonly:true,">
        </p>

        <p>
            <input name="lke_nama" id="lke_nama" class="easyui-textbox" data-options="label:'LKE',width:800,required:false,labelAlign:'right',readonly:true,">
        </p>
        <p>
            <input name="predikat_nama" id="predikat_nama" class="easyui-textbox" data-options="label:'Predikat',width:800,required:false,labelAlign:'right',readonly:true,">
        </p>
        <p>
            <input name="satker_nama" id="satker_nama" class="easyui-textbox" data-options="label:'Satker',width:800,required:false,labelAlign:'right',readonly:true,">
        </p>
    </form>
</div>

<div class="easyui-panel" data-options="fit:true,title:'List Indikator',border:false,">
    <table id="dgIndikator" class="easyui-treegrid" style="height: 100%;">
        <thead>
            <tr>
                <th data-options="field:'kode'," sortable="true">Kode</th>
                <th data-options="field:'indikator'," sortable="true">Indikator</th>
            </tr>
        </thead>
    </table>
    <div id="tbIndikator" style="padding:2px 5px;">
        <input id="ssIndikator" class="easyui-searchbox" data-options="width:800,">

        <span class="easyui-tooltip" title="Edit">
            <a id="btnEditIndikator" href="javascript:void(0)" class="easyui-linkbutton" data-options="plain:false,iconCls:'icon-edit'">Penilaian</a>
        </span>

        <!-- <span class="easyui-tooltip" title="Save">
            <a id="btnSave" href="javascript:void(0)" class="easyui-linkbutton" data-options="plain:false,iconCls:'icon-save',disabled:true">Simpan</a>
        </span> -->
    </div>
</div>

<div id="wIndikator" title="Penilaian Indikator" class="easyui-window" data-options="modal:true,closed:true,collapsible:false,minimizable:false,maximizable:false,closable:false," style="width:80%;height:80%;padding:10px;">
    <div class="easyui-layout" data-options="fit:true">
        <div data-options="region:'east'" style="width: 20%;">
            east
        </div>
        <div data-options="region:'center'">
            <form id="formIndikator" method="post">
                <p style="display: none;">
                    <input name="i_id" id="i_id" class="easyui-textbox" data-options="label:'ID',required:false,labelAlign:'right',max:36,readonly:true,">
                </p>
                
                <p>
                    <input name="i_kode" id="i_kode" class="easyui-textbox" data-options="label:'Kode',required:false,labelAlign:'right',readonly:true," style="width: 40%;">
                    <input name="i_alias" id="i_alias" class="easyui-textbox" data-options="label:'Alias',required:false,labelAlign:'right',readonly:true," style="width: 55%;">
                </p>
                <p>
                    <input name="i_indikator" id="i_indikator" class="easyui-textbox" data-options="label:'Indikator',required:false,labelAlign:'right',readonly:true," style="width: 95%;">
                </p>
                <p>
                    <input name="i_penjelasan" id="i_penjelasan" class="easyui-textbox" data-options="label:'Penjelasan',required:false,labelAlign:'right',readonly:true,multiline:true," style="width: 95%;height:80px;">
                </p>

                <hr>
                        
                <p>
                    <input name="i_penjelasan_jawaban" id="i_penjelasan_jawaban" class="easyui-textbox" data-options="label:'Penjelasan Jawaban',required:false,labelAlign:'right',multiline:true,labelWidth:150,readonly:true," style="width: 95%;height:100px;">
                </p>
                <p id="section_jawaban">
                    
                </p>        
                <p>
                    <input name="i_catatan" id="i_catatan" class="easyui-textbox" data-options="label:'Catatan',required:false,labelAlign:'right',multiline:true," style="width: 95%;height:100px;">
                </p>         
                <p>
                    <input name="i_bukti" id="i_bukti" class="easyui-textbox" data-options="label:'Bukti',required:false,labelAlign:'right',multiline:true," style="width: 95%;height:100px;">
                </p>      
            </form>
        </div>
        <div data-options="region:'south',border:false" style="text-align:right;padding:5px 0 0;">
            <a id="btnCancelIndikator" href="javascript:void(0)" class="easyui-linkbutton" data-options="plain:false,iconCls:'icon-cancel'" style="margin-right: 1%;">Tutup</a>
            <a id="btnSaveIndikator" href="javascript:void(0)" class="easyui-linkbutton" data-options="plain:false,iconCls:'icon-save'">Simpan</a>
        </div>
    </div>
</div>