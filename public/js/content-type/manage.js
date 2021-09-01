const editCollectionField = (storeName, fieldName) => {
    let collection = localStorage.getItem(storeName);

    if (collection) {
        collection = JSON.parse(collection);
        let field = collection[fieldName];

        injectDetailsIntoModal(storeName, field);
    }
}

const injectDetailsIntoModal = (storeName, field) => {


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

const addConfigField = (storeName, fieldName, checkedStatus) => {
    let collection = localStorage.getItem(storeName);

    if (collection != null && collection != undefined) {
        collection = JSON.parse(collection);
        collection.configure_fields[fieldName] = checkedStatus;
        localStorage.setItem(storeName, JSON.stringify(collection));
    }
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
