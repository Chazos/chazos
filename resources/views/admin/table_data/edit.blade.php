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

     <form class="edit-entry" action="{{ route('admin.update_item', ['table_name' => $table->table_name, 'id' => $item->id]) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @foreach ($fields as $field)

            @php
                $field_value = $item->toArray()[$field->field_name];
            @endphp

            @if ($field->field_type == 'string')






                @if ($field->accepts_file == "true")
                <label class="block text-sm mt-4">
                    <span class="text-gray-700 dark:text-gray-400">{{ cg_unslugify($field->field_name) }}</span>
                    <input type="file" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" name="{{ $field->field_name }}" placeholder="Your {{ ucfirst($field->field_name) }}">
                  </label>

                @else
                <label class="block text-sm mt-4">
                    <span class="text-gray-700 dark:text-gray-400">{{ cg_unslugify($field->field_name) }}</span>
                    <input type="text" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" name="{{ $field->field_name }}" value="{{ $field_value }}" placeholder="Your {{ ucfirst($field->field_name) }}">
                  </label>

                @endif

            @endif

            @if ($field->field_type == 'integer')
            <label class="block text-sm mt-4">
                <span class="text-gray-700 dark:text-gray-400">{{ cg_unslugify($field->field_name) }}</span>
                <input type="number" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" name="{{ $field->field_name }}" value="{{ $field_value }}" placeholder="Your {{ ucfirst($field->field_name) }}">
              </label>
            @endif

            @if ($field->field_type == 'text')
            <label class="block mt-4 text-sm">
                <span class="text-gray-700 dark:text-gray-400 editor">{{ cg_unslugify($field->field_name) }}</span>
                <textarea rows="5" class="block w-full mt-1 text-sm dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 form-textarea focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray" id="editor-{{ $field->field_name }}" name="{{ $field->field_name }}">
                    {{ $field_value }}
                </textarea>
              </label>
            @endif
        @endforeach


        <div class="px-6 my-6">
            <div class="flex flex-row justify-end">
                <button class="flex items-center justify-between px-4 ml-2  py-2 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-red-600 border border-transparent rounded-lg hover:shadow  focus:outline-none focus:shadow-outline-purple">
                    Cancel
                </button>
                <button

                data-route-name="{{ route('admin.update_item', ['table_name' => $table->table_name, 'id' => $item->id]) }}"
                type="button" class=" edit-entry-button flex items-center justify-between px-4 ml-2 py-2 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-purple-600 border border-transparent rounded-lg active:bg-purple-600 hover:bg-purple-700 focus:outline-none focus:shadow-outline-purple">
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

<script src="https://cdn.ckeditor.com/4.16.2/standard/ckeditor.js"></script>
<script src="{{ asset('js/collections/edit_entry.js')  }}"></script>



<script>


window.editors = {}


const initEditors = async () => {

    @foreach ($fields as $field)
        @if ($field->field_type == 'text')


            editor = CKEDITOR.replace( '{{ $field->field_name }}' );

            editors["{{ $field->field_name}}"] = editor

            CKEDITOR.instances[`editor-{{ $field->field_name }}`].on("instanceReady", function(){
                        this.document.on("keyup", function(){
                            $('[name="{{ $field->field_name }}"]').val(CKEDITOR.instances[`editor-{{ $field->field_name }}`].getData())
                        });
                    });


        @endif
    @endforeach

}


(function(){
    initEditors()
})()



</script>


@endsection

