@php
    $current_link = "site_set";
@endphp


@extends('admin.settings.layouts.settings_master')


@section('settings-content')
<div class="col-span-4 min-w-0 p-4 px-10 bg-white shadow-md dark:bg-gray-800">
    <h4 class="mb-4 font-semibold text-gray-600 dark:text-gray-300">
      Site Settings
    </h4>

    <form class="save-settings-form" method="POST" action="{{ route('admin.settings.save') }}">


        @csrf
        <label class="block text-sm mt-4">
            <span
                class="text-gray-700 dark:text-gray-400">Site Name</span>
            <input type="text"
                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 border-gray-50 leading-tight focus:outline-none focus:shadow-outline focus:border-gray-200"
                name="site_name"
                value="{{ cg_get_setting('site_name') }}"
                placeholder="Site Name">
        </label>
        <label class="block text-sm mt-4">
            <span
                class="text-gray-700 dark:text-gray-400">Project Name</span>
            <input type="text"
                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 border-gray-50 leading-tight focus:outline-none focus:shadow-outline focus:border-gray-200"
                name="project_name"
                value="{{ cg_get_setting('project_name') }}"
                placeholder="Project Name">
        </label>
        <label class="block text-sm mt-4">
            <span
                class="text-gray-700 dark:text-gray-400">Site Image</span>
            <input
                type="file"
                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 border-gray-50 leading-tight focus:outline-none focus:shadow-outline focus:border-gray-200"
                name="site_image"
                placeholder="Site Image">
        </label>

        <label class="block text-sm mt-4">
            <span
                class="text-gray-700 dark:text-gray-400">Hide Builder</span>
            <select type="text"
                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 border-gray-50 leading-tight focus:outline-none focus:shadow-outline focus:border-gray-200"
                name="site_hide_builder"
                placeholder="Site Name">

                <option value="yes" {{ cg_get_setting('site_hide_builder') == "yes" ? "selected" : ""  }} >Yes</option>
                <option value="no" {{ cg_get_setting('site_hide_builder') == "no" ? "selected" : ""  }}>No</option>

            </select>
        </label>

        <label class="block text-sm mt-4">
            <span
                class="text-gray-700 dark:text-gray-400">Hide Transactions</span>
            <select type="text"
                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 border-gray-50 leading-tight focus:outline-none focus:shadow-outline focus:border-gray-200"
                name="site_hide_transactions"
                placeholder="Hide your transactions">

                <option value="yes" {{ cg_get_setting('site_hide_transactions') == "yes" ? "selected" : ""  }} >Yes</option>
                <option value="no" {{ cg_get_setting('site_hide_transactions') == "no" ? "selected" : ""  }}>No</option>

            </select>
        </label>

        <label class="block text-sm mt-4">
            <span
                class="text-gray-700 dark:text-gray-400">Hide Plugins</span>
            <select type="text"
                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 border-gray-50 leading-tight focus:outline-none focus:shadow-outline focus:border-gray-200"
                name="site_hide_plugins"
                placeholder="Site Name">

                <option value="yes" {{ cg_get_setting('site_hide_plugins') == "yes" ? "selected" : ""  }} >Yes</option>
                <option value="no" {{ cg_get_setting('site_hide_plugins') == "no" ? "selected" : ""  }}>No</option>

            </select>
        </label>

        <div class="mt-5">
            <div class="flex flex-row justify-end">
                <button
                    class="flex items-center justify-between px-4 ml-2  py-2 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-red-600 border border-transparent rounded-lg hover:shadow  focus:outline-none focus:shadow-outline-purple">
                    Cancel
                </button>
                <button type="button"
                    data-route-name="{{ route('admin.settings.save') }}"
                    class="save-settings-button flex items-center justify-between px-4 ml-2 py-2 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-purple-600 border border-transparent rounded-lg active:bg-purple-600 hover:bg-purple-700 focus:outline-none focus:shadow-outline-purple">
                    Save
                </button>
            </div>
        </div>
    </form>


  </div>

@endsection
