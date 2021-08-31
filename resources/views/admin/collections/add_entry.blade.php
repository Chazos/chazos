@extends('layouts.master')

@section('custom-css')

@endsection

@section('content')
<main class="h-full pb-16 overflow-y-auto">
    <div class="container px-6 mx-auto grid">
      <h2 class="my-6 text-2xl font-semibold text-gray-700 dark:text-gray-200">
        Add a {{ $table }}
      </h2>
      <!-- CTA -->

      <div class="px-4 py-3 mb-8 bg-white rounded-lg shadow-md dark:bg-gray-800">

        @csrf
        @foreach ($columns as $column)
            @if ($column->field_type == 'string')




                @if ($column->accepts_file == "true")
                <label class="block text-sm mt-4">
                    <span class="text-gray-700 dark:text-gray-400">{{ unslugify($column->field_name) }}</span>
                    <input type="file" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" name="{{ $column->field_name }}" placeholder="Your {{ ucfirst($column->field_name) }}">
                  </label>

                @else
                <label class="block text-sm mt-4">
                    <span class="text-gray-700 dark:text-gray-400">{{ unslugify($column->field_name) }}</span>
                    <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" name="{{ $column->field_name }}" placeholder="Your {{ ucfirst($column->field_name) }}">
                  </label>

                @endif

            @endif

            @if ($column->field_type == 'integer')
            <label class="block text-sm mt-4">
                <span class="text-gray-700 dark:text-gray-400">{{ unslugify($column->field_name) }}</span>
                <input type="number" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" name="{{ $column->field_name }}" placeholder="Your {{ ucfirst($column->field_name) }}">
              </label>
            @endif

            @if ($column->field_type == 'text')
            <label class="block mt-4 text-sm">
                <span class="text-gray-700 dark:text-gray-400 editor">{{ unslugify($column->field_name) }}</span>
                <textarea id="editor-{{ $column->field_name }}" name="{{ $column->field_name }}"></textarea>
                {{-- <textarea class="block w-full mt-1 text-sm dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 form-textarea focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray" rows="3" name="{{ $column->field_name }}" placeholder="Your {{ ucfirst($column->field_name) }}"></textarea> --}}
              </label>
            @endif
        @endforeach


        <div class="px-6 my-6">
            <div class="flex flex-row justify-end">
                <button class="flex items-center justify-between px-4 ml-2  py-2 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-red-600 border border-transparent rounded-lg hover:shadow  focus:outline-none focus:shadow-outline-purple">
                    Cancel
                </button>
                <button x-on:click="saveEntry()" class="flex items-center justify-between px-4 ml-2 py-2 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-purple-600 border border-transparent rounded-lg active:bg-purple-600 hover:bg-purple-700 focus:outline-none focus:shadow-outline-purple">
                    Save
                </button>
            </div>
        </div>



      </div>


    </div>
  </main>

@endsection

@section('custom-js')

<script src="https://cdn.ckeditor.com/4.16.2/standard/ckeditor.js"></script>
<script>
    window.editors = {}
</script>
<script>
const initEditors = async () => {

    @foreach ($columns as $column)
        @if ($column->field_type == 'text')


            editor = CKEDITOR.replace( '{{ $column->field_name }}' );

            editors["{{ $column->field_name}}"] = editor


        @endif
    @endforeach

}

</script>



<script>

    document.addEventListener('DOMContentLoaded', () => {

        initEditors()
        fetch('/content-types/{{ $table }}/fields')
    .then(response => response.json())
    .then(data => {
        if (data.status == "success"){
            let fields = data.fields
            localStorage.setItem('currentTableFields', JSON.stringify(fields))
        }
    })
    .catch(error => console.error(error));
    })



    const saveEntry = () => {
        let fields = JSON.parse(localStorage.getItem('currentTableFields'))
        let formData = new FormData()

        fields.forEach(field => {
            if (field.field_type == 'string'){
                if (field.accept_file == "true"){
                    formData.append(field.field_name, document.querySelector('input[name="'+field.field_name+'"]').files[0])
                } else {
                    formData.append(field.field_name, document.querySelector('[name="' + field.field_name + '"]').value)
                }
            }
            if (field.field_type == 'integer'){
                formData.append(field.field_name, document.querySelector('[name="' + field.field_name + '"]').value)
            }
            if (field.field_type == 'text'){
                formData.append(field.field_name, CKEDITOR.instances['editor-' + field.field_name].getData())
            }
        })

        fetch('/content-types/{{ $table }}/create', {
            method: 'POST',
            headers: {

                    "X-CSRF-Token": document.querySelector("meta[name='csrf-token']").getAttribute('content')
                },
            body: formData
        })
    }


</script>








@endsection

