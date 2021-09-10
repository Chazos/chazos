@extends('layouts.master')

@section('custom-css')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.min.css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.min.js" defer></script>
    {{-- <script src="{{ asset('/js/charts-lines.js') }}" defer></script>
    <script src="{{ asset('/js/charts-pie.js') }}" defer></script> --}}
@endsection

@section('content')
<main class=" overflow-y-auto h-full">
    <div class="mx-auto grid h-full">


        <div class="lg:grid gap-6 md:grid-cols-5 ">
            <div class="col-span-1 bg-gray-200 min-w-0 p-4 ">
              <h4 class="mb-4 font-semibold text-gray-600 dark:text-gray-300">
                General
              </h4>

              <ul>
                  <li class="hover:bg-purple-500 hover:w-full {{ $current_link == "site_set" ? 'bg-purple-500' : '' }} hover:text-white pl-2 w-full my-5 py-2"><a href="{{ route('admin.settings') }}">Site</a></li>

              </ul>

              <h4 class="mb-4 mt-5 font-semibold text-gray-600 dark:text-gray-300">
                Auth
              </h4>

              <ul>
                <li class="hover:bg-purple-500 hover:w-full {{ $current_link == "role_set" ? 'bg-purple-500' : '' }} hover:text-white pl-2 w-full my-5 py-2"><a class="" href="{{ route('admin.settings.roles') }}">Roles</a></li>
              </ul>

              <h4 class="mb-4 mt-5 font-semibold text-gray-600 dark:text-gray-300">
                Email
              </h4>

              <ul>
                <li class="hover:bg-purple-500 hover:w-full {{ $current_link == "email_set" ? 'bg-purple-500' : '' }} hover:text-white pl-2 w-full my-5 py-2"><a class="hover:bg-purple-500 hover:underline hover:text-white pl-2 w-fullmy-5" href="#">Email settings</a></li>
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
