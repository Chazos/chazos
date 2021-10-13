@extends('layouts.master')

@section('content')
    <main class="h-full pb-16 overflow-y-auto">
        <div class="container grid px-6 mx-auto">
            <h2 class="my-6 text-2xl font-semibold text-gray-700 dark:text-gray-200">
                {{ ucfirst($table->table_name) }}
            </h2>

            <div class="flex justify-end py-3">

                <a href="javascript:void(0)"
                    onclick="exportData('{{ $table->table_name }}')"
                    class="bg-purple-600 px-3 text-white ml-2 hover:bg-purple-400 relative z-10 block rounded-md  p-2 focus:outline-none">
                    Export
                </a>
                <a href="{{ route('admin.add_entry', ['table_name' => $table->table_name]) }}"
                    class="bg-purple-600 px-3 mx-3 text-white ml-2 hover:bg-purple-400 relative z-10 block rounded-md  p-2 focus:outline-none">
                    New Entry
                </a>
                <div x-data="{ dropdownOpen: false }" class="relative">



                    <button @click="dropdownOpen = !dropdownOpen"
                        class="relative z-10 block rounded-md bg-white p-2 focus:outline-none">
                        <div class="flex flex-row">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z">
                                </path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            </svg>
                            <svg class="h-5 w-5 text-gray-800" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                fill="currentColor">
                                <path fill-rule="evenodd"
                                    d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                    clip-rule="evenodd" />
                            </svg>
                        </div>
                    </button>

                    <div x-show="dropdownOpen" @click="dropdownOpen = false" class="fixed inset-0 h-full w-full z-10"></div>

                    <div x-show="dropdownOpen" class="absolute right-0 mt-2 py-2 w-64 bg-white rounded-md shadow-xl z-20">

                        <p class="font-bold ml-4">Show/Hide fields</p>
                        @foreach ($columns as $column)

                            @if ($config_fields[$column->field_name] == true)
                                <a href="#"
                                    class="block px-4 py-2 text-sm capitalize text-gray-700 hover:bg-blue-500 hover:text-white">
                                    <input checked onchange="hideTableField('column_{{ $column->field_name }}')"
                                        type="checkbox" name="" id="checkbox-hide-field"> <span
                                        class="ml-3">{{ $column->field_name }}</span>
                                </a>
                            @else
                                <a href="#"
                                    class="block px-4 py-2 text-sm capitalize text-gray-700 hover:bg-blue-500 hover:text-white">
                                    <input onchange="hideTableField('column_{{ $column->field_name }}')" type="checkbox"
                                        name="" id="checkbox-hide-field"> <span
                                        class="ml-3">{{ $column->field_name }}</span>
                                </a>

                            @endif


                        @endforeach



                    </div>
                </div>
            </div>

            <div class="w-full overflow-hidden rounded-lg shadow-xs">
                <div class="w-full overflow-x-auto">
                    <table class="w-full whitespace-no-wrap">
                        <thead>
                            <tr
                                class="text-xs font-semibold tracking-wide text-left text-gray-500 uppercase border-b dark:border-gray-700 bg-gray-50 dark:text-gray-400 dark:bg-gray-800">

                                <th class="px-4 py-3">ID</th>
                                @include('admin.table_data.includes.manage_table_header')
                                <th class="px-4 py-3">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800">

                        @include('admin.table_data.includes.manage_table_rows')




                        </tbody>
                    </table>
                </div>
                <div class=" font-semibold tracking-wide text-gray-500 text-center border-t dark:border-gray-700 bg-gray-50 sm:grid-cols-9 dark:text-gray-400 dark:bg-gray-800">
                    {{-- <span class="flex items-center col-span-3">
                        Showing 21-30 of 100
                    </span> --}}
                    <span class="col-span-2 w-full"></span>

                    <div class="flex flex-row justify-end mt-5">
                        @if ($data->previousPageUrl() != null )
                        <a href="{{ $data->previousPageUrl()  }}" class="bg-purple-600 ml-4 hover:bg-purple-400 w-20 text-white relative  block rounded-md  p-2 focus:outline-none">
                            Previous
                        </a>
                        @endif


                          @if ($data->nextPageUrl()  != null)
                            <a href="{{ $data->nextPageUrl() }}" id="save-table-button" class="bg-purple-600 ml-3 text-white hover:bg-purple-400 w-20 relative  block rounded-md  p-2 focus:outline-none">
                                Next
                            </a>
                          @endif


                    </div>

                </div>
            </div>
        </div>
    </main>

@endsection

@section('custom-js')

    <script>
        function hideTableField(className) {

            let elements = document.getElementsByClassName(className);

            for (const element of elements) {
                if (element.classList.contains('hidden')) {
                    element.classList.remove('hidden');
                } else {
                    element.classList.add('hidden');
                }
            }
        }

        function exportData(tableName){
            fetch(`/manage/${tableName}/export`, {
                    method: 'POST',
                    headers: {
                    'Accept': 'text/csv',
                    'Content-Type': 'application/json',
                    "X-Requested-With": "XMLHttpRequest",
                    "X-CSRF-Token": document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                    body: {

                    }
                })
                .then(response => response.text())
                .then(data => {
                    let a = document.createElement('a');
                    a.href = 'data:text/csv;base64, ' +  btoa(data);
                    a.download = `${tableName}.csv`;
                    a.click();
                })
                .catch((error) => {
                    setSuccessAlert('Ooops! Something went wrong!')
                })
        }

        function deleteRow(elRowId,tableName, rowId) {
            fetch(`/manage/${tableName}/delete/${rowId}`, {
                    method: 'POST',
                    headers: {
                    'Accept': 'application/json',
                    'Content-Type': 'application/json',
                    "X-Requested-With": "XMLHttpRequest",
                    "X-CSRF-Token": document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                    body: {

                    }
                })
                .then(response => response.json())
                .then(response => {
                    console.log(response);
                    if (response.status == 'success') {
                        setSuccessAlert(response.message);
                        setTimeout(() => {
                            $(elRowId).fadeTo(2000, 0).slideUp(1000, function(){
                                $(this).remove();
                            });
                        }, 1000);
                    }
                })
                .catch(() => {
                    setSuccessAlert('Ooops! Something went wrong!')
                })
        }
    </script>

@endsection
