<div class="lg:w-3/4  px-5 py-10 mr-5">

    <div x-show="showCollectionTable == false" class="flex items-center  w-full h-full">
        <div class="px-10 text-gray-600 text-5xl font-bold text-center">
            Click a table to view its fields or create one
        </div>
    </div>

    <div x-show="showCollectionTable" >

        <div class="flex flex-row items-start">
            <h4 id="active-table-name" class="mb-4 text-xl font-semibold text-gray-600 dark:text-gray-300">
                Table Name
            </h4>
            <button id="edit-table-name-button" class="ml-2 mt-1 hidden" type="button" x-on:click="showRenameTableModal = true; populateEditTableModal();">
                <svg class="w-4 h-4 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
            </button>
        </div>



          <div class="flex justify-end py-3">
            <button id="modify-table-perms-btn" x-on:click="showPermissionTable = true" class="bg-purple-600 ml-3 hidden text-white hover:bg-purple-400 w-55 relative  block rounded-md  p-2 focus:outline-none">
                <svg class="w-6 h-6 inline-block" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>

                Permissions
              </button>
            <div class="relative">



              <div class="flex flex-row">

                <button x-on:click="showAddField = true; showAddCollectionModel = true; showCollectionNameForm = false" class="bg-purple-600 text-white ml-5 hover:bg-purple-400 relative  block rounded-md  p-2 focus:outline-none">
                    <svg class="w-6 h-6 inline-block" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>

                    New Field
                  </button>
                <div x-data="{ dropdownOpen: false }" class="relative ml-3">



                  <button @click="dropdownOpen = !dropdownOpen" class="relative  block rounded-md text-white bg-blue-600 p-2 focus:outline-none">
                    <div class="flex flex-row">
                        <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>

                       Config View
                    <svg class="h-5 w-5 text-gray-800" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                      <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                    </svg>
                    </div>
                  </button>

                  <div x-show="dropdownOpen" @click="dropdownOpen = false" class="fixed inset-0 h-full w-full " style="display: none;"></div>

                  <div x-show="dropdownOpen" class="absolute right-0 mt-2 py-2 w-64 bg-white rounded-md shadow-xl z-20" style="display: none;">

                    <p class="font-bold ml-4">Show/Hide fields</p>

                    <div id="configure-fields-view">


                    </div>





                  </div>
                </div>

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
                <tbody id="active-table-fields" class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800">



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

            <div class="flex flex-row justify-end mt-5">
                <button x-on:click="deleteUnsavedCollection()" class="bg-red-400 ml-4 hover:bg-red-600 w-20 text-white relative  block rounded-md  p-2 focus:outline-none">
                    Cancel
                  </button>
                  <button id="save-table-button" onclick="createNewCollection()" class="bg-purple-600 ml-3 text-white hover:bg-purple-400 w-20 relative  block rounded-md  p-2 focus:outline-none">
                    Save
                  </button>

            </div>
          </div>
    </div>


</div>
