@extends('layouts.master')

@section('content')
    <main x-data="{addPluginModal: false}" class="h-full pb-16 overflow-y-auto">
        <div class="container grid px-6 mx-auto">
            <h2 class="my-6 text-2xl font-semibold text-gray-700 dark:text-gray-200">
                Transactions
            </h2>

            <div class="relative w-20 mr-6 mb-6 focus-within:text-purple-500">
                <input style="width: 240%" onkeyup="filterTable(this.value)"
                    class=" pr-2 text-sm text-gray-700 placeholder-gray-600 bg-gray-100 border-0 rounded-md  dark:focus:shadow-outline-gray dark:focus:placeholder-gray-600 dark:bg-gray-700 dark:text-gray-200 focus:placeholder-gray-500 focus:bg-white focus:border-purple-300 focus:outline-none focus:shadow-outline-purple form-input"
                    type="text" placeholder="Search for transactions" aria-label="Search">
            </div>



            <div class="w-full mb-8 overflow-hidden rounded-lg shadow-xs">
                <div class="w-full overflow-x-auto">
                    <table class="w-full whitespace-no-wrap border">
                        <thead>
                            <tr
                                class="text-xs font-semibold tracking-wide text-left text-gray-500 uppercase border-b dark:border-gray-700 bg-gray-50 dark:text-gray-400 dark:bg-gray-800">
                                <th class="px-4 py-3">ID</th>
                                <th class="px-4 py-3">User ID</th>
                                <th class="px-4 py-3">Order ID</th>
                                <th class="px-4 py-3">Total</th>
                                <th class="px-4 py-3">TAX</th>
                                <th class="px-4 py-3">Discount</th>
                                <th class="px-4 py-3">Grand Total</th>
                                <th class="px-4 py-3">Currency</th>
                                <th class="px-4 py-3">Gateway</th>
                                <th class="px-4 py-3">Paid</th>
                                <th class="px-4 py-3">Refunded</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800">
                            @foreach ($transactions as $trans)

                                @php

                                    $row_id = "row-" . $trans->id;

                                @endphp


                                <tr id="{{ $row_id }}" class="text-gray-700 dark:text-gray-400">
                                    <td class="px-4 py-3">
                                        <div class="flex items-center text-sm">
                                            {{ $trans->id }}
                                        </div>
                                    </td>
                                    <td class="px-4 py-3">
                                        <div class="flex items-center text-sm">
                                            {{ $trans->user_id }}
                                        </div>
                                    </td>
                                    <td class="px-4 py-3">
                                        <div class="flex items-center text-sm">
                                            {{ $trans->order_id }}
                                        </div>
                                    </td>
                                    <td class="px-4 py-3">
                                        <div class="flex items-center text-sm">
                                            {{ $trans->total }}
                                        </div>
                                    </td>
                                    <td class="px-4 py-3">
                                        <div class="flex items-center text-sm">
                                            {{ $trans->tax }}
                                        </div>
                                    </td>
                                    <td class="px-4 py-3">
                                        <div class="flex items-center text-sm">
                                            {{ $trans->discount }}
                                        </div>
                                    </td>
                                    <td class="px-4 py-3">
                                        <div class="flex items-center text-sm">
                                            {{ $trans->grand_total }}
                                        </div>
                                    </td>
                                    <td class="px-4 py-3">
                                        <div class="flex items-center text-sm">
                                            {{ $trans->currency }}
                                        </div>
                                    </td>
                                    <td class="px-4 py-3">
                                        <div class="flex items-center text-sm">
                                            {{ $trans->gateway }}
                                        </div>
                                    </td>
                                    <td class="px-4 py-3">
                                        <div class="flex items-center text-sm">
                                            {{ $trans->paid }}
                                        </div>
                                    </td>
                                    <td class="px-4 py-3">
                                        <div class="flex items-center text-sm">
                                            {{ $trans->refunded }}
                                        </div>
                                    </td>


                                </tr>

                            @endforeach


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
                            <svg aria-hidden="true" class="w-4 h-4 fill-current" viewBox="0 0 20 20">
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

        <div>
            <!-- Modal Background -->
            <div x-show="addPluginModal" id="add_table_action_modal"
                class="fixed text-gray-500 flex items-center justify-center overflow-auto z-50 bg-black bg-opacity-40 left-0 right-0 top-0 bottom-0"
                x-transition:enter="transition ease duration-300" x-transition:enter-start="opacity-0"
                x-transition:enter-end="opacity-100" x-transition:leave="transition ease duration-300"
                x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0">
                <!-- Modal -->
                <div x-show="addPluginModal" class="bg-white w-1/2 rounded-2xl  p-6 mx-10"
                    @click.away="addPluginModal = false" x-transition:enter="transition ease duration-100 transform"
                    x-transition:enter-start="opacity-0 scale-90 translate-y-1"
                    x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                    x-transition:leave="transition ease duration-100 transform"
                    x-transition:leave-start="opacity-100 scale-100 translate-y-0"
                    x-transition:leave-end="opacity-0 scale-90 translate-y-1">

                    <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title">
                        Add new plugin
                    </h3>
                    <form class="bg-white pt-6 pb-8 new-plugin">
                        @csrf
                        <div>
                            <label class="block text-gray-700 text-sm font-bold mb-2" for="identifier">
                                Plugin File
                            </label>
                            <input type="file"
                                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                name="plugin_zip" placeholder="Identifier e.g approve_client">
                        </div>


                    </form>
                    <!-- Buttons -->
                    <div class="text-right space-x-5 mt-5">
                        <button @click="addPluginModal = !addPluginModal"
                            class="px-4 py-2 text-sm bg-white rounded-xl border transition-colors duration-150 ease-linear border-gray-200 text-gray-500 focus:outline-none focus:ring-0 font-bold hover:bg-gray-50 focus:bg-indigo-50 focus:text-indigo">Cancel</button>
                        <button id="add-new-plugin-btn" data-route-name="{{ route('admin.plugins.install') }}"
                            class="px-4 py-2 text-sm bg-white rounded-xl border transition-colors duration-150 ease-linear border-gray-200 text-gray-500 focus:outline-none focus:ring-0 font-bold hover:bg-gray-50 focus:bg-indigo-50 focus:text-indigo">Install</button>
                    </div>



                </div>
            </div>
        </div>

    </main>







@endsection

@section('custom-js')

    <script>
        $('#add-new-plugin-btn').on('click', (event) => {
            let destination = $(event.target).attr('data-route-name')
            let form = $('.new-plugin')
            let formData = new FormData(form[0])

            axios.post(destination, formData, {
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                    }
                })
                .then(function(response) {
                    if (response.data.status == 'success') {
                        setSuccessAlert(response.data.message)
                        $('input').val("")
                        document.location.reload(true)
                    }
                })
                .catch(function(error) {
                    setErrorAlert(error.toString())
                });
        })

        const deleteRow = (rowId) => {
            setTimeout(() => {
                $(rowId).fadeTo(2000, 0).slideUp(1000, function() {
                    $(this).remove();
                });
            }, 1000);
        }

        const determinePluginColor = (plugin_name, status) =>{
            let statusId = `#${plugin_name}-status`
            let finalColor = "text-green-600 bg-green-100"
            let finalText = "Active"

            if (!status){
                finalColor = "text-gray-600 bg-gray-100"
                finalText = "Inactive"
            }

            $(statusId).removeClass("text-green-600 bg-green-100 text-gray-600 bg-gray-100")
            $(statusId).addClass(finalColor)
            $(statusId).text(finalText)
        }


        const deletePlugin = (rowId, plugin_name) => {


            axios.post(`/delete-plugin/${plugin_name}`, {}, {
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                    }
                }).then(function(response) {
                    if (response.data.status == 'success') {
                        setSuccessAlert(response.data.message)
                        deleteRow(rowId)
                    } else if (response.data.status == 'failed') {
                        setErrorAlert(response.data.message)
                    }




                })
                .catch(function(error) {
                    setErrorAlert(error.toString())
                });

        }

        const activatePlugin = (plugin_name) => {


            axios.post(`/activate-plugin/${plugin_name}`, {}, {
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                    }
                }).then(function(response) {
                    if (response.data.status == 'success') {
                        setSuccessAlert(response.data.message)
                        determinePluginColor(plugin_name, true)
                    } else if (response.data.status == 'failed') {
                        setErrorAlert(response.data.message)
                    }
                })
                .catch(function(error) {
                    setErrorAlert(error.toString())
                });

        }

        const deactivatePlugin = (plugin_name) => {


            axios.post(`/deactivate-plugin/${plugin_name}`, {}, {
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                    }
                }).then(function(response) {
                    if (response.data.status == 'success') {
                        setSuccessAlert(response.data.message)
                        determinePluginColor(plugin_name, false)
                    } else if (response.data.status == 'failed') {
                        setErrorAlert(response.data.message)
                    }
                })
                .catch(function(error) {
                    setErrorAlert(error.toString())
                });

        }


        function filterTable(value) {
            let rows = document.querySelectorAll('tbody tr');

            for (const row of rows) {
                if (row.innerText.toLowerCase().includes(value.toLowerCase())) {
                    row.classList.remove('hidden');
                } else {
                    row.classList.add('hidden');
                }
            }
        }
    </script>

@endsection
