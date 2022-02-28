<h6 class="mb-4 text-sm font-semibold text-gray-600 dark:text-gray-300">
    Paynow Settings
  </h6>
<label class="block text-sm mt-4">
    <span
        class="text-gray-700 dark:text-gray-400">Integration ID</span>
    <input type="text"
        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 border-gray-50 leading-tight focus:outline-none focus:shadow-outline focus:border-gray-200"
        name="PAYNOW_INTERGRATION_ID"
        value="{{ cg_get_setting('PAYNOW_INTERGRATION_ID') }}"
        placeholder="Paynow Integration ID">
</label>
<label class="block text-sm mt-4">
    <span
        class="text-gray-700 dark:text-gray-400">Integration Key</span>
    <input type="text"
        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 border-gray-50 leading-tight focus:outline-none focus:shadow-outline focus:border-gray-200"
        name="PAYNOW_INTERGRATION_KEY"
        value="{{ cg_get_setting('PAYNOW_INTERGRATION_KEY') }}"
        placeholder="Paynow Integration Key">
</label>
<label class="block text-sm mt-4">
    <span
        class="text-gray-700 dark:text-gray-400">Return URL</span>
    <input type="text"
        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 border-gray-50 leading-tight focus:outline-none focus:shadow-outline focus:border-gray-200"
        name="PAYNOW_RETURN_URL"
        value="{{ cg_get_setting('PAYNOW_RETURN_URL') }}"
        placeholder="Paynow Return URL">
</label>
<label class="block text-sm mt-4">
    <span
        class="text-gray-700 dark:text-gray-400">Update URL</span>
    <input type="text"
        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 border-gray-50 leading-tight focus:outline-none focus:shadow-outline focus:border-gray-200"
        name="PAYNOW_UPDATE_URL"
        value="{{ cg_get_setting('PAYNOW_UPDATE_URL') }}"
        placeholder="Paynow Update URL">
</label>
<label class="block text-sm mt-4">
    <span
        class="text-gray-700 dark:text-gray-400">USE RATE</span>
    <select
        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 border-gray-50 leading-tight focus:outline-none focus:shadow-outline focus:border-gray-200"
        name="PAYNOW_USE_RATE"
        >

        <option value="yes"  {{ cg_get_setting('PAYNOW_USE_RATE') == "yes" ? 'selected' : '' }}>Yes</option>
        <option value="no" {{ cg_get_setting('PAYNOW_USE_RATE') == "no" ? 'selected' : '' }}>No</option>

    </select>
</label>
<label class="block text-sm mt-4">
    <span
        class="text-gray-700 dark:text-gray-400">USD/ZWL RATE</span>
    <input type="number"
        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 border-gray-50 leading-tight focus:outline-none focus:shadow-outline focus:border-gray-200"
        name="PAYNOW_RATE"
        value="{{ cg_get_setting('PAYNOW_RATE') }}"
        placeholder="Paynow Rate e.g 170">
</label>
