
const deleteAlert = (el) => {
    setTimeout(() => {
        $(el).fadeTo(500, 0).slideUp(500, function () {
            $(this).remove();
        });
    }, 2000);
}

setSuccessAlert = (message) => {
    let timestamp = new Date().getTime();
    let elID = 'success-' + timestamp.toString();

    document.getElementById('system-alerts').innerHTML += `<a id="${elID}" class="flex transition-opacity duration-1000 ease-out opacity-100 focus:opacity-0 items-center justify-between p-4 mb-8 text-sm font-semibold text-purple-100 bg-green-500 rounded-lg shadow-md focus:outline-none focus:shadow-outline-purple z-50"
                    href="javascript:void(0)"
                    onclick="deleteAlert(this)">
                    <div class="flex items-center">
                        <svg class="w-6 h-6 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        <span>${message}</span>
                    </div>
                </a>`

    setTimeout(() => {
        document.getElementById(elID).click()
    }, 4000)
}

setErrorAlert = (message) => {
    let timestamp = new Date().getTime();
    let elID = 'error-' + timestamp.toString();

    document.getElementById('system-alerts').innerHTML += `<a id='${elID}' class="flex transition-opacity duration-1000 ease-out opacity-100 focus:opacity-0 items-center justify-between p-4 mb-8 text-sm font-semibold text-purple-100 bg-red-600 rounded-lg shadow-md focus:outline-none focus:shadow-outline-purple z-50"
            href="javascript:void(0)"
            onclick="deleteAlert(this)">
            <div class="flex items-center">
                <svg class="w-6 h-6 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                <span>${message}</span>
            </div>
        </a>`

    setTimeout(() => {
        document.getElementById(elID).click()
    }, 4000)
}

