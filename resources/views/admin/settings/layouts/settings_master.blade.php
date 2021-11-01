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


        <div class="lg:grid md:grid-cols-5">
            <div class="col-span-1 bg-gray-200 min-w-0 ">
                <div class="flex mt-3 ml-3">
                    <svg class="w-4 h-4 mt-1 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"></path></svg>
                    <h4 class="inline-block font-semibold text-gray-600 dark:text-gray-300">
                        General
                      </h4>
                  </div>

              <ul>
                  <li class="hover:bg-purple-300 hover:rounded-sm  hover:w-full {{ $current_link == "site_set" ? 'bg-purple-500 rounded-sm text-white' : 'text-gray-800' }} hover:text-white pl-2 w-full  py-1"><a class="text-sm" href="{{ route('admin.settings') }}">Site</a></li>
                  <li class="hover:bg-purple-300  rounded-sm hover:w-full {{ $current_link == "payment_set" ? 'bg-purple-400 rounded-sm text-white' : 'text-gray-800' }} hover:text-white pl-2 w-full py-1"><a class="text-sm"  href="{{ route('admin.settings.payments') }}">Payments</a></li>

              </ul>

              <div class="flex mt-3 ml-3">
                <svg class="w-4 h-4 mt-1 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"></path></svg>
                <h4 class="inline-block font-semibold text-gray-600 dark:text-gray-300">
                    Auth
                  </h4>
              </div>

              <ul>
                <li class="hover:bg-purple-300 rounded-sm hover:w-full {{ $current_link == "role_set" ? 'bg-purple-500 rounded-sm text-white' : 'text-gray-800' }} hover:text-white pl-2 w-full py-1"><a class="text-sm"  href="{{ route('admin.settings.roles') }}">Roles</a></li>
              </ul>

              <div class="flex mt-3 ml-3">
                <svg class="w-4 h-4 mt-1 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207"></path></svg>
                <h4 class="inline-block font-semibold text-gray-600 dark:text-gray-300">
                    Email
                  </h4>
              </div>

              <ul>
                <li class="hover:bg-purple-300 rounded-sm hover:w-full {{ $current_link == "email_set" ? 'bg-purple-500 rounded-sm text-white' : 'text-gray-800' }} hover:text-white pl-2 w-full py-1"><a class="text-sm"  href="{{ route('admin.settings.email') }}">Email settings</a></li>
                <li class="hover:bg-purple-300 rounded-sm hover:w-full {{ $current_link == "email_templates" ? 'bg-purple-500 rounded-sm text-white' : 'text-gray-800' }} hover:text-white pl-2 w-full py-1"><a class="text-sm"  href="{{ route('admin.settings.email') }}">Templates</a></li>
              </ul>

            </div>


            @yield('settings-content')

          </div>





    </div>
</main>



@endsection

@section('custom-js')

<script src="{{ asset('js/settings/save_settings.js') }}"></script>

@endsection
