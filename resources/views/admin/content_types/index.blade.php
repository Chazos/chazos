@extends('layouts.master')

@section('custom-css')

</style>

@endsection

@section('content')
<main class="h-full overflow-y-auto " x-data="{ showCollectionTable: false, acceptsData: 'false', showAddCollectionModel : false,showAddField : false, showCollectionNameForm: true, editCollectionField : false }">

  <div class="lg:flex h-full">
    @include('admin.content_types.includes.content_type_list')

    @include('admin.content_types.includes.content_type_table')

</div>


@include('admin.modals.add_field')
@include('admin.modals.edit_column')
  </main>




@endsection

@section('custom-js')
<script src="{{ asset('js/content-type/collection.js') }}"></script>
<script src="{{ asset('js/content-type/manage.js') }}"></script>

@endsection
