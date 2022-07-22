<div class="easyui-panel" data-options="title:'Form',border:false,">
    <form id="ffFormula" method="post">
        <p style="display: none;">
            <input name="f_id" id="f_id" class="easyui-textbox" data-options="label:'ID',width:500,required:false,labelAlign:'right',max:36,readonly:true,">
        </p>

        <table width="100%" border="0" cellspacing="10">
            <tr>
                <td colspan="2" style="border-bottom: 2px solid black;padding-bottom:15px;">
                    <input name="f_lke_id" id="f_lke_id" class="easyui-combobox" data-options="label:'LKE',width:800,required:true,labelAlign:'right',readonly:true,">
                    <input name="f_indikator_id" id="f_indikator_id" class="easyui-combotree" data-options="label:'Indikator',width:800,required:false,labelAlign:'right',">
                </td>
            </tr>

            <tr>
                <td colspan="2">
                    adsasda   
                </td>
            </tr>

            <tr>
                <td>
                    <span class="easyui-tooltip" title="Save" style="padding-left: 10%;">
                        <a id="btnSaveFormula" href="javascript:void(0)" class="easyui-linkbutton" data-options="plain:false,iconCls:'icon-save',">Save</a>
                    </span>
                    <span class="easyui-tooltip" title="Clear" style="padding-left: 5%;">
                        <a id="btnClearFormula" href="javascript:void(0)" class="easyui-linkbutton c2" data-options="plain:false,iconCls:'icon-clear',">Clear</a>
                    </span>
                </td>
            </tr>
        </table>
    </form>
</div>