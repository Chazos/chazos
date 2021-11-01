@php
    $current_link = "payment_set";
@endphp


@extends('admin.settings.layouts.settings_master')


@section('settings-content')
<div class="col-span-4 min-w-0 p-4 px-10 bg-white shadow-md dark:bg-gray-800">
    <h4 class="mb-4 font-semibold text-gray-600 dark:text-gray-300">
        Payment Settings
      </h4>

    <form class="save-payment-settings" method="POST" action="{{ route('admin.settings.save') }}">

        @csrf

        <div class="rounded  w-full mx-auto mt-4">
            <!-- Tabs -->
            <ul id="tabs" class="inline-flex pt-2 px-1 w-full border-b">
              <li class="bg-white px-4 text-gray-800 font-semibold py-2 rounded-t border-t border-r border-l -mb-px"><a id="default-tab" href="#first">PayPal</a></li>
              <li class="px-4 text-gray-800 font-semibold py-2 rounded-t"><a href="#second">Stripe</a></li>
              <li class="px-4 text-gray-800 font-semibold py-2 rounded-t"><a href="#third">Paynow</a></li>

            </ul>

            <!-- Tab Contents -->
            <div id="tab-contents">
              <div id="first" class="p-4">
                @include('admin.settings.payments.includes.paypal_settings')
              </div>
              <div id="second" class="hidden p-4">
                @include('admin.settings.payments.includes.stripe_settings')
              </div>
              <div id="third" class="hidden p-4">
                @include('admin.settings.payments.includes.paynow_settings')
              </div>

            </div>
          </div>











        <div class="mt-5">
            <div class="flex flex-row justify-end">
                <button
                    class="flex items-center justify-between px-4 ml-2  py-2 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-red-600 border border-transparent rounded-lg hover:shadow  focus:outline-none focus:shadow-outline-purple">
                    Cancel
                </button>
                <button type="button"
                    id="save-settings-button"
                    data-route-name="{{ route('admin.settings.save') }}"
                    class="flex items-center justify-between px-4 ml-2 py-2 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-purple-600 border border-transparent rounded-lg active:bg-purple-600 hover:bg-purple-700 focus:outline-none focus:shadow-outline-purple">
                    Save
                </button>
            </div>
        </div>
    </form>


  </div>

@endsection

@section('custom-js')

<script>
    $('#save-settings-button').on('click', (event) => {
    let destination = $(event.target).attr('data-route-name')
    let form = $('.save-payment-settings')
    let formData = new FormData(form[0])

        axios.post(destination, formData, {
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            }
      })
      .then(function (response) {
         if (response.data.status == 'success'){
            setSuccessAlert(response.data.message)
         }
      })
      .catch(function (error) {
           setErrorAlert(error.toString())
      });
})
</script>

<script>
let tabsContainer = document.querySelector("#tabs");
let tabTogglers = tabsContainer.querySelectorAll("#tabs a");

// console.log(tabTogglers);

tabTogglers.forEach(function(toggler) {
  toggler.addEventListener("click", function(e) {
    e.preventDefault();

    let tabName = this.getAttribute("href");

    let tabContents = document.querySelector("#tab-contents");

    for (let i = 0; i < tabContents.children.length; i++) {

      tabTogglers[i].parentElement.classList.remove("border-t", "border-r", "border-l", "-mb-px", "bg-white");  tabContents.children[i].classList.remove("hidden");
      if ("#" + tabContents.children[i].id === tabName) {
        continue;
      }
      tabContents.children[i].classList.add("hidden");

    }
    e.target.parentElement.classList.add("border-t", "border-r", "border-l", "-mb-px", "bg-white");
  });
});

</script>

@endsection


