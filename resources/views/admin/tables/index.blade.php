@extends('layouts.master')

@section('custom-css')

</style>

@endsection

@section('content')
<main class="h-full overflow-y-auto " x-data="{ showRenameTableModal: false, showCollectionTable: false, showPermissionTable: false, acceptsData: 'false', showAddCollectionModel : false, showCreateKeyModal: false, showAddField : false, showCollectionNameForm: true, editCollectionField : false}">

  <div class="lg:flex h-full">
    @include('admin.tables.includes.table_list')

    @include('admin.tables.includes.table_fields')

</div>


@include('admin.modals.add_field')
@include('admin.modals.add_key')
@include('admin.modals.edit_column')
@include('admin.modals.table_permissions')
@include('admin.modals.rename_table')

  </main>




@endsection

@section('custom-js')
<script src="{{ asset('js/tables/table.js') }}"></script>
<script src="{{ asset('js/tables/manage.js') }}"></script>

<script>
    let tabsContainer = document.querySelector("#tabs");
    let tabTogglers = tabsContainer.querySelectorAll("#tabs a");

    // console.log(tabTogglers);

    tabTogglers.forEach(function(toggler) {
      toggler.addEventListener("click", function(e) {
        e.preventDefault();

        let tabName = this.getAttribute("href");

        let tabContents = document.querySelector("#tab-contents");

        for (let i = 0; i < tabContents.children.length; i++) {

          tabTogglers[i].parentElement.classList.remove("border-t", "border-r", "border-l", "-mb-px", "bg-white");  tabContents.children[i].classList.remove("hidden");
          if ("#" + tabContents.children[i].id === tabName) {
            continue;
          }
          tabContents.children[i].classList.add("hidden");

        }
        e.target.parentElement.classList.add("border-t", "border-r", "border-l", "-mb-px", "bg-white");
      });
    });

    </script>


@endsection
