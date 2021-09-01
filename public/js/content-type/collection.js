const capitalize = (s) => {
  if (typeof s !== 'string') return ''
  return s.charAt(0).toUpperCase() + s.slice(1)
}

const changeElementAttr = (selector, attr, value) => {
    document.querySelector(selector).setAttribute(attr, value)
}


const changeTableHeader = (tableName) => {

 tableName = capitalize(tableName)
 document.getElementById('active-table-name').innerText = tableName
}

const addItemsToTable = (storeName) => {
    let collection =  localStorage.getItem(storeName);

    if (collection != null && collection != undefined) {
        collection = JSON.parse(collection);
        let tableName = collection.display_name.toLowerCase()
        let fields = collection.fields

       changeTableHeader(tableName)

        document.getElementById('active-collection-fields').innerHTML = ''

        for (let i = 0; i < fields.length; i++) {
            const field = fields[i];

            document.getElementById('active-collection-fields').innerHTML += `

            <tr id="x-row-${field.field_name}" class="text-gray-700 dark:text-gray-400">
                <td class="px-4 py-3 ">
                    ${field.field_name}
                </td>
                <td class="px-4 py-3">
                    ${field.field_type}
                </td>
                <td class="px-4 py-3">

                  <div class="flex items-center space-x-4 text-sm">
                    <button onclick="editCollectionField('${storeName}', '${field.field_name}')"  class="flex items-center justify-between px-2 py-2 text-sm font-medium leading-5 text-purple-600 rounded-lg dark:text-gray-400 focus:outline-none focus:shadow-outline-gray" aria-label="Edit">
                      <svg class="w-5 h-5" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z"></path>
                      </svg>
                    </button>
                    <button onclick="deleteCollectionField('${storeName}', '${field.field_name}')" class="flex items-center justify-between px-2 py-2 text-sm font-medium leading-5 text-purple-600 rounded-lg dark:text-gray-400 focus:outline-none focus:shadow-outline-gray" aria-label="Delete">
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
    newCollection = {}
    newCollection.display_name = document.getElementById('display_name').value
    newCollection.name = document.getElementById('collection_name').value
    newCollection.fields = []
    newCollection.configure_fields = {}

    localStorage.setItem('newCollection', JSON.stringify(newCollection))

    changeElementAttr(
            "#save-collection-button",
            "onclick",
            "createNewCollection()"
        )
}

const deleteUnsavedCollection = () => {
    // Todo: Implement delete unsaved collection
}

const createNewCollection = () => {
    let collection = localStorage.getItem("newCollection")

    if (collection != null && collection != undefined) {
        collection = JSON.parse(collection);

        fetch('/content-types/create',
        {
                method: 'POST',
                headers: {
                    'Accept': 'application/json',
                    'Content-Type': 'application/json',
                    "X-Requested-With": "XMLHttpRequest",
                    "X-CSRF-Token": document.querySelector('input[name="_token"]').value
                },
                body: JSON.stringify(collection)
        })
        .then(response => response.json())
        .then(response => {
            if (response.status == 'success') {
                localStorage.removeItem('newCollection')
                window.location.href = '/content-types'
            }
        })
    }
}

const addConfigField = (storeName, fieldName, checkedStatus) => {
    let collection = localStorage.getItem(storeName);

    if (collection != null && collection != undefined) {
        collection = JSON.parse(collection);
        collection.configure_fields[fieldName] = checkedStatus;
        localStorage.setItem(storeName, JSON.stringify(collection));
    }
}

const appendFieldToConfigure = (storeName) => {
  let configFieldsViewElem =  document.getElementById("configure-fields-view")
    configFieldsViewElem.innerHTML = ""
    let collection = localStorage.getItem(storeName)

    if (collection != null && collection != undefined) {
        collection = JSON.parse(collection);

        let fields = collection.configure_fields
        let fieldKeys = Object.keys(fields)
        for (let fieldKey of fieldKeys){

          if (fields[fieldKey] == true){
            checked = "checked"
          }else{
            checked = ""
          }

          configFieldsViewElem.innerHTML += `
          <a href="#" class="block px-4 py-2 text-sm capitalize text-gray-700 hover:bg-blue-500 hover:text-white">
                <input onchange="addConfigField('${storeName}','${fieldKey.toLowerCase()}', this.checked)" type="checkbox" name="" id="checkbox-hide-field" ${checked}>  <span class="ml-3">${fieldKey}</span>
          </a>`

        }
    }
}

const addCollectionField = (storeName="newCollection") => {
    let collection = JSON.parse(localStorage.getItem(storeName))

    if (collection != null && collection != undefined){

        let newField = {
                'field_name' : document.getElementById('field_name').value,
                'field_type' : document.getElementById('field_type').value,
                'unique' : document.getElementById('unique').value,
                'default' : document.getElementById('default_value').value,
                'nullable' : document.getElementById('nullable').value,
                'accepts_file' : document.getElementById('accepts-file').value,
                'file_type' : document.getElementById('file-type').value

        }


        collection.configure_fields[newField.field_name] = false
        collection.fields.push(newField)
        localStorage.setItem(storeName, JSON.stringify(collection))
        appendFieldToConfigure(storeName)

        // Clear forms
        document.getElementById('field_name').value = ''
        document.getElementById('unique').value = false
        document.getElementById('default_value').value = ''
        document.getElementById('nullable').value = false
    }

    addItemsToTable(storeName)
}

const getCollectionDetails = (id) => {
    fetch(`/content-types/${id}`,
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
                let storeName = "currentCollection"
                let data = response.data
                data.configure_fields = JSON.parse(data.configure_fields)
                data.fields = JSON.parse(data.fields)
                localStorage.setItem(storeName, JSON.stringify(data))

                // changeTableHeader(data.display_name)
                appendFieldToConfigure(storeName)
                addItemsToTable(storeName)
                changeElementAttr(
                    "#save-collection-button",
                    "onclick",
                    `saveCurrentCollection('${storeName}', ${data.id})`
                )

                changeElementAttr(
                    "#add-field-to-collection",
                    "onclick",
                    `addCollectionField('${storeName}')`
                )
            }
        })
}

const deleteCollectionField = (storeName, field_name) => {
    collection = localStorage.getItem(storeName)

    if (collection != undefined && collection != null){
        collection = JSON.parse(collection)
        let fields = collection.fields


        if (collection.delete_fields == undefined){
            collection.delete_fields = []
        }

        // Remove delete field from fields
        for (let index = 0; index < fields.length; index++) {
            const field = fields[index];

            if (field.field_name == field_name){
                fields.splice(index, 1)
                collection.fields = fields
                break
            }
        }



        collection.delete_fields.push(field_name)
        document.getElementById(`x-row-${field_name}`).remove()
        localStorage.setItem(storeName, JSON.stringify(collection))

    }
}

const saveCurrentCollection = (storeName, id) => {

    collection = localStorage.getItem(storeName)

    if (collection != undefined && collection != undefined){
        collection = JSON.parse(collection)


        fetch(`/content-types/update/${id}`,
        {
                method: 'POST',
                headers: {
                    'Accept': 'application/json',
                    'Content-Type': 'application/json',
                    "X-Requested-With": "XMLHttpRequest",
                    "X-CSRF-Token": document.querySelector('input[name="_token"]').value
                },
                body: JSON.stringify(collection)
        })
        .then(response => response.json())
        .then(response => {
            if (response.status == "success"){
                console.log(response.message)
            }
        })
    }
}


const deleteCollection = (id) => {

    fetch(`/content-types/delete/${id}`,
        {
                method: 'POST',
                headers: {
                    'Accept': 'application/json',
                    'Content-Type': 'application/json',
                    "X-Requested-With": "XMLHttpRequest",
                    "X-CSRF-Token": document.querySelector('input[name="_token"]').value
                },
                body: JSON.stringify({})
        })
        .then(response => response.json())
        .then(response => {
            if (response.status == 'success'){
                window.location.href = "/content-types"
            }
        })


}



