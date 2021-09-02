<div id="edit-table-permissions">
    <!-- Modal Background -->
    <div
    x-show="showPermissionTable"
        class="fixed text-gray-500 flex items-center justify-center overflow-auto z-50 bg-black bg-opacity-40 left-0 right-0 top-0 bottom-0"
        x-transition:enter="transition ease duration-300" x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100" x-transition:leave="transition ease duration-300"
        x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0">
        <!-- Modal -->
        <div x-show="showPermissionTable" class="bg-white w-1/2 rounded-2xl  p-6 mx-10"
            @click.away="showPermissionTable = false" x-transition:enter="transition ease duration-100 transform"
            x-transition:enter-start="opacity-0 scale-90 translate-y-1"
            x-transition:enter-end="opacity-100 scale-100 translate-y-0"
            x-transition:leave="transition ease duration-100 transform"
            x-transition:leave-start="opacity-100 scale-100 translate-y-0"
            x-transition:leave-end="opacity-0 scale-90 translate-y-1">
            {{-- Set permissions Form --}}
            <div x-show="showCollectionNameForm">
                <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title">
                    Set Table Permissions
                </h3>
                <form class="bg-white px-8 pt-6 pb-8 mb-4">
                    @csrf

                    <div id="role-perms-container"></div>

                    {{-- <div class="role-perms">
                        <p class="font-bold">Admin</p>

                        <div class="flex flex-row checkbox-row">
                            <a href="#"
                                class="block px-4 py-2 text-sm capitalize text-gray-700 hover:bg-blue-500 hover:text-white">
                                <input checked onchange="" type="checkbox" name="" id="checkbox-hide-field"> <span
                                    class="ml-3">Read</span>
                            </a>
                        </div>

                    </div> --}}






                </form>
                <!-- Buttons -->
                <div class="text-right space-x-5 mt-5">
                    <button @click="showPermissionTable = false"
                        class="px-4 py-2 text-sm bg-white rounded-xl border transition-colors duration-150 ease-linear border-gray-200 text-gray-500 focus:outline-none focus:ring-0 font-bold hover:bg-gray-50 focus:bg-indigo-50 focus:text-indigo">Close</button>
                    <button @click="showPermissionTable = false"
                        class="px-4 py-2 text-sm bg-white rounded-xl border transition-colors duration-150 ease-linear border-gray-200 text-gray-500 focus:outline-none focus:ring-0 font-bold hover:bg-gray-50 focus:bg-indigo-50 focus:text-indigo">Continue</button>
                </div>
            </div>

            {{-- End Set permissions Form --}}


        </div>
    </div>
</div>
