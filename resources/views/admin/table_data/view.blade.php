@extends('layouts.master')

@section('custom-css')

@endsection

@section('content')
    <main class="h-full pb-16 overflow-y-auto">
        <div class="container px-6 mx-auto grid">
            <h2 class="mt-6 text-2xl font-semibold text-gray-700 dark:text-gray-200">
                Item Details
            </h2>
            <!-- CTA -->

            <div x-data="{tableDataOptionsDropdown: false}" class="relative inline-block ml-auto">
                <!-- Dropdown toggle button -->
                <button x-on:click="tableDataOptionsDropdown = !tableDataOptionsDropdown"
                    class="flex my-3 shadow-sm relative z-10 block p-2 text-white hover:bg-purple-600 hover:shadow-lg bg-purple-500 border border-transparent rounded-md dark:text-white focus:border-blue-500 focus:ring-opacity-40 dark:focus:ring-opacity-40 focus:ring-blue-300 dark:focus:ring-blue-400 focus:ring dark:bg-gray-800 focus:outline-none">

                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>


                    Actions

                </button>

                <!-- Dropdown menu -->
                <div x-show="tableDataOptionsDropdown" @click.away="tableDataOptionsDropdown = false"
                    class="absolute right-0 z-20 w-48 py-2 mt-2 bg-white rounded-md shadow-xl dark:bg-gray-800">
                    @foreach ($actions as $action)

                        @php
                            $action_url = route('admin.actions.create', ['table' => $table->table_name, 'id' => $item->id, 'action' => $action->identifier]);
                            $row_id = "#row-$item->id";
                        @endphp




                        <button onclick="triggerCustomAction('{{ $row_id }}', '{{ $action_url }}')"
                            class="flex w-full items-center p-3 text-sm text-gray-600 capitalize transition-colors duration-200 transform dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 dark:hover:text-white">
                            {!! $action->svg_icon !!}

                            <span class="mx-1">
                                {{ $action->display_name }}
                            </span>
                        </button>

                    @endforeach



                    <hr class="border-gray-200 dark:border-gray-700 ">
                    <a
                        href="{{ route('admin.view_item', ['table_name' => $table->table_name, 'id' => $item->id]) }}"
                        class="flex w-full items-center p-3 text-sm text-gray-600 capitalize transition-colors duration-200 transform dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 dark:hover:text-white">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>

                        <span class="mx-1">
                            View
                        </span>
                    </a>
                    <a
                        href="{{ route('admin.edit_item', ['table_name' => $table->table_name, 'id' => $item->id]) }}"
                        class="flex w-full items-center p-3 text-sm text-gray-600 capitalize transition-colors duration-200 transform dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 dark:hover:text-white">
                        <svg class="w-5 h-5" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20">
                            <path
                                d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z">
                            </path>
                        </svg>

                        <span class="mx-1">
                            Edit
                        </span>
                    </a>
                    <button id="modify-table-perms-btn"
                        onclick="deleteRow('#row-{{ $item->id }}','{{ $table->table_name }}', {{ $item->id }})"
                        class="flex w-full items-center px-3 py-3 text-sm text-gray-600 capitalize transition-colors duration-200 transform dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 dark:hover:text-white">
                        <svg class="w-5 h-5" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z"
                                clip-rule="evenodd"></path>
                        </svg>

                        <span class="mx-1">
                            Delete
                        </span>
                    </button>



                </div>
            </div>

            <div class="px-4 py-3 mb-8 bg-white rounded-lg shadow-md dark:bg-gray-800">



                <table class="w-full whitespace-no-wrap border">
                    <thead>
                      <tr class="text-xs font-semibold tracking-wide text-left text-gray-500 uppercase border-b dark:border-gray-700 bg-gray-50 dark:text-gray-400 dark:bg-gray-800">
                        <th class="px-4 py-3">Field</th>
                        <th class="px-4 py-3">Value</th>

                      </tr>
                    </thead>
                    <tbody class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800">
                    @csrf
                    @foreach ($fields as $field)

                        @php
                            $field_value = $item->toArray()[$field->field_name];
                        @endphp

<tr class="text-gray-700 dark:text-gray-400">

    <td class="px-4 py-3 text-sm">
      {{ $field->field_name }}
    </td>
    <td class="px-4 py-3 text-sm">
      {{ $field_value }}
    </td>
  </tr>

                    @endforeach

                </tbody>
            </table>






            </div>


        </div>
    </main>

@endsection

@section('custom-js')
    <script src="{{ asset("js/table_data/table_data.js") }}"></script>
@endsection
