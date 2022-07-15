@extends('layouts.default')

@section('content')
<div class="easyui-panel" data-options="fit:true,border:false,">
    <div id="tbs" class="easyui-tabs" style="width:100%;height:100%;"
        data-options="border:false,tools:'#tab-tools'">
        <div title="List">
            @include('pages.core.user.list')
        </div>

        <div title="Form">
            @include('pages.core.user.form')
        </div>
    </div>
    <div id="tab-tools">
        <span class="easyui-tooltip" title="Create">
            <a id="btnAdd" href="javascript:void(0)" class="easyui-linkbutton" data-options="plain:true,iconCls:'icon-add'"></a>
        </span>
        
        <span class="easyui-tooltip" title="Save">
            <a id="btnSave" href="javascript:void(0)" class="easyui-linkbutton" data-options="plain:true,iconCls:'icon-save',disabled:true"></a>
        </span>
        
        <span class="easyui-tooltip" title="Edit">
            <a id="btnEdit" href="javascript:void(0)" class="easyui-linkbutton" data-options="plain:true,iconCls:'icon-edit'"></a>
        </span>
        
        <span class="easyui-tooltip" title="Duplicate">
            <a id="btnCopy" href="javascript:void(0)" class="easyui-linkbutton" data-options="plain:true,iconCls:'icon-copy'"></a>
        </span>
    </div>
</div>

<script src="{{ asset('assets/pages/core/user.js') }}"></script>
@endsection