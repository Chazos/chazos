@extends('layouts.master')

@section('custom-css')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.min.css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.min.js" defer></script>
    {{-- <script src="{{ asset('/js/charts-lines.js') }}" defer></script>
    <script src="{{ asset('/js/charts-pie.js') }}" defer></script> --}}
@endsection

@section('content')
<main class=" overflow-y-auto">
    <div class="container  mx-auto grid">
        <h2 class="my-6 px-6 text-2xl font-semibold text-gray-700 dark:text-gray-200">
            Settings
        </h2>

        <div class="grid gap-6 md:grid-cols-5">
            <div class="col-span-1 min-w-0 p-4 bg-white shadow-md dark:bg-gray-800">
              <h4 class="mb-4 font-semibold text-gray-600 dark:text-gray-300">
                General
              </h4>

              <ul>
                  <li><a class="hover:bg-purple-500 hover:underline hover:text-white pl-2 w-fullmy-5" href="#">Site</a></li>
                  <li><a class="hover:bg-purple-500 hover:underline hover:text-white pl-2 w-fullmy-5" href="#">Colors</a></li>

              </ul>

              <h4 class="mb-4 mt-5 font-semibold text-gray-600 dark:text-gray-300">
                Auth
              </h4>

              <ul>
                <li class="w-full"><a class="hover:bg-purple-500 hover:underline hover:text-white pl-2 w-fullmy-5" href="{{ route('admin.settings.roles') }}">Roles</a></li>
              </ul>

              <h4 class="mb-4 mt-5 font-semibold text-gray-600 dark:text-gray-300">
                Email
              </h4>

              <ul>
                <li class="w-full"><a class="hover:bg-purple-500 hover:underline hover:text-white pl-2 w-fullmy-5" href="#">Email settings</a></li>
                <li class="w-full"><a class="hover:bg-purple-500 hover:underline hover:text-white pl-2 w-fullmy-5" href="#">Templates</a></li>
              </ul>

            </div>


            @yield('settings-content')

          </div>





    </div>
</main>



@endsection

@section('custom-js')

<script src="{{ asset('js/settings/save_settings.js') }}"></script>

@yield('settings-custom-js')

@endsection
