@php
    $current_link = "role_set";
@endphp

@extends('admin.settings.layouts.settings_master')

@section('settings-content')
<div class="col-span-4 min-w-0 p-4 px-10 bg-white shadow-md dark:bg-gray-800">
    <h4 class="mb-4 font-semibold text-gray-600 dark:text-gray-300">
      Roles
    </h4>

    <div class="w-full overflow-x-scroll">
        <table class="w-full whitespace-no-wrap border">
          <thead>
            <tr class="text-xs font-semibold tracking-wide text-left text-gray-500 uppercase border-b dark:border-gray-700 bg-gray-50 dark:text-gray-400 dark:bg-gray-800">
              <th class="px-4 py-3">ID</th>
              <th class="px-4 py-3">Name</th>
              <th class="px-4 py-3">Guard Name</th>
              <th class="px-4 py-3">Created At</th>
              <th class="px-4 py-3">Updted At</th>
            </tr>
          </thead>
          <tbody id="role-table" class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800">

            @foreach ($roles as $role)
            <tr  class="text-gray-700 dark:text-gray-400">
                <td class="px-4 py-3 ">
                    {{  $role->id }}
                </td>
                <td class="px-4 py-3">
                    {{  $role->name }}
                </td>
                <td class="px-4 py-3">
                    {{  $role->guard_name }}


                </td>

                <td class="px-4 py-3">
                    {{  $role->created_at }}
                </td>
                <td class="px-4 py-3">
                    {{  $role->updated_at }}
                </td>
              </tr>

            @endforeach



      </tbody>
        </table>
      </div>


    <div class="mt-8 mb-4 font-semibold text-gray-600 dark:text-gray-300">Create a Role</div>
    <form method="POST" action="{{ route('admin.settings.create_role') }}">

        @csrf
        <label class="block text-sm mt-4">
            <span
                class="text-gray-700 dark:text-gray-400">Role Name</span>
            <input type="text"
                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                name="role_name"
                placeholder="Role Name">
        </label>
        <label class="block text-sm mt-4">
            <span
                class="text-gray-700 dark:text-gray-400">Guard Name</span>
            <input type="text"
                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                name="guard_name"
                value="web"
                readonly
                placeholder="Guard Name">
        </label>


        <div class="mt-5">
            <div class="flex flex-row justify-end">
                <button
                    class="flex items-center justify-between px-4 ml-2  py-2 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-red-600 border border-transparent rounded-lg hover:shadow  focus:outline-none focus:shadow-outline-purple">
                    Cancel
                </button>
                <button type="button"
                    id="create-role"
                    class="flex items-center justify-between px-4 ml-2 py-2 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-purple-600 border border-transparent rounded-lg active:bg-purple-600 hover:bg-purple-700 focus:outline-none focus:shadow-outline-purple">
                    Save
                </button>
            </div>
        </div>
    </form>


  </div>

@endsection


@section('settings-custom-js')

<script>

const appendToRoleTable = (data) => {
    $().append(`
    <tr  class="text-gray-700 dark:text-gray-400"><tr  class="text-gray-700 dark:text-gray-400">
                <td class="px-4 py-3 ">
                    ${data.id}
                </td>
                <td class="px-4 py-3">
                    ${data.role_name}
                </td>
                <td class="px-4 py-3">
                    ${data.guard_name}
                </td>
                <td class="px-4 py-3">
                    ${data.created_at}
                </td>
                <td class="px-4 py-3">
                    ${ data.updated_at }
                </td>
              </tr>

    `)


            }


$(document).ready(function () {

   $('#create-role').on('click', () => {
        let guard_name = $('[name="guard_name"]').val()
        let role_name = $('[name="role_name"]').val()

        axios({
            url: '/create-role',
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: {
                role_name: role_name,
                guard_name: guard_name
            }
        })
        .then(function (response) {
            if (response.status == 'success') {
                setSuccessAlert(response.message)
                appendToRoleTable(response.role)
            }
        })
        .catch(function (error) {
            setErrorAlert(error.message)
        });
    })
})

</script>

@endsection
