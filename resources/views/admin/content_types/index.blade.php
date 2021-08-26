@extends('layouts.master')

@section('custom-css')

</style>

@endsection

@section('content')
<main class="h-full overflow-y-auto " x-data="{ acceptsData: 'false', showAddCollectionModel : false, showAddField : false, showCollectionNameForm: true }">

  <div class="grid grid-cols-4 gap-4 h-full">
    <div class="col-span-1 py-10  bg-gray-200">

        <div class="ml-5">
            <p class="font-bold uppercase text-xs text-gray-600">Collection type</p>
        <div class="h-60 overflow-y-scroll">

            <ul class="ml-5">
                <li class="py-3 bg-gray-400">Lorem ipsum dolor sit amet</li>
                <li class="py-3">Lorem ipsum dolor sit amet</li>
                <li class="py-3">Lorem ipsum dolor sit amet</li>
                <li class="py-3">Lorem ipsum dolor sit amet</li>
                <li class="py-3">Lorem ipsum dolor sit amet</li>
                <li class="py-3">Lorem ipsum dolor sit amet</li>
                <li class="py-3">Lorem ipsum dolor sit amet</li>


              </ul>
        </div>
        <div class="px-6 my-6">
            <button @click="showAddCollectionModel = !showAddCollectionModel" class="flex items-center justify-between w-full px-4 py-2 text-sm font-medium leading-5 text-blue-500 transition-colors duration-15border border-transparent rounded-lg active:bg-purple-600 hover:underline focus:outline-none focus:shadow-outline-purple">
                Create Collection
                <span class="ml-2" aria-hidden="true">+</span>
            </button>
        </div>

        </div>




    </div>

    <div class="col-span-3 px-5 py-10 mr-5">

        <h4 id="active-table-name" class="mb-4 text-xl font-semibold text-gray-600 dark:text-gray-300">
            Table Name
          </h4>


          <div class="flex justify-end py-3">
            <div class="relative">

                <div class="row">

                </div>

              <div class="flex flex-row">
                <div x-data="{ dropdownOpen: false }" class="relative">

                    <div class="row">

                    </div>

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
                <button x-on:click="deleteUnsavedCollection()" class="bg-red-400 hover:bg-red-600 w-20 text-white relative z-10 block rounded-md  p-2 focus:outline-none">
                    Cancel
                  </button>
                  <button x-on:click="createNewCollection()" class="bg-purple-600 ml-5 hover:bg-purple-400 w-20 relative z-10 block rounded-md  p-2 focus:outline-none">
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
            <div class="grid px-4 py-3 text-xs font-semibold tracking-wide text-gray-500 uppercase border-t dark:border-gray-700 bg-gray-50 sm:grid-cols-9 dark:text-gray-400 dark:bg-gray-800">
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
            </div>
          </div>


    </div>

    </div>



    <div >
        <!-- Modal Background -->
        <div x-show="showAddCollectionModel" class="fixed text-gray-500 flex items-center justify-center overflow-auto z-50 bg-black bg-opacity-40 left-0 right-0 top-0 bottom-0" x-transition:enter="transition ease duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="transition ease duration-300" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0">
            <!-- Modal -->
            <div x-show="showAddCollectionModel" class="bg-white w-1/2 rounded-2xl  p-6 mx-10" @click.away="showAddCollectionModel = false" x-transition:enter="transition ease duration-100 transform" x-transition:enter-start="opacity-0 scale-90 translate-y-1" x-transition:enter-end="opacity-100 scale-100 translate-y-0" x-transition:leave="transition ease duration-100 transform" x-transition:leave-start="opacity-100 scale-100 translate-y-0" x-transition:leave-end="opacity-0 scale-90 translate-y-1">
                {{-- Create Collection Form   --}}
                    <div x-show="showCollectionNameForm">
                        <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title">
                            Create a Collection Type
                          </h3>
                        <form class="bg-white px-8 pt-6 pb-8 mb-4">
                          @csrf
                            <div class="mb-4">
                              <label class="block text-gray-700 text-sm font-bold mb-2" for="display_name">
                                Display Name
                              </label>
                              <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="display_name" type="text" placeholder="Display Name">
                            </div>
                            <div class="mb-4">
                                <label class="block text-gray-700 text-sm font-bold mb-2" for="collection_name">
                                  Collection Name
                                </label>
                                <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="collection_name" type="text" placeholder="Collection Name">
                              </div>

                          </form>
                        <!-- Buttons -->
                        <div class="text-right space-x-5 mt-5">
                            <button @click="showAddCollectionModel = !showAddCollectionModel" class="px-4 py-2 text-sm bg-white rounded-xl border transition-colors duration-150 ease-linear border-gray-200 text-gray-500 focus:outline-none focus:ring-0 font-bold hover:bg-gray-50 focus:bg-indigo-50 focus:text-indigo">Cancel</button>
                            <button @click="draftCollection(); showAddField = true; showCollectionNameForm = false" class="px-4 py-2 text-sm bg-white rounded-xl border transition-colors duration-150 ease-linear border-gray-200 text-gray-500 focus:outline-none focus:ring-0 font-bold hover:bg-gray-50 focus:bg-indigo-50 focus:text-indigo">Continue</button>
                        </div>
                    </div>

                {{-- End Create Collection Form  --}}

                {{-- Add Field Form   --}}
                    <div x-show="showAddField" class="overflow-y-auto">
                        <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title">
                            Add a field
                          </h3>
                        <form class="bg-white px-8 pt-6 pb-8 mb-4">
                            <div class="mb-4">
                              <label class="block text-gray-700 text-sm font-bold mb-2" for="field_name">
                                Field Name
                              </label>
                              <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="field_name" type="text" placeholder="Field Name">
                            </div>
                            <div class="mb-4">
                                <label class="block text-gray-700 text-sm font-bold mb-2" for="collection_name">
                                  Field Type
                                </label>
                                <select id="field_type" class="block appearance-none w-full bg-gray-200 border border-gray-200 text-gray-700 py-3 px-4 pr-8 rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-500" id="field_type">
                                    <option value="char">Char</option>
                                    <option value="string">String</option>
                                    <option value="text">Text</option>
                                    <option value="boolean">Boolean</option>
                                    <option value="integer">Integer</option>
                                    <option value="bigInteger">BigInteger</option>
                                    <option value="bigIncrements">BigIncrements</option>
                                    <option value="json">JSON</option>
                                    <option value="integer">Integer</option>
                                    <option value="double">Double</option>
                                    <option value="float">Float</option>
                                    <option value="timestamp">Timestamp</option>
                                    <option value="float">Float</option>
                                    <option value="date">Date</option>
                                  </select>
                            </div>
                            <div class="mb-4">
                                <label class="block text-gray-700 text-sm font-bold mb-2" for="default_value">
                                Default Value
                                </label>
                                <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="default_value" type="text" placeholder="Default Value">
                            </div>

                            <div class="flex flex-row">
                                <div class="mb-4 w-full">
                                    <label class="block text-gray-700 text-sm font-bold mb-2" for="default_value">
                                    Nullable
                                    </label>
                                    <select class="block appearance-none w-full bg-gray-200 border border-gray-200 text-gray-700 py-3 px-4 pr-8 rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-500" id="nullable">
                                        <option value="true">True</option>
                                        <option value="false">False</option>
                                      </select>
                                  </div>

                                <div class="mb-4 w-full mx-5">
                                    <label class="block text-gray-700 text-sm font-bold mb-2" for="unique">
                                    Unique
                                    </label>
                                    <select class="block appearance-none w-full bg-gray-200 border border-gray-200 text-gray-700 py-3 px-4 pr-8 rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-500" id="unique">
                                        <option value="true">True</option>
                                        <option value="false">False</option>
                                      </select>
                                  </div>

                                <div class="mb-4 w-full">
                                    <label class="block text-gray-700 text-sm font-bold mb-2" for="unique">
                                    Accepts File
                                    </label>
                                    <select x-on:change="acceptsData = document.getElementById('accepts-file').value"  class="block appearance-none w-full bg-gray-200 border border-gray-200 text-gray-700 py-3 px-4 pr-8 rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-500" id="accepts-file">
                                        <option value="false">False</option>
                                        <option value="true">True</option>
                                      </select>
                                  </div>
                            </div>

                            <div class="mb-4 w-full" x-show="acceptsData == 'true'">
                                <label class="block text-gray-700 text-sm font-bold mb-2" for="unique">
                                File Type
                                </label>
                                <select class="block appearance-none w-full bg-gray-200 border border-gray-200 text-gray-700 py-3 px-4 pr-8 rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-500" id="file-type">
                                    <option value="image">Image</option>
                                    <option value="audio">Audio</option>
                                    <option value="video">Video</option>
                                    <option value="document">Document</option>
                                    <option value="any">Any</option>
                                  </select>
                              </div>



                          </form>
                        <!-- Buttons -->
                        <div class="text-right space-x-5 mt-5">
                            <button @click="showAddCollectionModel = !showAddCollectionModel" class="px-4 py-2 text-sm bg-white rounded-xl border transition-colors duration-150 ease-linear border-gray-200 text-gray-500 focus:outline-none focus:ring-0 font-bold hover:bg-gray-50 focus:bg-indigo-50 focus:text-indigo">Finish</button>
                            <button @click="addCollectionField()" class="px-4 py-2 text-sm bg-white rounded-xl border transition-colors duration-150 ease-linear border-gray-200 text-gray-500 focus:outline-none focus:ring-0 font-bold hover:bg-gray-50 focus:bg-indigo-50 focus:text-indigo">Add Another Field</button>
                        </div>
                    </div>

                {{-- End Field Form  --}}
            </div>
        </div>
    </div>
  </main>




@endsection

@section('custom-js')
<script>

    const addItemsToTable = () => {
        let newCollection =  localStorage.getItem('newCollection');

        if (newCollection != null && newCollection != undefined) {
            newCollection = JSON.parse(newCollection);
            let tableName = newCollection.name
            let fields = newCollection.columns

            document.getElementById('active-table-name').innerHTML = tableName[0].toUpperCase() + tableName.substr(1);

            document.getElementById('active-collection-fields').innerHTML = ''

            for (let i = 0; i < fields.length; i++) {
                const field = fields[i];

                document.getElementById('active-collection-fields').innerHTML += `

                <tr class="text-gray-700 dark:text-gray-400">
                    <td class="px-4 py-3 ">
                        ${field.field_name}
                    </td>
                    <td class="px-4 py-3">
                        ${field.field_type}
                    </td>
                    <td class="px-4 py-3">

                      <div class="flex items-center space-x-4 text-sm">
                        <button class="flex items-center justify-between px-2 py-2 text-sm font-medium leading-5 text-purple-600 rounded-lg dark:text-gray-400 focus:outline-none focus:shadow-outline-gray" aria-label="Edit">
                          <svg class="w-5 h-5" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z"></path>
                          </svg>
                        </button>
                        <button class="flex items-center justify-between px-2 py-2 text-sm font-medium leading-5 text-purple-600 rounded-lg dark:text-gray-400 focus:outline-none focus:shadow-outline-gray" aria-label="Delete">
                          <svg class="w-5 h-5" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                          </svg>
                        </button>
                      </div>

                    </td>

                  </tr>




                `


            }




        }

    }


    const draftCollection = () =>{
        newCollection = {}
        newCollection.display_name = document.getElementById('display_name').value
        newCollection.name = document.getElementById('collection_name').value
        newCollection.columns = []
        newCollection.config_fields = {}

        localStorage.setItem('newCollection', JSON.stringify(newCollection))
    }

    const deleteUnsavedCollection = () => {
        // Todo: Implement delete unsaved collection
    }

    const createNewCollection = () => {
        let newCollection = localStorage.getItem('newCollection')

        if (newCollection != null && newCollection != undefined) {
            newCollection = JSON.parse(newCollection);

            fetch('/content-types/create',
            {
                    method: 'POST',
                    headers: {
                        'Accept': 'application/json',
                        'Content-Type': 'application/json',
                        "X-Requested-With": "XMLHttpRequest",
                        "X-CSRF-Token": document.querySelector('input[name="_token"]').value
                    },
                    body: JSON.stringify(newCollection)
            })
            .then(response.json)
            .then(response => {
                console.log(response)
            })





        }



    }

    const addConfigField = (fieldName, checkedStatus) => {
        let newCollection = localStorage.getItem('newCollection');

        if (newCollection != null && newCollection != undefined) {
            newCollection = JSON.parse(newCollection);
            newCollection.config_fields[fieldName] = checkedStatus;
            localStorage.setItem('newCollection', JSON.stringify(newCollection));
        }
    }

    const appendFieldToConfigure = (field) => {

        let configFieldsViewElem =  document.getElementById("configure-fields-view")

        let currentConfigureFieldsHTML = configFieldsViewElem.innerHTML
        configFieldsViewElem.innerHTML = ""

        currentConfigureFieldsHTML += `<a href="#" class="block px-4 py-2 text-sm capitalize text-gray-700 hover:bg-blue-500 hover:text-white">
                            <input onchange="addConfigField('${field.field_name.toLowerCase()}', this.checked)" type="checkbox" name="" id="checkbox-hide-field">  <span class="ml-3">${field.field_name}</span>
                        </a>`

                        configFieldsViewElem.innerHTML = currentConfigureFieldsHTML
    }

    const addCollectionField = () => {
        newCollection = JSON.parse(localStorage.getItem('newCollection'))

        if (newCollection != null && newCollection != undefined){
            let newField = {
                'field_name' : document.getElementById('field_name').value,
                'field_type' : document.getElementById('field_type').value,
                'unique' : document.getElementById('unique').value,
                'default' : document.getElementById('default_value').value,
                'nullable' : document.getElementById('nullable').value,
                'accepts_file' : document.getElementById('accepts-file').value,
                'file_type' : document.getElementById('file-type').value

            }

            newCollection.columns.push(newField)
            appendFieldToConfigure(newField)

            localStorage.setItem('newCollection', JSON.stringify(newCollection))

            document.getElementById('field_name').value = ''
            document.getElementById('field_type').value = ''
            document.getElementById('unique').value = false
            document.getElementById('default_value').value = ''
            document.getElementById('nullable').value = false
        }

        addItemsToTable()
    }
</script>

@endsection
