@if ($column->accepts_file == 'true')
                    @if ($column->file_type == 'image')

                        <td class="px-4 py-3 hidden text-sm  column_{{ $column->field_name }}">
                            <img src="{{ $item->getFirstMediaUrl('avatar', 'thumb') }}" alt="" class="w-20">
                        </td>

                    @else
                        <td class="px-4 py-3 hidden text-sm column_{{ $column->field_name }}">
                            {{ $item[$column->field_name] }}
                        </td>
                    @endif

                @else

                    <td class="px-4 py-3 text-sm hidden column_{{ $column->field_name }}">
                        {{ $item[$column->field_name] }}
                    </td>

                @endif
