<h6 class="mb-4 uppercase text-sm font-semibold text-gray-600 dark:text-gray-300">
    Mode
  </h6>
  <label class="block text-sm mt-4">
    <span
        class="text-gray-700 dark:text-gray-400">Mode</span>
  <div class="relative">
    <select name="PAYPAL_MODE" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 border-gray-50 leading-tight focus:outline-none focus:shadow-outline focus:border-gray-200">
      <option value="test" {{ cg_get_setting('PAYPAL_MODE') == 'test' ? 'selected' : '' }}>Test</option>
      <option value="live" {{ cg_get_setting('PAYPAL_MODE') == 'live' ? 'selected' : '' }}>Live</option>

    </select>

  </div>
</label>

<h6 class="mb-4 uppercase mt-8 text-sm font-semibold text-gray-600 dark:text-gray-300">
    Test Mode
  </h6>
<label class="block text-sm mt-4">
    <span
        class="text-gray-700 dark:text-gray-400">Client ID</span>
    <input type="text"
        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 border-gray-50 leading-tight focus:outline-none focus:shadow-outline focus:border-gray-200"
        name="PAYPAL_TEST_CLIENT_ID"
        value="{{ cg_get_setting('PAYPAL_TEST_CLIENT_ID') }}"
        placeholder="PayPal Test Client ID">
</label>
<label class="block text-sm mt-4">
    <span
        class="text-gray-700 dark:text-gray-400">Client Secret</span>
    <input type="text"
        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 border-gray-50 leading-tight focus:outline-none focus:shadow-outline focus:border-gray-200"
        name="PAYPAL_TEST_CLIENT_SECRET"
        value="{{ cg_get_setting('PAYPAL_TEST_CLIENT_SECRET') }}"
        placeholder="Paynow Test Client Secret">
</label>
<label class="block text-sm mt-4">
    <span
        class="text-gray-700 dark:text-gray-400">Email Address</span>
    <input type="text"
        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 border-gray-50 leading-tight focus:outline-none focus:shadow-outline focus:border-gray-200"
        name="PAYPAL_TEST_EMAIL_ADDRESS"
        value="{{ cg_get_setting('PAYPAL_TEST_EMAIL_ADDRESS') }}"
        placeholder="Paynow Test Email Address">
</label>
<h6 class="mb-4 uppercase mt-8 text-sm font-semibold text-gray-600 dark:text-gray-300">
    Live Mode
  </h6>
<label class="block text-sm mt-4">
    <span
        class="text-gray-700 dark:text-gray-400">Client ID</span>
    <input type="text"
        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 border-gray-50 leading-tight focus:outline-none focus:shadow-outline focus:border-gray-200"
        name="PAYPAL_LIVE_CLIENT_ID"
        value="{{ cg_get_setting('PAYPAL_LIVE_CLIENT_ID') }}"
        placeholder="PayPal Live Client ID">
</label>
<label class="block text-sm mt-4">
    <span
        class="text-gray-700 dark:text-gray-400">Client Secret</span>
    <input type="text"
        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 border-gray-50 leading-tight focus:outline-none focus:shadow-outline focus:border-gray-200"
        name="PAYPAL_LIVE_CLIENT_SECRET"
        value="{{ cg_get_setting('PAYPAL_LIVE_CLIENT_SECRET') }}"
        placeholder="Paynow Live Client Secret">
</label>
<label class="block text-sm mt-4">
    <span
        class="text-gray-700 dark:text-gray-400">Email Address</span>
    <input type="text"
        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 border-gray-50 leading-tight focus:outline-none focus:shadow-outline focus:border-gray-200"
        name="PAYPAL_LIVE_EMAIL_ADDRESS"
        value="{{ cg_get_setting('PAYPAL_LIVE_EMAIL_ADDRESS') }}"
        placeholder="Paynow Live Email Address">
</label>
