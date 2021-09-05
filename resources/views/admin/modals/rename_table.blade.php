
    <div id="edit-table-name" >
        <!-- Modal Background -->
        <div x-show="showRenameTableModal" class="fixed text-gray-500 flex items-center justify-center overflow-auto z-50 bg-black bg-opacity-40 left-0 right-0 top-0 bottom-0" x-transition:enter="transition ease duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="transition ease duration-300" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0">
            <!-- Modal -->
            <div class="bg-white w-1/2 rounded-2xl  p-6 mx-10" @click.away="showRenameTableModal = false" x-transition:enter="transition ease duration-100 transform" x-transition:enter-start="opacity-0 scale-90 translate-y-1" x-transition:enter-end="opacity-100 scale-100 translate-y-0" x-transition:leave="transition ease duration-100 transform" x-transition:leave-start="opacity-100 scale-100 translate-y-0" x-transition:leave-end="opacity-0 scale-90 translate-y-1">
                {{-- Create Table Form   --}}
                    <div >
                        <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title">
                            Rename Table
                          </h3>
                        <form id="rename-table-name-form" class="bg-white px-8 pt-6 pb-8 mb-4">
                          @csrf
                            <div class="mb-4">
                              <label class="block text-gray-700 text-sm font-bold mb-2" for="display_name">
                                Display Name
                              </label>
                              <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="display_name" type="text" placeholder="Display Name">
                            </div>
                            <div class="mb-4">
                                <label class="block text-gray-700 text-sm font-bold mb-2" for="table_name">
                                  Table Name
                                </label>
                                <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="table_name" type="text" placeholder="Table Name">
                              </div>
                              <!-- Buttons -->
                        <div class="text-right space-x-5 mt-5">
                            <button @click="showRenameTableModal = !showRenameTableModal" class="px-4 py-2 text-sm bg-white rounded-xl border transition-colors duration-150 ease-linear border-gray-200 text-gray-500 focus:outline-none focus:ring-0 font-bold hover:bg-gray-50 focus:bg-indigo-50 focus:text-indigo">Cancel</button>
                            <button id="rename-table-name-button" type="button" @click="showRenameTableModal = false; renameTableName()" class="px-4 py-2 text-sm bg-white rounded-xl border transition-colors duration-150 ease-linear border-gray-200 text-gray-500 focus:outline-none focus:ring-0 font-bold hover:bg-gray-50 focus:bg-indigo-50 focus:text-indigo">Rename</button>

                        </div>

                          </form>

                    </div>

                {{-- End Create Table Form  --}}


            </div>
        </div>
    </div>
