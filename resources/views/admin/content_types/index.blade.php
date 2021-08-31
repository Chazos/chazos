@extends('layouts.master')

@section('custom-css')

</style>

@endsection

@section('content')
<main class="h-full overflow-y-auto " x-data="{ showCollectionTable: false, acceptsData: 'false', showAddCollectionModel : false,showAddField : false, showCollectionNameForm: true, editCollectionField : false }">

  <div class="lg:flex h-full">
    <div class="lg:w-1/4 py-10  bg-gray-200">

        <div class="ml-5">
            <p class="font-bold uppercase text-xs text-gray-600">Collection type</p>
        <div class="xl:h-60 overflow-y-scroll">

            <ul class="ml-5">
                @foreach ( $collections as $collection )
                    <li  class="py-3 hover:bg-purple-400 flex flex-row">
                      <button x-on:click="getCollectionDetails({{ $collection->id }}); showCollectionTable = true" class="">{{ ucfirst($collection->display_name)  }}</button>

                      <span class="w-full"></span>
                      <button class="mr-3" type="button" x-on:click="deleteCollection({{ $collection->id }})">
                        <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                      </button>



                    </li>
                @endforeach


              </ul>
        </div>
        <div class="pr-12 my-6">
            <button @click="showAddCollectionModel = !showAddCollectionModel" class="flex items-center justify-between w-full px-4 py-2 text-sm font-medium leading-5 text-white bg-blue-600 hover:bg-blue-400 transition-colors duration-15border border-transparent rounded-lg active:bg-purple-600 hover:underline focus:outline-none focus:shadow-outline-purple">
                Create Collection
                <span class="ml-2" aria-hidden="true">+</span>
            </button>
        </div>

        </div>




    </div>

    <div class="lg:w-3/4  px-5 py-10 mr-5">

        <div x-show="showCollectionTable == false" class="flex items-center  w-full h-full">
            <div class="px-10 text-gray-600 text-5xl font-bold text-center">
                Click a collection to view its fields or create one
            </div>
        </div>

        <div x-show="showCollectionTable" >
            <h4 id="active-table-name" class="mb-4 text-xl font-semibold text-gray-600 dark:text-gray-300">
                Table Name
            </h4>


              <div class="flex justify-end py-3">
                <div class="relative">



                  <div class="flex flex-row">

                    <button x-on:click="showAddField = true; showAddCollectionModel = true; showCollectionNameForm = false" class="bg-purple-600 text-white ml-5 hover:bg-purple-400 relative z-10 block rounded-md  p-2 focus:outline-none">
                        New Field
                      </button>
                    <div x-data="{ dropdownOpen: false }" class="relative ml-5">



                      <button @click="dropdownOpen = !dropdownOpen" class="relative z-10 block rounded-md bg-white p-2 focus:outline-none">
                        <div class="flex flex-row">
                           Config View
                        <svg class="h-5 w-5 text-gray-800" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                          <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                        </svg>
                        </div>
                      </button>

                      <div x-show="dropdownOpen" @click="dropdownOpen = false" class="fixed inset-0 h-full w-full z-10" style="display: none;"></div>

                      <div x-show="dropdownOpen" class="absolute right-0 mt-2 py-2 w-64 bg-white rounded-md shadow-xl z-20" style="display: none;">

                        <p class="font-bold ml-4">Show/Hide fields</p>

                        <div id="configure-fields-view">


                        </div>





                      </div>
                    </div>
                    <button x-on:click="deleteUnsavedCollection()" class="bg-red-400 ml-4 hover:bg-red-600 w-20 text-white relative z-10 block rounded-md  p-2 focus:outline-none">
                        Cancel
                      </button>
                      <button id="save-collection-button" onclick="createNewCollection()" class="bg-purple-600 ml-5 text-white hover:bg-purple-400 w-20 relative z-10 block rounded-md  p-2 focus:outline-none">
                        Save
                      </button>

                  </div>


                </div>
              </div>


            <div class="w-full overflow-hidden rounded-lg shadow-xs">
                <div class="w-full overflow-x-scroll">
                  <table class="w-full whitespace-no-wrap border">
                    <thead>
                      <tr class="text-xs font-semibold tracking-wide text-left text-gray-500 uppercase border-b dark:border-gray-700 bg-gray-50 dark:text-gray-400 dark:bg-gray-800">
                        <th class="px-4 py-3">Name</th>
                        <th class="px-4 py-3">Field Type</th>
                        <th class="px-4 py-3">Actions</th>
                      </tr>
                    </thead>
                    <tbody id="active-collection-fields" class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800">



                    </tbody>
                  </table>
                </div>

                {{-- <div class="grid px-4 py-3 text-xs font-semibold tracking-wide text-gray-500 uppercase border-t dark:border-gray-700 bg-gray-50 sm:grid-cols-9 dark:text-gray-400 dark:bg-gray-800">
                  <span class="flex items-center col-span-3">
                    Showing 21-30 of 100
                  </span>
                  <span class="col-span-2"></span>
                  <!-- Pagination -->
                  <span class="flex col-span-4 mt-2 sm:mt-auto sm:justify-end">
                    <nav aria-label="Table navigation">
                      <ul class="inline-flex items-center">
                        <li>
                          <button class="px-3 py-1 rounded-md rounded-l-lg focus:outline-none focus:shadow-outline-purple" aria-label="Previous">
                            <svg class="w-4 h-4 fill-current" aria-hidden="true" viewBox="0 0 20 20">
                              <path d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd" fill-rule="evenodd"></path>
                            </svg>
                          </button>
                        </li>
                        <li>
                          <button class="px-3 py-1 rounded-md focus:outline-none focus:shadow-outline-purple">
                            1
                          </button>
                        </li>
                        <li>
                          <button class="px-3 py-1 rounded-md focus:outline-none focus:shadow-outline-purple">
                            2
                          </button>
                        </li>
                        <li>
                          <button class="px-3 py-1 text-white transition-colors duration-150 bg-purple-600 border border-r-0 border-purple-600 rounded-md focus:outline-none focus:shadow-outline-purple">
                            3
                          </button>
                        </li>
                        <li>
                          <button class="px-3 py-1 rounded-md focus:outline-none focus:shadow-outline-purple">
                            4
                          </button>
                        </li>
                        <li>
                          <span class="px-3 py-1">...</span>
                        </li>
                        <li>
                          <button class="px-3 py-1 rounded-md focus:outline-none focus:shadow-outline-purple">
                            8
                          </button>
                        </li>
                        <li>
                          <button class="px-3 py-1 rounded-md focus:outline-none focus:shadow-outline-purple">
                            9
                          </button>
                        </li>
                        <li>
                          <button class="px-3 py-1 rounded-md rounded-r-lg focus:outline-none focus:shadow-outline-purple" aria-label="Next">
                            <svg class="w-4 h-4 fill-current" aria-hidden="true" viewBox="0 0 20 20">
                              <path d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" fill-rule="evenodd"></path>
                            </svg>
                          </button>
                        </li>
                      </ul>
                    </nav>
                  </span>
                </div> --}}
              </div>
        </div>


    </div>

</div>


@include('admin.modals.add_field')
@include('admin.modals.edit_column')
  </main>




@endsection

@section('custom-js')
<script src="{{ asset('js/content-type/collection.js') }}"></script>
<script src="{{ asset('js/content-type/edit-collection.js') }}"></script>

@endsection
