@extends('layouts.default')

@section('content')
<div class="easyui-panel" data-options="fit:true,border:false,">
    <div id="tbs" class="easyui-tabs" style="width:100%;height:100%;" data-options="border:false,tools:'#tab-tools'">
        <div title="Indikator">
            <div class="easyui-layout" data-options="fit:true">
                <div data-options="region:'north',split:false,border:false," style="height:43%">
                    @include('pages.lke.setting.indikator_form')
                </div>
                <div data-options="region:'center',bolder:false,">
                    @include('pages.lke.setting.indikator_list')
                </div>
            </div>
        </div>
        
        <div title="Formula">
            <div class="easyui-layout" data-options="fit:true">
                <div data-options="region:'north',split:false,border:false," style="height:20%">
                    @include('pages.lke.setting.formula_form')
                </div>
                <div data-options="region:'center',bolder:false,">
                    @include('pages.lke.setting.formula_list')
                </div>
            </div>            
        </div>
    </div>
</div>

<div id="w_sett_lke" class="easyui-window" title="Form Setting LKE" data-options="modal:true,closed:false,collapsible:false,minimizable:false,maximizable:false,closable:false," style="width:600px;height:300px;padding:10px;">
    <div class="easyui-layout" data-options="fit:true">
        <div data-options="region:'center'">
            <table class="easyui-datagrid" id="dgLke">
                <thead>
                    <tr>
                        <th data-options="field:'nama'">LKE</th>
                        <th data-options="field:'tahun'">Tahun</th>
                        <th data-options="
                            field:'aktif',
                            formatter: function(value, row, index) {
                                return value == 1 ? 'Ya' : 'Tidak'
                            },                            
                        ">Aktif</th>
                        <th data-options="field:'total_indikator'">Total Indikator</th>
                    </tr>
                </thead>
            </table>
        </div>
        <div data-options="region:'south',border:false" style="text-align:right;padding:5px 0 0;">
            <a href="javascript:void(0)" class="easyui-linkbutton" id="btnChooseLKE" data-options="iconCls:'icon-ok'">Pilih</a>
        </div>
    </div>
</div>

<script src="{{ asset('assets/pages/lke/setting/index.js') }}"></script>
<script src="{{ asset('assets/pages/lke/setting/indikator.js') }}"></script>
<script src="{{ asset('assets/pages/lke/setting/formula_nilai_minimal.js') }}"></script>
<script src="{{ asset('assets/pages/lke/setting/formula_indikator.js') }}"></script>
<script src="{{ asset('assets/pages/lke/setting/formula_jawaban.js') }}"></script>
@endsection