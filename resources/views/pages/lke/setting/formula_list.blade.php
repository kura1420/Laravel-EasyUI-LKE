<div class="easyui-panel" data-options="fit:true,title:'List',border:false,">
    <div class="easyui-tabs" style="height:100%">

        <div title="Nilai Minimal">
            <table id="dgNilaiMinimal" class="easyui-datagrid">
            </table>
        
            <div id="tbNilaiMinimal" style="padding:2px 5px;">
                <span class="easyui-tooltip" title="Create">
                    <a id="btnAddNilaiMinimal" href="javascript:void(0)" class="easyui-linkbutton" data-options="plain:true,iconCls:'icon-add',">Create</a>
                </span>
                
                <span class="easyui-tooltip" title="Accept">
                    <a id="btnOkNilaiMinimal" href="javascript:void(0)" class="easyui-linkbutton" data-options="plain:true,iconCls:'icon-ok',">Accept</a>
                </span>
                
                <span class="easyui-tooltip" title="Edit">
                    <a id="btnEditNilaiMinimal" href="javascript:void(0)" class="easyui-linkbutton" data-options="plain:true,iconCls:'icon-edit',">Edit</a>
                </span>
                
                <span class="easyui-tooltip" title="Cancel">
                    <a id="btnCancelNilaiMinimal" href="javascript:void(0)" class="easyui-linkbutton" data-options="plain:true,iconCls:'icon-cancel',">Cancel</a>
                </span>
                
                <span class="easyui-tooltip" title="Remove">
                    <a id="btnRemoveNilaiMinimal" href="javascript:void(0)" class="easyui-linkbutton" data-options="plain:true,iconCls:'icon-remove',">Remove</a>
                </span>
            </div>
        </div>

        <div title="Pilihan Jawaban">
            <table id="dgJawaban" class="easyui-datagrid">
                <thead>
                    <tr>
                        <th data-options="field:'urutan'" sortable="true">Urutan</th>
                        <th data-options="field:'jawaban'" sortable="true">Jawaban</th>
                        <th data-options="field:'nilai'" sortable="true">Nilai</th>
                        <th data-options="field:'penjelasan'" sortable="true">Penjelasan</th>
                        <th data-options="
                            field:'aktif',                            
                            formatter:function(value,row){
                                return value == 1 ? 'Ya' : 'Tidak';
                            },
                        " sortable="true">Aktif</th>
                    </tr>
                </thead>
            </table>
            <div id="tbJawaban" style="padding:2px 5px;">
                <span class="easyui-tooltip" title="Create">
                    <a id="btnAddJawaban" href="javascript:void(0)" class="easyui-linkbutton" data-options="plain:false,iconCls:'icon-add'">Create</a>
                </span>
                
                <span class="easyui-tooltip" title="Edit">
                    <a id="btnEditJawaban" href="javascript:void(0)" class="easyui-linkbutton" data-options="plain:false,iconCls:'icon-edit'">Edit</a>
                </span>
                
                <span class="easyui-tooltip" title="Duplicate">
                    <a id="btnCopyJawaban" href="javascript:void(0)" class="easyui-linkbutton" data-options="plain:false,iconCls:'icon-copy'">Copy</a>
                </span>
                
                <span class="easyui-tooltip" title="Remove">
                    <a id="btnRemoveJawaban" href="javascript:void(0)" class="easyui-linkbutton" data-options="plain:false,iconCls:'icon-remove'">Remove</a>
                </span>
            </div>

            <div id="wJawaban" class="easyui-window" title="Form" data-options="modal:true,closed:true,collapsible:false,minimizable:false,maximizable:false,closable:false," style="width:800px;height:450px;padding:5px;">
                <div class="easyui-layout" data-options="fit:true">
                    <div data-options="region:'center'" style="padding:10px;">
                        <form id="ffJawaban" method="post">
                            <p style="display: none;">
                                <input name="j_id" id="j_id" class="easyui-textbox" data-options="label:'ID',width:500,required:false,labelAlign:'right',max:36,readonly:true,">
                            </p>

                            <table width="100%" border="0" cellspacing="10">
                                <tr>
                                    <td style="width: 50%;">
                                        <input name="j_urutan" id="j_urutan" class="easyui-numberbox" data-options="label:'Urutan',required:true,labelAlign:'right'," style="width: 100%;">
                                    </td>
                                    <td>
                                        <input name="j_jawaban" id="j_jawaban" class="easyui-textbox" data-options="label:'Jawaban',required:true,labelAlign:'right'," style="width: 100%;">
                                    </td>
                                </tr>

                                <tr>
                                    <td style="width: 50%;">
                                        <input name="j_nilai" id="j_nilai" class="easyui-numberbox" data-options="label:'Nilai',required:true,labelAlign:'right'," style="width: 100%;">
                                    </td>
                                    <td>
                                        <input name="j_aktif" id="j_aktif" class="easyui-switchbutton" data-options="label:'Aktif',labelAlign:'right',labelWidth:100," value="1">
                                    </td>
                                </tr>

                                <tr>
                                    <td colspan="2">
                                        <input name="j_penjelasan" id="j_penjelasan" class="easyui-textbox" data-options="label:'Penjelasan',width:300,required:false,labelAlign:'right',multiline:true," style="height: 150px;width:100%;padding:10px;">
                                    </td>
                                </tr>
                            </table>
                        </form>
                    </div>
                    <div data-options="region:'south',border:false" style="text-align:right;padding:5px 0 0;">
                        <a id="btnSaveJawaban" class="easyui-linkbutton" data-options="iconCls:'icon-save'" href="javascript:void(0)" style="width:80px">Save</a>
                        <a id="btnCancelJawaban" class="easyui-linkbutton" data-options="iconCls:'icon-cancel'" href="javascript:void(0)" style="width:80px">Cancel</a>
                    </div>
                </div>
            </div>
        </div>
        
        <div title="Indikator">
            <table id="dgIndikatorFormula" class="easyui-datagrid">
                <thead>
                    <tr>
                        <th data-options="field:'urutan'" sortable="true">Urutan</th>
                        <th data-options="
                            field:'rumus',
                            formatter:function(value,row){
                                return rumus(value);
                            },
                        " sortable="true">Rumus</th>
                        <th data-options="field:'indikator'" sortable="true">Indikator</th>
                        <th data-options="field:'tipe_penilaian'" sortable="true">Tipe Penilaian</th>
                        <th data-options="field:'nilai_bilangan'" sortable="true">Nilai Bilangan</th>
                        <th data-options="
                            field:'nilai_maksimal',
                            formatter:function(value,row){
                                return value == 1 ? 'Ya' : 'Tidak';
                            },
                        " sortable="true">Sebagai Nilai Maksimal</th>
                        <th data-options="
                            field:'nilai_maksimal_mengurangi',
                            formatter:function(value,row){
                                return value == 1 ? 'Ya' : 'Tidak';
                            },
                        " sortable="true">Nilai Maksimal Dapat Mengurangi</th>
                        <th data-options="field:'nilai_bawaaan'" sortable="true">Nilai Bawaan</th>
                    </tr>
                </thead>
            </table>
            <div id="tbIndikatorFormula" style="padding:2px 5px;">
                <span class="easyui-tooltip" title="Create">
                    <a id="btnAddIndikatorFormula" href="javascript:void(0)" class="easyui-linkbutton" data-options="plain:false,iconCls:'icon-add'">Create</a>
                </span>
                
                <span class="easyui-tooltip" title="Edit">
                    <a id="btnEditIndikatorFormula" href="javascript:void(0)" class="easyui-linkbutton" data-options="plain:false,iconCls:'icon-edit'">Edit</a>
                </span>
                
                <span class="easyui-tooltip" title="Duplicate">
                    <a id="btnCopyIndikatorFormula" href="javascript:void(0)" class="easyui-linkbutton" data-options="plain:false,iconCls:'icon-copy'">Copy</a>
                </span>
                
                <span class="easyui-tooltip" title="Remove">
                    <a id="btnRemoveIndikatorFormula" href="javascript:void(0)" class="easyui-linkbutton" data-options="plain:false,iconCls:'icon-remove'">Remove</a>
                </span>
            </div>

            <div id="wIndikatorFormula" class="easyui-window" title="Form" data-options="modal:true,closed:true,collapsible:false,minimizable:false,maximizable:false,closable:false," style="width:800px;height:450px;padding:5px;">
                <div class="easyui-layout" data-options="fit:true">
                    <div data-options="region:'center'" style="padding:10px;">
                        <form id="ffIndikatorFormula" method="post">
                            <p style="display: none;">
                                <input name="f_id" id="f_id" class="easyui-textbox" data-options="label:'ID',width:500,required:false,labelAlign:'right',max:36,readonly:true,">
                            </p>

                            <table width="100%" border="0" cellspacing="10">
                                <tr>
                                    <td style="width: 50%;">
                                        <input name="f_urutan" id="f_urutan" class="easyui-numberbox" data-options="label:'Urutan',required:true,labelAlign:'right'," style="width: 100%;">
                                    </td>
                                    <td>
                                        <input name="f_rumus" id="f_rumus" class="easyui-combobox" data-options="label:'Rumus',required:true,labelAlign:'right'," style="width: 100%;">
                                    </td>
                                </tr>

                                <tr>
                                    <td colspan="2">
                                        <input name="f_lke_indikator_id_target" id="f_lke_indikator_id_target" class="easyui-combotree" data-options="label:'Indikator Target',required:false,labelAlign:'right',labelWidth:110," style="width: 100%;">
                                    </td>
                                </tr>

                                <tr>
                                    <td colspan="2">
                                        <input name="f_nilai_maksimal" id="f_nilai_maksimal" class="easyui-switchbutton" data-options="label:'Nilai Maksimal',labelAlign:'right',labelWidth:100," value="1">
                                        
                                        <input name="f_nilai_maksimal_mengurangi" id="f_nilai_maksimal_mengurangi" class="easyui-switchbutton" data-options="label:'Nilai Maksimal Dapat Mengurangi',labelAlign:'right',labelWidth:250," value="1">
                                    </td>
                                </tr>

                                <tr>
                                    <td colspan="2">
                                        <input name="f_tipe_penilaian" id="f_tipe_penilaian" class="easyui-combobox" data-options="label:'Tipe Penilaian',width:300,required:true,labelAlign:'right',labelWidth:100,">

                                        <input name="f_nilai_bilangan" id="f_nilai_bilangan" class="easyui-numberbox" data-options="label:'Nilai Bilangan',required:false,labelAlign:'right',labelWidth:100,">

                                        <input name="f_nilai_bawaaan" id="f_nilai_bawaaan" class="easyui-numberbox" data-options="label:'Nilai Bawaan',required:false,labelAlign:'right',labelWidth:100,">
                                    </td>
                                </tr>

                                <tr>
                                    <td colspan="2">
                                        <input name="f_keterangan" id="f_keterangan" class="easyui-textbox" data-options="label:'Keterangan',width:300,required:false,labelAlign:'right',multiline:true," style="height: 150px;width:100%;padding:10px;">
                                    </td>
                                </tr>
                            </table>
                        </form>
                    </div>
                    <div data-options="region:'south',border:false" style="text-align:right;padding:5px 0 0;">
                        <a id="btnSaveIndikatorFormula" class="easyui-linkbutton" data-options="iconCls:'icon-save'" href="javascript:void(0)" style="width:80px">Save</a>
                        <a id="btnCancelIndikatorFormula" class="easyui-linkbutton" data-options="iconCls:'icon-cancel'" href="javascript:void(0)" style="width:80px">Cancel</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>