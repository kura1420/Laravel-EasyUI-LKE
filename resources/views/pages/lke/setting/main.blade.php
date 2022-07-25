@extends('layouts.default')

@section('content')
<div class="easyui-panel" data-options="fit:true,border:false,">
    <div id="tbs" class="easyui-tabs" style="width:100%;height:100%;" data-options="border:false,tools:'#tab-tools'">
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
    </div>
</div>

<div id="w_sett_lke" class="easyui-window" title="Form Setting LKE" data-options="modal:true,closed:false,collapsible:false,minimizable:false,maximizable:false,closable:false," style="width:500px;height:200px;padding:10px;">
    <input name="c_lke_id" id="c_lke_id" class="easyui-combobox" data-options="prompt:'Pilih LKE',required:true," style="width: 100%;">
    <p>
        <a href="javascript:void(0)" class="easyui-linkbutton" id="btnChooseLKE">Pilih</a>
    </p>
</div>

<script src="{{ asset('assets/pages/lke/setting/index.js') }}"></script>
<script src="{{ asset('assets/pages/lke/setting/indikator.js') }}"></script>
<script src="{{ asset('assets/pages/lke/setting/formula_nm.js') }}"></script>
<script src="{{ asset('assets/pages/lke/setting/formula_in.js') }}"></script>
@endsection