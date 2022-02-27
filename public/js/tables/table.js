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

const addTableAction = () => {
    let identifier = $("#add_table_action_modal #identifier").val()
    let display_name = $("#add_table_action_modal #display_name").val()
    let svg_icon = $("#add_table_action_modal #svg_icon").val()

    let table =  localStorage.getItem(getCurrentTableObjectName());

    if (table != null && table != undefined) {
        table = JSON.parse(table)
        let table_actions = JSON.parse(table.actions)

        table_actions.push({
            identifier: identifier,
            display_name: display_name,
            svg_icon: svg_icon
        })

        table.actions = JSON.stringify(table_actions)
        localStorage.setItem(getCurrentTableObjectName(), JSON.stringify(table))
    }

    addActionsToTable()
}

const removeTableAction = (identifier) => {
    let table =  localStorage.getItem(getCurrentTableObjectName());

    if (table != null && table != undefined) {
        table = JSON.parse(table)
        let table_actions = JSON.parse(table.actions)

        table_actions = table_actions.filter((o) => o.identifier != identifier)
        table.actions = JSON.stringify(table_actions)
        localStorage.setItem(getCurrentTableObjectName(), JSON.stringify(table))
    }

    addActionsToTable()
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
                    <button onclick="editCollectionField('${field.field_name}')" @click="editCollectionField = true"  class="flex items-center justify-between px-2 py-2 text-sm font-medium leading-5 text-purple-600 rounded-lg dark:text-gray-400 focus:outline-none focus:shadow-outline-gray" aria-label="Edit">
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

const addKeysToTable = () => {
    let table =  localStorage.getItem(getCurrentTableObjectName());

    if (table != null && table != undefined) {
        table = JSON.parse(table);
        let keys = table.keys

        for (let key of keys){
            let keyName = key.column_name + " -> " + key.foreign_table + "." + key.foreign_table_column

            document.getElementById('keys-active-table-fields').innerHTML += `

            <tr id="x-row-${keyName}" class="text-gray-700 dark:text-gray-400">
                <td class="px-4 py-3 ">
                    ${keyName}
                </td>
                <td class="px-4 py-3">
                    ${key.key_type}
                </td>
                <td class="px-4 py-3">

                  <div class="flex items-center space-x-4 text-sm">

                    <button onclick="deleteAKey('${key.column_name}', '${key.foreign_table}', '${key.foreign_table_column}')" class="flex items-center justify-between px-2 py-2 text-sm font-medium leading-5 text-purple-600 rounded-lg dark:text-gray-400 focus:outline-none focus:shadow-outline-gray" aria-label="Delete">
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

const addActionsToTable = () => {
    let table =  localStorage.getItem(getCurrentTableObjectName());

    if (table != null && table != undefined) {
        table = JSON.parse(table);
        let actions = JSON.parse(table.actions)
        document.getElementById('actions-active-table-fields').innerHTML = ''

        for (let action of actions){
            let keyName = action.identifier

            document.getElementById('actions-active-table-fields').innerHTML += `

            <tr id="x-row-${keyName}" class="text-gray-700 dark:text-gray-400">
                <td class="px-4 py-3 ">
                    ${keyName}
                </td>
                <td class="px-4 py-3">
                    Action
                </td>
                <td class="px-4 py-3">

                  <div class="flex items-center space-x-4 text-sm">

                    <button onclick="removeTableAction('${keyName}')" class="flex items-center justify-between px-2 py-2 text-sm font-medium leading-5 text-purple-600 rounded-lg dark:text-gray-400 focus:outline-none focus:shadow-outline-gray" aria-label="Delete">
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

const deleteAKey = (column_name, foreign_table, foreign_table_column) => {
    let tableObjectName = getCurrentTableObjectName()
    let table = JSON.parse(localStorage.getItem(tableObjectName))
    let keyName = column_name + " -> " + foreign_table + "." + foreign_table_column


    if (table != null && table != undefined){

        let table_keys = table.keys

        for(let key of table_keys){
            if (key.column_name == column_name &&
                key.foreign_table == foreign_table &&
                key.foreign_table_column == foreign_table_column){
                    key.is_deleted = true
                    key.is_new = false

            }
        }

        table.keys = table_keys
        localStorage.setItem(tableObjectName, JSON.stringify(table))
        document.getElementById('x-row-' + keyName).remove()
    }


}

const addKeyToTable = () => {
    let tableObjectName = getCurrentTableObjectName()
    let table = JSON.parse(localStorage.getItem(tableObjectName))


    if (table != null && table != undefined){

        let newKey = {
                'key_type' : document.getElementById('key_type').value,
                'column_name' : document.getElementById('column_name').value,
                'foreign_table' : document.getElementById('foreign_table').value,
                'foreign_table_column' : document.getElementById('foreign_table_column').value,
                'on_delete' : document.getElementById('on_delete').value,
                'on_update' : document.getElementById('on_update').value,
                'is_new': true,
                'is_deleted': false

        }



        let table_keys
        if (table.keys == undefined){
            table_keys = []
        }else{
            table_keys = table.keys
        }


        let obj = table_keys.find(obj =>
            obj.column_name == newKey.column_name &&
            obj.foreign_table == newKey.foreign_table &&
            obj.foreign_table_column == newKey.foreign_table_column )


        if (obj == undefined)
            table_keys.push(newKey)
        else
            return

        table.keys = table_keys
        localStorage.setItem(tableObjectName, JSON.stringify(table))



    }

    addKeysToTable()
}

const injectNewKeyModal = () => {

    let currentTableObj = getCurrentTableObjectName()
    let table = JSON.parse(localStorage.getItem(currentTableObj))
    let table_fields = table.fields

    // Inject current table fields
    let table_fields_html = ""

    for (let field of table_fields){
        table_fields_html += `
            <option value="${field.field_name}">${capitalize(field.field_name)}</option>
        `
    }

    document.getElementById('column_name').innerHTML = table_fields_html

    // Inject all tables

    let tables = JSON.parse(localStorage.getItem('allTables'))

    let tables_html = ""

    for (let table of tables){
        tables_html += `
            <option value="${table.table_name}">${capitalize(table.table_name)}</option>
        `
    }

    document.getElementById('foreign_table').innerHTML = tables_html

    // Get columns from selected table
    injectTableColumns()

}

const injectTableColumns = () => {
    selectedTable = document.getElementById('foreign_table').value
    let tables = JSON.parse(localStorage.getItem('allTables'))

    for (let table of tables){
        if (table.table_name == selectedTable){
            let table_fields = table.fields
            let table_fields_html = ""

            for (let field of table_fields){
                table_fields_html += `
                    <option value="${field.field_name}">${capitalize(field.field_name)}</option>
                `
            }

            document.getElementById('foreign_table_column').innerHTML = table_fields_html
            document.getElementsByClassName('foreign-table-column-block')[0].classList.remove('hidden')
        }
    }




}




const getAllTables = () => {

    fetch(`/all-tables`,
    {
            method: 'GET',
            headers: {
                'Accept': 'application/json',
                'Content-Type': 'application/json',
                "X-Requested-With": "XMLHttpRequest",
                "X-CSRF-Token": document.querySelector('input[name="_token"]').value
            }
    })
    .then(response => response.json())
    .then(response => {

        if (response.status == "success"){
            let tables = response.tables

            // Process tables
            for (let index = 0; index < tables.length; index++) {
                const table = tables[index];

                table.keys = JSON.parse(table.keys)
                table.fields = JSON.parse(table.fields)
                table.configure_fields = JSON.parse(table.configure_fields)
            }

            localStorage.setItem("allTables", JSON.stringify(tables))
        }
     })
}

getAllTables()



document.getElementById('new_key_button').addEventListener('click', injectNewKeyModal)
document.getElementById('foreign_table').addEventListener('change', injectTableColumns)
