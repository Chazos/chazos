const editCollectionField = (storeName, fieldName) => {
    let table = localStorage.getItem(storeName);

    if (table) {
        table = JSON.parse(table);
        let field = table[fieldName];

        injectDetailsIntoModal(storeName, field);
    }
}

const injectDetailsIntoModal = (storeName, field) => {


}

const deleteCollection = (id) => {

    fetch(`/tables/delete/${id}`,
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
                window.location.href = "/tables"
            }
        })


}


const saveCurrentCollection = (storeName, id) => {

    table = localStorage.getItem(storeName)

    if (table != undefined && table != undefined){
        table = JSON.parse(table)


        fetch(`/tables/update/${id}`,
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
            if (response.status == "success"){
                console.log(response.message)
            }
        })
    }
}


const getCollectionDetails = (id) => {
    fetch(`/tables/${id}`,
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
                    "#save-table-button",
                    "onclick",
                    `saveCurrentCollection('${storeName}', ${data.id})`
                )

                changeElementAttr(
                    "#add-field-to-table",
                    "onclick",
                    `addCollectionField('${storeName}')`
                )
            }
        })
}

const addConfigField = (storeName, fieldName, checkedStatus) => {
    let table = localStorage.getItem(storeName);

    if (table != null && table != undefined) {
        table = JSON.parse(table);
        table.configure_fields[fieldName] = checkedStatus;
        localStorage.setItem(storeName, JSON.stringify(table));
    }
}

const deleteCollectionField = (storeName, field_name) => {
    table = localStorage.getItem(storeName)

    if (table != undefined && table != null){
        table = JSON.parse(table)
        let fields = table.fields


        if (table.delete_fields == undefined){
            table.delete_fields = []
        }

        // Remove delete field from fields
        for (let index = 0; index < fields.length; index++) {
            const field = fields[index];

            if (field.field_name == field_name){
                fields.splice(index, 1)
                table.fields = fields
                break
            }
        }



        table.delete_fields.push(field_name)
        document.getElementById(`x-row-${field_name}`).remove()
        localStorage.setItem(storeName, JSON.stringify(table))

    }
}
