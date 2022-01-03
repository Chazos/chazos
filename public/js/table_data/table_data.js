const triggerCustomAction = (rowId, destination) => {

    axios.post(destination, {}, {
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        })
        .then(function (response) {
            if (response.data.status == 'success') {
                setSuccessAlert(response.data.message)
                window
                    .location
                    .reload()
            } else if (response.data.status == 'failed') {
                setErrorAlert(response.data.message)
            }
        })
        .catch(function (error) {
            setErrorAlert(error.toString())
        });

}

function hideTableField(className) {

    let elements = document.getElementsByClassName(className);

    for (const element of elements) {
        if (element.classList.contains('hidden')) {
            element
                .classList
                .remove('hidden');
        } else {
            element
                .classList
                .add('hidden');
        }
    }
}

function filterTable(value) {
    let rows = document.querySelectorAll('tbody tr');

    for (const row of rows) {
        if (row.innerText.toLowerCase().includes(value.toLowerCase())) {
            row
                .classList
                .remove('hidden');
        } else {
            row
                .classList
                .add('hidden');
        }
    }
}

function exportData(tableName) {
    fetch(`/manage/${tableName}/export`, {
        method: 'POST',
        headers: {
            'Accept': 'text/csv',
            'Content-Type': 'application/json',
            "X-Requested-With": "XMLHttpRequest",
            "X-CSRF-Token": document
                .querySelector('meta[name="csrf-token"]')
                .getAttribute('content')
        },
            body: {}
        })
        .then(response => response.text())
        .then(data => {
            let a = document.createElement('a');
            a.href = 'data:text/csv;base64, ' + btoa(data);
            a.download = `${tableName}.csv`;
            a.click();
        })
        .catch((error) => {
            setSuccessAlert('Ooops! Something went wrong!')
        })
}

function checkOnAllCheckbox() {
    let checkboxes = document.querySelectorAll('input.table-data-check');

    for (const checkbox of checkboxes) {
        if (checkbox.checked == false) {
            checkbox.click()
        } else {
            checkbox.click()
            checkbox.click()
        }
    }

    document
        .querySelector('#check-all-box')
        .setAttribute('onclick', 'checkOffAllCheckbox()');

}

function checkOffAllCheckbox() {
    let checkboxes = document.querySelectorAll('input.table-data-check');

    for (const checkbox of checkboxes) {
        if (checkbox.checked == true) {
            checkbox.click()
        } else {
            checkbox.click()
            checkbox.click()
        }
    }

    document
        .querySelector('#check-all-box')
        .setAttribute('onclick', 'checkOnAllCheckbox()');
}

function onCheckboxChecked(element, id) {

    checkedData = localStorage.getItem('checkedData');

    if (checkedData == null) {
        checkedData = [];
    } else {
        checkedData = JSON.parse(checkedData);
    }

    if (element.checked == true) {
        if (checkedData.includes(id) == false) {
            checkedData.push(id);
        }
    } else {
        let index = checkedData.indexOf(id);

        if (index > -1) {
            checkedData.splice(index, 1);
        }
    }

    localStorage.setItem('checkedData', JSON.stringify(checkedData));

}

function deleteMultiple(tableName) {
    let checkedData = localStorage.getItem('checkedData');

    if (checkedData == null) {
        setSuccessAlert('Please select at least one row!')
        return;
    } else {
        checkedData = JSON.parse(checkedData);

        for (const id of checkedData) {
            deleteRow(`#row-${id}`, tableName, id);
        }
    }
}

function deleteRow(elRowId, tableName, rowId) {
    fetch(`/manage/${tableName}/delete/${rowId}`, {
        method: 'POST',
        headers: {
            'Accept': 'application/json',
            'Content-Type': 'application/json',
            "X-Requested-With": "XMLHttpRequest",
            "X-CSRF-Token": document
                .querySelector('meta[name="csrf-token"]')
                .getAttribute('content')
        },
            body: {}
        })
        .then(response => response.json())
        .then(response => {
            console.log(response);
            if (response.status == 'success') {
                setSuccessAlert(response.message);
                setTimeout(() => {
                    $(elRowId)
                        .fadeTo(2000, 0)
                        .slideUp(1000, function () {
                            $(this).remove();
                        });
                }, 1000);
            }
        })
        .catch(() => {
            setSuccessAlert('Ooops! Something went wrong!')
        })
}

$('#import-data-button').on('click', (event) => {
    let destination = $(event.target).attr('data-route-name')
    let form = $('.import-data-form')
    let formData = new FormData(form[0])

    axios
        .post(destination, formData, {
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        })
        .then(function (response) {
            if (response.data.status == 'success') {
                setSuccessAlert(response.data.message)
                window
                    .location
                    .reload()
            }
        })
        .catch(function (error) {
            setErrorAlert(error.toString())
        });
})
