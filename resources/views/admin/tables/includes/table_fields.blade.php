<div class="lg:w-3/4  px-5 py-10 mr-5">
    <div x-show="showCollectionTable == false" class="flex items-center  w-full h-full">
        <div class="px-10 text-gray-600 text-5xl font-bold text-center">
            Click a table to view its fields or create one
        </div>
    </div>

    <div x-show="showCollectionTable">
        <div class="flex flex-row items-start">
            <h4 id="active-table-name" class="mb-4 text-xl font-semibold text-gray-600 dark:text-gray-300">
                Table Name
            </h4>
            <button id="edit-table-name-button" class="ml-2 mt-1 hidden" type="button"
                x-on:click="showRenameTableModal = true; populateEditTableModal();">
                <svg class="w-4 h-4 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                    xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z">
                    </path>
                </svg>
            </button>
        </div>



        <div class="flex justify-end pb-3">
            <div class=" ">
                <!-- Dropdown toggle button -->
                <button
                    x-on:click="tableOptionsDropdown = !tableOptionsDropdown"
                    class="shadow-sm relative z-10 block p-2 text-white hover:bg-purple-600 hover:shadow-lg bg-purple-500 border border-transparent rounded-md dark:text-white focus:border-blue-500 focus:ring-opacity-40 dark:focus:ring-opacity-40 focus:ring-blue-300 dark:focus:ring-blue-400 focus:ring dark:bg-gray-800 focus:outline-none">
                    Options
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 inline-block" viewBox="0 0 20 20"
                        fill="currentColor">
                        <path
                            d="M10 6a2 2 0 110-4 2 2 0 010 4zM10 12a2 2 0 110-4 2 2 0 010 4zM10 18a2 2 0 110-4 2 2 0 010 4z" />
                    </svg>
                </button>

                <!-- Dropdown menu -->
                <div x-show="tableOptionsDropdown" @click.away="tableOptionsDropdown = false" class="absolute right-20 mt-2 py-2 w-64 bg-white rounded-md shadow-xl z-20">
                    <button
                        x-on:click="showAddField = true; showAddCollectionModel = true; showCollectionNameForm = false;"
                        class="flex w-full items-center p-3 text-sm text-gray-600 capitalize transition-colors duration-200 transform dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 dark:hover:text-white">
                        <svg class="w-5 h-5 mx-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10">
                            </path>
                        </svg>

                        <span class="mx-1">
                            Add Field
                        </span>
                    </button>

                    <button x-on:click="showCreateKeyModal = true;" id="new_key_button"
                        class="flex w-full items-center p-3 text-sm text-gray-600 capitalize transition-colors duration-200 transform dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 dark:hover:text-white">
                        <svg class="w-5 h-5 mx-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z">
                            </path>
                        </svg>

                        <span class="mx-1">
                            Add Key
                        </span>
                    </button>

                    <button x-on:click="addTableActionModal = true" id="new_key_button"
                        class="flex w-full items-center p-3 text-sm text-gray-600 capitalize transition-colors duration-200 transform dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 dark:hover:text-white">
                        <svg class="w-5 h-5 mx-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13 9l3 3m0 0l-3 3m3-3H8m13 0a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>

                        <span class="mx-1">
                            Add Action
                        </span>
                    </button>

                    <hr class="border-gray-200 dark:border-gray-700 ">
                    <button id="modify-table-perms-btn" x-on:click="showPermissionTable = true"
                        class="flex w-full items-center px-3 py-3 text-sm text-gray-600 capitalize transition-colors duration-200 transform dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 dark:hover:text-white">
                        <svg class="w-5 h-5 mx-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z">
                            </path>
                        </svg>

                        <span class="mx-1">
                            Permissions
                        </span>
                    </button>



                </div>
            </div>

            <div x-data="{ configViewDropdown: false }" class="ml-3">



                <button @click="configViewDropdown = !configViewDropdown"
                    class="relative  block rounded-md text-white bg-blue-600 p-2 focus:outline-none">
                    <div class="flex flex-row">


                        Config View
                        <svg class="h-6 w-6 text-white mx-1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                            fill="currentColor">
                            <path fill-rule="evenodd"
                                d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                clip-rule="evenodd"></path>
                        </svg>
                    </div>
                </button>

                <div x-show="configViewDropdown" @click="configViewDropdown = false" class="fixed inset-0 h-full w-full "
                    style="display: none;"></div>

                <div x-show="configViewDropdown" class="absolute right-0 mt-2 py-2 w-64 bg-white rounded-md shadow-xl z-20"
                    style="display: none;">

                    <p class="font-bold ml-4">Show/Hide fields</p>

                    <div id="configure-fields-view">


                    </div>






                </div>


            </div>
        </div>


        <div class="w-full overflow-hidden rounded-lg shadow-xs">

            {{-- Fields Table --}}
            <div class="py-3 text-xs font-semibold tracking-wide text-left text-gray-500 uppercase border-b dark:border-gray-700 bg-gray-50 dark:text-gray-400 dark:bg-gray-800">Fields</div>
            <div class="w-full overflow-x-scroll">
                <table class="w-full whitespace-no-wrap border">
                    <thead>
                        <tr
                            class="text-xs font-semibold tracking-wide text-left text-gray-500 uppercase border-b dark:border-gray-700 bg-gray-50 dark:text-gray-400 dark:bg-gray-800">
                            <th class="px-4 py-3">Name</th>
                            <th class="px-4 py-3">Field Type</th>
                            <th class="px-4 py-3">Actions</th>
                        </tr>
                    </thead>
                    <tbody id="active-table-fields" class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800">



                    </tbody>
                </table>
            </div>

            {{-- Keys Table --}}
            <div class="py-3 mt-3 text-xs font-semibold tracking-wide text-left text-gray-500 uppercase border-b dark:border-gray-700 bg-gray-50 dark:text-gray-400 dark:bg-gray-800">Keys</div>
            <div class="w-full overflow-x-scroll">
                <table class="w-full whitespace-no-wrap border">
                    <thead>
                        <tr
                            class="text-xs font-semibold tracking-wide text-left text-gray-500 uppercase border-b dark:border-gray-700 bg-gray-50 dark:text-gray-400 dark:bg-gray-800">
                            <th class="px-4 py-3">Name</th>
                            <th class="px-4 py-3">Key Type</th>
                            <th class="px-4 py-3">Actions</th>
                        </tr>
                    </thead>
                    <tbody id="keys-active-table-fields" class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800">



                    </tbody>
                </table>
            </div>

            {{-- Actions Table --}}
            <div class="py-3 mt-3 text-xs font-semibold tracking-wide text-left text-gray-500 uppercase border-b dark:border-gray-700 bg-gray-50 dark:text-gray-400 dark:bg-gray-800">Actions</div>
            <div class="w-full overflow-x-scroll">
                <table class="w-full whitespace-no-wrap border">
                    <thead>
                        <tr
                            class="text-xs font-semibold tracking-wide text-left text-gray-500 uppercase border-b dark:border-gray-700 bg-gray-50 dark:text-gray-400 dark:bg-gray-800">
                            <th class="px-4 py-3">Identifier</th>
                            <th class="px-4 py-3">DisplayName</th>
                            <th class="px-4 py-3">Actions</th>
                        </tr>
                    </thead>
                    <tbody id="actions-active-table-fields" class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800">



                    </tbody>
                </table>
            </div>



            <div class="flex flex-row justify-end mt-5 mb-10">
                {{-- <button x-on:click="deleteUnsavedCollection()"
                    class="bg-red-400 ml-4 hover:bg-red-600 w-20 text-white relative  block rounded-md  p-2 focus:outline-none">
                    Cancel
                </button> --}}
                <button id="save-table-button" onclick="createNewCollection()"
                    class="bg-purple-600 ml-3 text-white hover:bg-purple-400 w-20 relative  block rounded-md  p-2 focus:outline-none">
                    Save
                </button>

            </div>
        </div>
    </div>
</div>
