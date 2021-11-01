<h6 class="mb-4 uppercase text-sm font-semibold text-gray-600 dark:text-gray-300">
    Mode
  </h6>
  <label class="block text-sm mt-4">
    <span
        class="text-gray-700 dark:text-gray-400">Mode</span>
  <div class="relative">
    <select name="STRIPE_MODE" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 border-gray-50 leading-tight focus:outline-none focus:shadow-outline focus:border-gray-200">
      <option value="test" {{ cg_get_setting('STRIPE_MODE') == 'test' ? 'selected' : '' }}>Test</option>
      <option value="live" {{ cg_get_setting('STRIPE_MODE') == 'live' ? 'selected' : '' }}>Live</option>

    </select>

  </div>
</label>
<h6 class="mb-4 text-sm mt-8 uppercase font-semibold text-gray-600 dark:text-gray-300">
    Test Mode
  </h6>
<label class="block text-sm mt-2">
    <span
        class="text-gray-700 dark:text-gray-400">Public Key</span>
    <input type="text"
        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 border-gray-50 leading-tight focus:outline-none focus:shadow-outline focus:border-gray-200"
        name="STRIPE_TEST_PUBLIC_KEY"
        value="{{ cg_get_setting('STRIPE_TEST_PUBLIC_KEY') }}"
        placeholder="Stripe Test Public Key">
</label>
<label class="block text-sm mt-4">
    <span
        class="text-gray-700 dark:text-gray-400">Secret Key</span>
    <input type="text"
        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 border-gray-50 leading-tight focus:outline-none focus:shadow-outline focus:border-gray-200"
        name="STRIPE_TEST_SECRET_KEY"
        value="{{ cg_get_setting('STRIPE_TEST_SECRET_KEY') }}"
        placeholder="Stripe Test Secret Key">
</label>
<label class="block text-sm mt-4">
    <span
        class="text-gray-700 dark:text-gray-400">Webhook Secret</span>
    <input type="text"
        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 border-gray-50 leading-tight focus:outline-none focus:shadow-outline focus:border-gray-200"
        name="STRIPE_TEST_WEBHOOK_SECRET"
        value="{{ cg_get_setting('STRIPE_TEST_WEBHOOK_SECRET') }}"
        placeholder="Stripe Test Webhook Secret">
</label>
<h6 class="mb-4 mt-8 uppercase text-sm font-semibold text-gray-600 dark:text-gray-300">
    Live Mode
  </h6>
<label class="block text-sm mt-4">
    <span
        class="text-gray-700 dark:text-gray-400">Public Key</span>
    <input type="text"
        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 border-gray-50 leading-tight focus:outline-none focus:shadow-outline focus:border-gray-200"
        name="STRIPE_LIVE_PUBLIC_KEY"
        value="{{ cg_get_setting('STRIPE_LIVE_PUBLIC_KEY') }}"
        placeholder="Stripe Live Public Key">
</label>
<label class="block text-sm mt-4">
    <span
        class="text-gray-700 dark:text-gray-400">Secret Key</span>
    <input type="text"
        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 border-gray-50 leading-tight focus:outline-none focus:shadow-outline focus:border-gray-200"
        name="STRIPE_LIVE_SECRET_KEY"
        value="{{ cg_get_setting('STRIPE_LIVE_SECRET_KEY') }}"
        placeholder="Stripe Live Secret Key">
</label>
<label class="block text-sm mt-4">
    <span
        class="text-gray-700 dark:text-gray-400">Webhook Secret</span>
    <input type="text"
        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 border-gray-50 leading-tight focus:outline-none focus:shadow-outline focus:border-gray-200"
        name="STRIPE_LIVE_WEBHOOK_SECRET"
        value="{{ cg_get_setting('STRIPE_LIVE_WEBHOOK_SECRET') }}"
        placeholder="Stripe Live Webhook Secret">
</label>
