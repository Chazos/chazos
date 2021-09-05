const capitalize = (s) => {
  if (typeof s !== 'string') return ''
  return s.charAt(0).toUpperCase() + s.slice(1)
}

const changeElementAttr = (selector, attr, value) => {
    document.querySelector(selector).setAttribute(attr, value)
}

const getCurrentTableObjectName = () => {
    return localStorage.getItem("currentTableObjectName")
}


const changeTableHeader = (tableName) => {

 tableName = capitalize(tableName)
 document.getElementById('active-table-name').innerText = tableName
}



const updateTableNameFields = (oldTableName, newTableName, id) => {
    let finalTableName = capitalize(newTableName)

    $(".sidebar-tbl-item-" + id).text(finalTableName)
    $("#tbl-item-" + id).text(finalTableName)
}



const addItemsToTable = () => {



    let table =  localStorage.getItem(getCurrentTableObjectName());

    if (table != null && table != undefined) {
        table = JSON.parse(table);
        let tableName = table.display_name.toLowerCase()
        let fields = table.fields

       changeTableHeader(tableName)

        document.getElementById('active-table-fields').innerHTML = ''

        for (let i = 0; i < fields.length; i++) {
            const field = fields[i];

            document.getElementById('active-table-fields').innerHTML += `

            <tr id="x-row-${field.field_name}" class="text-gray-700 dark:text-gray-400">
                <td class="px-4 py-3 ">
                    ${field.field_name}
                </td>
                <td class="px-4 py-3">
                    ${field.field_type}
                </td>
                <td class="px-4 py-3">

                  <div class="flex items-center space-x-4 text-sm">
                    <button onclick="editCollectionField('${field.field_name}')"  class="flex items-center justify-between px-2 py-2 text-sm font-medium leading-5 text-purple-600 rounded-lg dark:text-gray-400 focus:outline-none focus:shadow-outline-gray" aria-label="Edit">
                      <svg class="w-5 h-5" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z"></path>
                      </svg>
                    </button>
                    <button onclick="deleteCollectionField('${field.field_name}')" class="flex items-center justify-between px-2 py-2 text-sm font-medium leading-5 text-purple-600 rounded-lg dark:text-gray-400 focus:outline-none focus:shadow-outline-gray" aria-label="Delete">
                      <svg class="w-5 h-5" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                      </svg>
                    </button>
                  </div>

                </td>
              </tr>
            `
        }
    }
}

const draftCollection = () =>{

    document.querySelector('#active-table-name').innerText = ""
    document.querySelector('#active-table-fields').innerHTML = ""
    document.querySelector('#modify-table-perms-btn').classList.add('hidden')
    let tableObjectName = "newTable"



    newCollection = {}
    newCollection.display_name = document.getElementById('display_name').value
    newCollection.name = document.getElementById('table_name').value
    newCollection.fields = []
    newCollection.configure_fields = {}


    localStorage.setItem(tableObjectName, JSON.stringify(newCollection))
    localStorage.setItem("currentTableObjectName", tableObjectName)
    changeTableHeader(document.getElementById('table_name').value)

    changeElementAttr(
            "#save-table-button",
            "onclick",
            "createNewTable()"
        )

    changeElementAttr(
            "#add-field-to-table",
            "onclick",
            `addTableField('${tableObjectName}')`
        )
}

const deleteUnsavedCollection = () => {
    // Todo: Implement delete unsaved table
}

const createNewTable = () => {
    let table = localStorage.getItem(getCurrentTableObjectName())

    if (table != null && table != undefined) {
        table = JSON.parse(table);

        fetch('/tables/create',
        {
                method: 'POST',
                headers: {
                    'Accept': 'application/json',
                    'Content-Type': 'application/json',
                    "X-Requested-With": "XMLHttpRequest",
                    "X-CSRF-Token": document.querySelector('input[name="_token"]').value
                },
                body: JSON.stringify(table)
        })
        .then(response => response.json())
        .then(response => {
            if (response.status == 'success') {
                localStorage.removeItem('newCollection')
                window.location.href = '/tables'
            }
        })
    }
}

const appendFieldToConfigure = () => {
  let configFieldsViewElem =  document.getElementById("configure-fields-view")
    configFieldsViewElem.innerHTML = ""


    let table = localStorage.getItem(getCurrentTableObjectName())

    if (table != null && table != undefined) {
        table = JSON.parse(table);

        let fields = table.configure_fields
        let fieldKeys = Object.keys(fields)
        for (let fieldKey of fieldKeys){

          if (fields[fieldKey] == true){
            checked = "checked"
          }else{
            checked = ""
          }

          configFieldsViewElem.innerHTML += `
          <a href="#" class="block px-4 py-2 text-sm capitalize text-gray-700 hover:bg-blue-500 hover:text-white">
                <input onchange="addConfigField('${fieldKey.toLowerCase()}', this.checked)" type="checkbox" name="" id="checkbox-hide-field" ${checked}>  <span class="ml-3">${fieldKey}</span>
          </a>`

        }
    }
}

const addTableField = () => {
    let tableObjectName = getCurrentTableObjectName()
    let table = JSON.parse(localStorage.getItem(tableObjectName))


    if (table != null && table != undefined){

        let newField = {
                'field_name' : document.getElementById('field_name').value,
                'field_type' : document.getElementById('field_type').value,
                'unique' : document.getElementById('unique').value,
                'default' : document.getElementById('default_value').value,
                'nullable' : document.getElementById('nullable').value,
                'accepts_file' : document.getElementById('accepts-file').value,
                'file_type' : document.getElementById('file-type').value

        }


        table.configure_fields[newField.field_name] = true
        table.fields.push(newField)
        localStorage.setItem(tableObjectName, JSON.stringify(table))
        appendFieldToConfigure()

        // Clear forms
        document.getElementById('field_name').value = ''
        document.getElementById('unique').value = false
        document.getElementById('default_value').value = ''
        document.getElementById('nullable').value = false
    }

    addItemsToTable()
}








