
    <div id="edit-collection-field" >
        <!-- Modal Background -->
        <div x-show="editCollectionField" class="fixed text-gray-500 flex items-center justify-center overflow-auto z-50 bg-black bg-opacity-40 left-0 right-0 top-0 bottom-0" x-transition:enter="transition ease duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="transition ease duration-300" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0">
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
                            <button id="add-field-to-collection" onclick="addCollectionField('newCollection')" class="px-4 py-2 text-sm bg-white rounded-xl border transition-colors duration-150 ease-linear border-gray-200 text-gray-500 focus:outline-none focus:ring-0 font-bold hover:bg-gray-50 focus:bg-indigo-50 focus:text-indigo">Add Another Field</button>
                        </div>
                    </div>

                {{-- End Field Form  --}}
            </div>
        </div>
    </div>
