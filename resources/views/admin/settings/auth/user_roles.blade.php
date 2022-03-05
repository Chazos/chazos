@php
    $current_link = "user_role";
@endphp

@extends('admin.settings.layouts.settings_master')

@section('settings-content')
<div class="col-span-4 min-w-0 p-4 px-10 bg-white shadow-md dark:bg-gray-800">
    <h4 class="mb-4 font-semibold text-gray-600 dark:text-gray-300">
      Assing Roles to Users
    </h4>

    <div class="my-5">
        <p class="font-bold text-red-400">Warning: Do not touch anything here unless you know what you are doing. Infact dont touch anything.</p>
    </div>


    <div class="mt-8 mb-4 font-semibold text-gray-600 dark:text-gray-300">Create a Role</div>
    <form method="POST" action="{{ route('admin.settings.create_role') }}">

        @csrf
        <label class="block text-sm mt-4">
            <span
                class="text-gray-700 dark:text-gray-400">User ID</span>
            <input type="number"
                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 border-gray-50 leading-tight focus:outline-none focus:shadow-outline focus:border-gray-200"
                name="user_id"
                placeholder="User Id">
        </label>
        <label class="block text-sm mt-4">
            <span
                class="text-gray-700 dark:text-gray-400">Role Name</span>
            <select
                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 border-gray-50 leading-tight focus:outline-none focus:shadow-outline focus:border-gray-200"
                name="role_name"
                value="web">
                @foreach ($roles as $role)
                    <option value="{{$role->name}}">{{$role->name}}</option>
                @endforeach
            </select>
        </label>


        <div class="mt-5">
            <div class="flex flex-row justify-end">
                <button
                    class="flex items-center justify-between px-4 ml-2  py-2 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-red-600 border border-transparent rounded-lg hover:shadow  focus:outline-none focus:shadow-outline-purple">
                    Cancel
                </button>
                <button type="button"
                onclick="assignRole()"
                    id="assign-role"
                    class="flex items-center justify-between px-4 ml-2 py-2 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-purple-600 border border-transparent rounded-lg active:bg-purple-600 hover:bg-purple-700 focus:outline-none focus:shadow-outline-purple">
                    Assign Role
                </button>
            </div>
        </div>
    </form>


  </div>

@endsection


@section('custom-js')

<script>

const assignRole = () => {
    let user_id = $('[name="user_id"]').val()
        let role_name = $('[name="role_name"]').val()

        axios({
            url: '/assign-role',
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: {
                role_name: role_name,
                user_id: user_id
            }
        })
        .then(function (response) {

        console.log(response)
            if (response.data.status == 'success') {
                setSuccessAlert(response.data.message)
            }
        })
        .catch(function (error) {
            setErrorAlert(error.message)
        });
}





</script>

@endsection
