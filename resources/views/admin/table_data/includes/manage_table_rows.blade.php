@foreach ($data as $item)
    <tr class="text-gray-700 dark:text-gray-400" id="row-{{ $item->id }}">

        <td class="px-4 py-3">
            <div class="flex items-center space-x-4 text-sm">
                <input class="table-data-check" type="checkbox" onclick="onCheckboxChecked(this, {{ $item->id }})">
            </div>
        </td>

        @foreach ($columns as $column)

            @if ($config_fields[$column->field_name] == true)
                @include('admin.table_data.includes.table_field_shown')
            @else
                @include('admin.table_data.includes.table_field_hidden')
            @endif


        @endforeach
        <td class="px-4 py-3">

            <div x-data="{tableDataOptionsDropdown: false}" class="flex items-center justify-center">
                <div class="relative inline-block">
                    <!-- Dropdown toggle button -->
                    <button x-on:click="tableDataOptionsDropdown = !tableDataOptionsDropdown"
                        class="shadow-sm relative z-10 block p-2 text-white hover:bg-purple-600 hover:shadow-lg bg-purple-500 border border-transparent rounded-md dark:text-white focus:border-blue-500 focus:ring-opacity-40 dark:focus:ring-opacity-40 focus:ring-blue-300 dark:focus:ring-blue-400 focus:ring dark:bg-gray-800 focus:outline-none">
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


            </div>
        </td>
    </tr>

@endforeach
