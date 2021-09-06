@extends('layouts.master')

@section('custom-css')

</style>

@endsection

@section('content')
<main class="h-full overflow-y-auto " x-data="{ showRenameTableModal: false, showCollectionTable: false, showPermissionTable: false, acceptsData: 'false', showAddCollectionModel : false,showAddField : false, showCollectionNameForm: true, editCollectionField : false }">

  <div class="lg:flex h-full">
    @include('admin.tables.includes.table_list')

    @include('admin.tables.includes.table_fields')

</div>


@include('admin.modals.add_field')
@include('admin.modals.edit_column')
@include('admin.modals.table_permissions')
@include('admin.modals.rename_table')
  </main>




@endsection

@section('custom-js')
<script src="{{ asset('js/tables/table.js') }}"></script>
<script src="{{ asset('js/tables/manage.js') }}"></script>

@endsection
