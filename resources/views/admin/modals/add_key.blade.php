
    <div >
        <!-- Modal Background -->
        <div x-show="showCreateKeyModal" class="fixed text-gray-500 flex items-center justify-center overflow-auto z-50 bg-black bg-opacity-40 left-0 right-0 top-0 bottom-0" x-transition:enter="transition ease duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="transition ease duration-300" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0">
            <!-- Modal -->
            <div x-show="showCreateKeyModal" class="bg-white w-1/2 rounded-2xl  p-6 mx-10" @click.away="showCreateKeyModal = false" x-transition:enter="transition ease duration-100 transform" x-transition:enter-start="opacity-0 scale-90 translate-y-1" x-transition:enter-end="opacity-100 scale-100 translate-y-0" x-transition:leave="transition ease duration-100 transform" x-transition:leave-start="opacity-100 scale-100 translate-y-0" x-transition:leave-end="opacity-0 scale-90 translate-y-1">
                {{-- Create Table Form   --}}

                        <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title">
                            Create a Key
                          </h3>
                        <form class="bg-white px-8 pt-6 pb-8 mb-4">
                          @csrf
                            <div class="mb-4">
                              <label class="block text-gray-700 text-sm font-bold mb-2" for="display_name">
                                Key Type
                              </label>
                              <select class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 border-gray-50 leading-tight focus:outline-none focus:shadow-outline focus:border-gray-200" id="key_type">
                                  <option value="foreign_key">Foreign Key</option>
                              </select>
                            </div>
                            <div class="mb-4">
                              <label class="block text-gray-700 text-sm font-bold mb-2" for="display_name">
                                Column
                              </label>
                              <select class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 border-gray-50 leading-tight focus:outline-none focus:shadow-outline focus:border-gray-200" id="column_name">
                                  <option value="value_here">Name Here</option>
                              </select>
                            </div>
                            <div class="mb-4">
                              <label class="block text-gray-700 text-sm font-bold mb-2" for="foreign_table">
                                Foreign Table
                              </label>
                              <select class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 border-gray-50 leading-tight focus:outline-none focus:shadow-outline focus:border-gray-200" id="foreign_table">
                                  <option value="value_here">Name Here</option>
                              </select>
                            </div>
                            <div class="mb-4 foreign-table-column-block hidden">
                              <label class="block text-gray-700 text-sm font-bold mb-2" for="foreign_table">
                                Foreign Table Column
                              </label>
                              <select class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 border-gray-50 leading-tight focus:outline-none focus:shadow-outline focus:border-gray-200" id="foreign_table_column">
                                  <option value="value_here">Name Here</option>
                              </select>
                            </div>

                            <div class="grid grid-cols-2 gap-3">
                                <div class="mb-4">
                                    <label class="block text-gray-700 text-sm font-bold mb-2" for="foreign_table">
                                      On Update
                                    </label>
                                    <select class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 border-gray-50 leading-tight focus:outline-none focus:shadow-outline focus:border-gray-200" id="on_update">
                                        <option value="nothing">Nothing</option>
                                        <option value="cascade">Cascade</option>
                                    </select>
                                  </div><div class="mb-4">
                                    <label class="block text-gray-700 text-sm font-bold mb-2" for="foreign_table">
                                      On Delete
                                    </label>
                                    <select class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 border-gray-50 leading-tight focus:outline-none focus:shadow-outline focus:border-gray-200" id="on_delete">
                                        <option value="nothing">Nothing</option>
                                        <option value="cascade">Cascade</option>
                                    </select>
                                  </div>
                            </div>


                          </form>
                        <!-- Buttons -->
                        <div class="text-right space-x-5 mt-5">
                            <button @click="showCreateKeyModal = !showCreateKeyModal" class="px-4 py-2 text-sm bg-white rounded-xl border transition-colors duration-150 ease-linear border-gray-200 text-gray-500 focus:outline-none focus:ring-0 font-bold hover:bg-gray-50 focus:bg-indigo-50 focus:text-indigo">Cancel</button>
                            <button @click="addKeyToTable();  showCreateKeyModal = !showCreateKeyModal" class="px-4 py-2 text-sm bg-white rounded-xl border transition-colors duration-150 ease-linear border-gray-200 text-gray-500 focus:outline-none focus:ring-0 font-bold hover:bg-gray-50 focus:bg-indigo-50 focus:text-indigo">Continue</button>
                        </div>


                {{-- End Create Table Form  --}}

            </div>
        </div>
    </div>
