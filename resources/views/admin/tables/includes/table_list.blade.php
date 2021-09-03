<div class="lg:w-1/4 py-10  bg-gray-200">

    <div class="ml-5">
        <p class="font-bold uppercase text-xs text-gray-600">Table List</p>
    <div class="xl:h-60 overflow-y-scroll">

        <ul class="ml-5">
            @foreach ( $tables as $table )
                <li  class="py-3 hover:bg-purple-400 flex flex-row">
                  <button x-on:click="getCollectionDetails({{ $table->id }}); showCollectionTable = true; showAddField = false; showCollectionNameForm =true" class="">{{ ucfirst($table->display_name)  }}</button>


                  @if ($table->table_name != 'users')
                    <span class="w-full"></span>
                    <button class="mr-3" type="button" x-on:click="deleteCollection({{ $table->id }})">
                        <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                    </button>

                  @endif


                </li>
            @endforeach


          </ul>
    </div>
    <div class="pr-12 my-6">
        <button @click="showAddCollectionModel = !showAddCollectionModel" class="flex items-center justify-between w-full px-4 py-2 text-sm font-medium leading-5 text-white bg-blue-600 hover:bg-blue-400 transition-colors duration-15border border-transparent rounded-lg active:bg-purple-600 hover:underline focus:outline-none focus:shadow-outline-purple">
            Create Table
            <span class="ml-2" aria-hidden="true">+</span>
        </button>
    </div>

    </div>




</div>
