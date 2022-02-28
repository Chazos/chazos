@extends('layouts.master')

@section('custom-css')

@endsection

@section('content')
    <main class="h-full pb-16 overflow-y-auto">
        <div class="container px-6 mx-auto grid">
            <h2 class="my-6 text-2xl font-semibold text-gray-700 dark:text-gray-200">
                Add a {{ $table->table_name }}
            </h2>
            <!-- CTA -->

            <div class="px-4 py-3 mb-8 bg-white rounded-lg shadow-md dark:bg-gray-800">

                <form class="new-entry" action="{{ route('admin.create_entry', ['table_name' => $table->table_name]) }}"
                    method="POST" enctype="multipart/form-data">
                    @csrf
                    @foreach ($columns as $column)
                        @if ($column->field_type == 'string')

                            @if ($column->accepts_file == 'true')
                                <label class="block text-sm mt-4">
                                    <span
                                        class="text-gray-700 dark:text-gray-400">{{ cg_unslugify($column->field_name) }}</span>
                                    <input type="file"
                                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                        name="{{ $column->field_name }}"
                                        placeholder="Your {{ ucfirst($column->field_name) }}">
                                </label>

                            @else
                                <label class="block text-sm mt-4">
                                    <span
                                        class="text-gray-700 dark:text-gray-400">{{ cg_unslugify($column->field_name) }}</span>
                                    <input type="text"
                                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                        name="{{ $column->field_name }}"
                                        placeholder="Your {{ ucfirst($column->field_name) }}">
                                </label>

                            @endif
                        @elseif ($column->field_type == 'integer')
                            <label class="block text-sm mt-4">
                                <span
                                    class="text-gray-700 dark:text-gray-400">{{ cg_unslugify($column->field_name) }}</span>
                                <input type="number"
                                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                    name="{{ $column->field_name }}"
                                    placeholder="Your {{ ucfirst($column->field_name) }}">
                            </label>



                        @elseif ($column->field_type == 'text')
                            <label class="block mt-4 text-sm">
                                <span
                                    class="text-gray-700 dark:text-gray-400 editor">{{ cg_unslugify($column->field_name) }}</span>
                                <textarea id="editor-{{ $column->field_name }}"
                                    name="{{ $column->field_name }}"></textarea>
                                {{-- <textarea class="block w-full mt-1 text-sm dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 form-textarea focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray" rows="3" name="{{ $column->field_name }}" placeholder="Your {{ ucfirst($column->field_name) }}"></textarea> --}}
                            </label>
                        @else

                            <label class="block text-sm mt-4">
                                <span
                                    class="text-gray-700 dark:text-gray-400">{{ cg_unslugify($column->field_name) }}</span>
                                <input type="text"
                                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                    name="{{ $column->field_name }}"
                                    placeholder="Your {{ ucfirst($column->field_name) }}">
                            </label>

                        @endif


                    @endforeach


                    <div class="px-6 my-6">
                        <div class="flex flex-row justify-end">
                            <button
                                class="flex items-center justify-between px-4 ml-2  py-2 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-red-600 border border-transparent rounded-lg hover:shadow  focus:outline-none focus:shadow-outline-purple">
                                Cancel
                            </button>
                            <button type="button"
                                data-route-name="{{ route('admin.create_entry', ['table_name' => $table->table_name]) }}"
                                class="add-entry-button flex items-center justify-between px-4 ml-2 py-2 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-purple-600 border border-transparent rounded-lg active:bg-purple-600 hover:bg-purple-700 focus:outline-none focus:shadow-outline-purple">
                                Save
                            </button>
                        </div>
                    </div>

                </form>


            </div>


        </div>
    </main>

@endsection

@section('custom-js')

    <script src="{{  asset('js/ckeditor/ckeditor.js') }}"></script>
    <script src="{{ asset('js/collections/add_entry.js') }}"></script>



    <script>
        window.editors = {}


        const initEditors = async () => {

            @foreach ($columns as $column)
                @if ($column->field_type == 'text')


                    editor = CKEDITOR.replace( '{{ $column->field_name }}' );

                    editors["{{ $column->field_name }}"] = editor


                    CKEDITOR.instances[`editor-{{ $column->field_name }}`].on("instanceReady", function(){
                        this.document.on("keyup", function(){
                            $('[name="{{ $column->field_name }}"]').val(CKEDITOR.instances[`editor-{{ $column->field_name }}`].getData())
                        });
                    });


                @endif
            @endforeach

        }

        (function() {
            // your page initialization code here
            // the DOM will be available here
            initEditors()
        })();
    </script>


@endsection
