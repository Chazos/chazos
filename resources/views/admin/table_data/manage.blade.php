@extends('layouts.master')

@section('content') < main class = "h-full pb-16 overflow-y-auto" > <div class="container grid px-6 mx-auto">
    <h2 class="my-6 text-2xl font-semibold text-gray-700 dark:text-gray-200">
        {{
            ucfirst($table - > table_name)
        }}
    </h2>

    <div class="relative w-20 mr-6 focus-within:text-purple-500">
        <input
            style="width: 240%"
            onkeyup="filterTable(this.value)"
            class=" pr-2 text-sm text-gray-700 placeholder-gray-600 bg-gray-100 border-0 rounded-md  dark:focus:shadow-outline-gray dark:focus:placeholder-gray-600 dark:bg-gray-700 dark:text-gray-200 focus:placeholder-gray-500 focus:bg-white focus:border-purple-300 focus:outline-none focus:shadow-outline-purple form-input"
            type="text"
            placeholder="Search for projects"
            aria-label="Search"></div>

        <div class="flex justify-end py-3">

            <a
                href="javascript:void(0)"
                onclick="exportData('{{ $table->table_name }}')"
                class="bg-purple-600 px-3 h-10 text-white ml-2 hover:bg-purple-400 relative z-10 block rounded-md  p-2 focus:outline-none">
                <svg
                    class="w-6 h-6 mx-1 inline-block"
                    fill="none"
                    stroke="currentColor"
                    viewBox="0 0 24 24"
                    xmlns="http://www.w3.org/2000/svg">
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path>
                </svg>
                Export
            </a>
            <button
                x-on:click="toggleImportDataModal"
                class="bg-purple-600 px-3 h-10 text-white ml-2 hover:bg-purple-400 relative z-10 block rounded-md  p-2 focus:outline-none">
                <svg
                    class="w-6 h-6 mx-1 inline-block"
                    fill="none"
                    stroke="currentColor"
                    viewBox="0 0 24 24"
                    xmlns="http://www.w3.org/2000/svg">
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
                </svg>
                Import
            </button>
            <a
                href={{
                route('admin.add_entry', ['table_name' => $table - > table_name])
            }}
                class="bg-purple-600 px-3 h-10 mx-3 text-white ml-2 hover:bg-purple-400 relative z-10 block rounded-md  p-2 focus:outline-none">
                <svg
                    class="w-6 h-6 mx-1 inline-block"
                    fill="none"
                    stroke="currentColor"
                    viewBox="0 0 24 24"
                    xmlns="http://www.w3.org/2000/svg">
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="M9 13h6m-3-3v6m5 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                </svg>
                New Entry
            </a>
            <div x-data={dropdownOpen : false} class="relative">

                <button
                    @click="dropdownOpen = !dropdownOpen"
                    class="relative z-10 block rounded-md bg-purple-600 p-2 focus:outline-none">
                    <div class="flex flex-row">
                        <svg
                            class="w-6 h-6 text-white"
                            fill="none"
                            stroke="currentColor"
                            viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg">
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                        </svg>

                        <div class="mx-1 text-white">
                            Show/Hide Fields</div>

                        <svg
                            class="h-5 w-5 text-white"
                            xmlns="http://www.w3.org/2000/svg"
                            viewBox="0 0 20 20"
                            fill="currentColor">
                            <path
                                fill-rule="evenodd"
                                d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                clip-rule="evenodd"/>
                        </svg>
                    </div>
                </button>

                <div
                    x-show="dropdownOpen"
                    @click="dropdownOpen = false"
                    class="fixed inset-0 h-full w-full z-10"></div>

                <div
                    x-show="dropdownOpen"
                    class="absolute right-0 mt-2 py-2 w-64 bg-white rounded-md shadow-xl z-20">

                    <p class="font-bold ml-4">Show/Hide fields</p>
                    @foreach ($columns as $column) @if ($config_fields[$column->field_name] == true)
                    <a
                        href="#"
                        class="block px-4 py-2 text-sm capitalize text-gray-700 hover:bg-blue-500 hover:text-white">
                        <input
                            checked
                            onchange="hideTableField('column_{{ $column->field_name }}')"
                            type="checkbox"
                            name=""
                            id="checkbox-hide-field">
                            <span class="ml-3">{{
                                    $column - > field_name
                                }}</span>
                        </a>
                        @else
                        <a
                            href="#"
                            class="block px-4 py-2 text-sm capitalize text-gray-700 hover:bg-blue-500 hover:text-white">
                            <input
                                onchange="hideTableField('column_{{ $column->field_name }}')"
                                type="checkbox"
                                name=""
                                id="checkbox-hide-field">
                                <span class="ml-3">{{
                                        $column - > field_name
                                    }}</span>
                            </a>

                            @endif @endforeach

                        </div>
                    </div>
                </div>

                <div class="w-full overflow-hidden rounded-lg shadow-xs">
                    <div class="w-full overflow-x-auto">
                        <table class="w-full whitespace-no-wrap">
                            <thead>
                                <tr
                                    class="text-xs font-semibold tracking-wide text-left text-gray-500 uppercase border-b dark:border-gray-700 bg-gray-50 dark:text-gray-400 dark:bg-gray-800">

                                    <th class="px-4 py-3"></th>
                                    @include('admin.table_data.includes.manage_table_header')
                                    <th class="px-4 py-3">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800">

                                @include('admin.table_data.includes.manage_table_rows')

                            </tbody>

                        </table>
                    </div>

                    <div
                        class=" font-semibold tracking-wide text-gray-500 text-center border-t dark:border-gray-700 bg-gray-50 sm:grid-cols-9 dark:text-gray-400 dark:bg-gray-800">
                        {{
                            -- <span class="flex items-center col-span-3">
                                Showing 21-30 of 100
                            </span>--
                        }}

                        <div class="flex items-center space-x-4 text-sm ml-4 mt-3">
                            <input id="check-all-box" type="checkbox" onclick="checkOnAllCheckbox()">
                                <span class="ml-2">Check All</span>
                                <span class="w-10"></span>
                                <span>With Selected:
                                </span>
                                <button
                                    onclick="deleteMultiple('{{ $table->table_name }}')"
                                    class="flex items-center justify-between px-2 py-2 text-sm font-medium leading-5 text-purple-600 rounded-lg dark:text-gray-400 focus:outline-none focus:shadow-outline-gray"
                                    aria-label="Delete">
                                    <svg class="w-5 h-5" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20">
                                        <path
                                            fill-rule="evenodd"
                                            d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z"
                                            clip-rule="evenodd"></path>
                                    </svg>
                                </button>
                            </div>
                            <span class="col-span-2 w-full"></span>

                            <div class="flex flex-row justify-end mt-5">
                                @if ($data->previousPageUrl() != null)
                                <a
                                    href={{
                                    $data - > previousPageUrl()
                                }}
                                    class="bg-purple-600 ml-4 hover:bg-purple-400 w-20 text-white relative  block rounded-md  p-2 focus:outline-none">
                                    Previous
                                </a>
                                @endif @if ($data->nextPageUrl() != null)
                                <a
                                    href={{
                                    $data - > nextPageUrl()
                                }}
                                    id="save-table-button"
                                    class="bg-purple-600 ml-3 text-white hover:bg-purple-400 w-20 relative  block rounded-md  p-2 focus:outline-none">
                                    Next
                                </a>
                                @endif

                            </div>

                        </div>
                    </div>
                </div>
            </main>

            @include('admin.modals.manage_table') @endsection @section('custom-js')

            <script>
                const triggerCustomAction = (rowId, destination) => {

                    axios.post(destination, {}, {
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            }
                        })
                        .then(function (response) {
                            if (response.data.status == 'success') {
                                setSuccessAlert(response.data.message)
                                window
                                    .location
                                    .reload()
                            } else if (response.data.status == 'failed') {
                                setErrorAlert(response.data.message)
                            }
                        })
                        .catch(function (error) {
                            setErrorAlert(error.toString())
                        });

                }

                function hideTableField(className) {

                    let elements = document.getElementsByClassName(className);

                    for (const element of elements) {
                        if (element.classList.contains('hidden')) {
                            element
                                .classList
                                .remove('hidden');
                        } else {
                            element
                                .classList
                                .add('hidden');
                        }
                    }
                }

                function filterTable(value) {
                    let rows = document.querySelectorAll('tbody tr');

                    for (const row of rows) {
                        if (row.innerText.toLowerCase().includes(value.toLowerCase())) {
                            row
                                .classList
                                .remove('hidden');
                        } else {
                            row
                                .classList
                                .add('hidden');
                        }
                    }
                }

                function exportData(tableName) {
                    fetch(`/manage/${tableName}/export`, {
                        method: 'POST',
                        headers: {
                            'Accept': 'text/csv',
                            'Content-Type': 'application/json',
                            "X-Requested-With": "XMLHttpRequest",
                            "X-CSRF-Token": document
                                .querySelector('meta[name="csrf-token"]')
                                .getAttribute('content')
                        },
                            body: {}
                        })
                        .then(response => response.text())
                        .then(data => {
                            let a = document.createElement('a');
                            a.href = 'data:text/csv;base64, ' + btoa(data);
                            a.download = `${tableName}.csv`;
                            a.click();
                        })
                        .catch((error) => {
                            setSuccessAlert('Ooops! Something went wrong!')
                        })
                }

                function checkOnAllCheckbox() {
                    let checkboxes = document.querySelectorAll('input.table-data-check');

                    for (const checkbox of checkboxes) {
                        if (checkbox.checked == false) {
                            checkbox.click()
                        } else {
                            checkbox.click()
                            checkbox.click()
                        }
                    }

                    document
                        .querySelector('#check-all-box')
                        .setAttribute('onclick', 'checkOffAllCheckbox()');

                }

                function checkOffAllCheckbox() {
                    let checkboxes = document.querySelectorAll('input.table-data-check');

                    for (const checkbox of checkboxes) {
                        if (checkbox.checked == true) {
                            checkbox.click()
                        } else {
                            checkbox.click()
                            checkbox.click()
                        }
                    }

                    document
                        .querySelector('#check-all-box')
                        .setAttribute('onclick', 'checkOnAllCheckbox()');
                }

                function onCheckboxChecked(element, id) {

                    checkedData = localStorage.getItem('checkedData');

                    if (checkedData == null) {
                        checkedData = [];
                    } else {
                        checkedData = JSON.parse(checkedData);
                    }

                    if (element.checked == true) {
                        if (checkedData.includes(id) == false) {
                            checkedData.push(id);
                        }
                    } else {
                        let index = checkedData.indexOf(id);

                        if (index > -1) {
                            checkedData.splice(index, 1);
                        }
                    }

                    localStorage.setItem('checkedData', JSON.stringify(checkedData));

                }

                function deleteMultiple(tableName) {
                    let checkedData = localStorage.getItem('checkedData');

                    if (checkedData == null) {
                        setSuccessAlert('Please select at least one row!')
                        return;
                    } else {
                        checkedData = JSON.parse(checkedData);

                        for (const id of checkedData) {
                            deleteRow(`#row-${id}`, tableName, id);
                        }
                    }
                }

                function deleteRow(elRowId, tableName, rowId) {
                    fetch(`/manage/${tableName}/delete/${rowId}`, {
                        method: 'POST',
                        headers: {
                            'Accept': 'application/json',
                            'Content-Type': 'application/json',
                            "X-Requested-With": "XMLHttpRequest",
                            "X-CSRF-Token": document
                                .querySelector('meta[name="csrf-token"]')
                                .getAttribute('content')
                        },
                            body: {}
                        })
                        .then(response => response.json())
                        .then(response => {
                            console.log(response);
                            if (response.status == 'success') {
                                setSuccessAlert(response.message);
                                setTimeout(() => {
                                    $(elRowId)
                                        .fadeTo(2000, 0)
                                        .slideUp(1000, function () {
                                            $(this).remove();
                                        });
                                }, 1000);
                            }
                        })
                        .catch(() => {
                            setSuccessAlert('Ooops! Something went wrong!')
                        })
                }

                $('#import-data-button').on('click', (event) => {
                    let destination = $(event.target).attr('data-route-name')
                    let form = $('.import-data-form')
                    let formData = new FormData(form[0])

                    axios
                        .post(destination, formData, {
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            }
                        })
                        .then(function (response) {
                            if (response.data.status == 'success') {
                                setSuccessAlert(response.data.message)
                                window
                                    .location
                                    .reload()
                            }
                        })
                        .catch(function (error) {
                            setErrorAlert(error.toString())
                        });
                })
            </script>
