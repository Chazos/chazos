@foreach ($columns as $column)


                                    @if ($config_fields[$column->field_name] == true)
                                        <th class="px-4 py-3 column_{{ $column->field_name }}">{{ $column->field_name }}
                                        </th>
                                    @else
                                        <th class="px-4 py-3 hidden column_{{ $column->field_name }}">
                                            {{ $column->field_name }}</th>
                                    @endif

                                @endforeach
