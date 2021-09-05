const editCollectionField = ( fieldName) => {


    let table = localStorage.getItem(getCurrentTableObjectName());

    if (table) {
        table = JSON.parse(table);
        let field = table[fieldName];

        injectDetailsIntoModal(tableObjectName, field);
    }
}

const injectDetailsIntoModal = (field) => {
    tableObjectName = getCurrentTableObjectName()


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

const saveCurrentCollection = ( id) => {

    let tableObjectName =  getCurrentTableObjectName()
    table = localStorage.getItem(tableObjectName)

    if (table != undefined && table != undefined){
        table = JSON.parse(table)
        table.perms = JSON.parse(localStorage.getItem("currentTablePerms"))


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
                setSuccessAlert(response.message)
            }
        })
    }
}

const getTableDetails = (id) => {
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
                let tableObjectName = "editTable"
                let data = response.data
                let rolePerms = response.role_perms
                data.configure_fields = JSON.parse(data.configure_fields)
                data.fields = JSON.parse(data.fields)
                localStorage.setItem(tableObjectName, JSON.stringify(data))
                localStorage.setItem("currentTablePerms", JSON.stringify(rolePerms))
                localStorage.setItem("currentTableObjectName", tableObjectName)


                injectPermsToModal(rolePerms)
                appendFieldToConfigure()
                addItemsToTable()
                changeElementAttr(
                    "#save-table-button",
                    "onclick",
                    `saveCurrentCollection(${data.id})`
                )

                changeElementAttr(
                    "#add-field-to-table",
                    "onclick",
                    `addCollectionField()`
                )

                if (data.table_name != "users"){
                    $('#edit-table-name-button').removeClass('hidden')

                }


            }
        })
}

const clickTablePermission = (role, perm) => {

    let checkboxId = `#checkbox-${role}-${perm}`
    let checked = document.querySelector(checkboxId).checked

    if (checked){
        tablePerms = localStorage.getItem("currentTablePerms")

        if (tablePerms != null && tablePerms != undefined){
            tablePerms = JSON.parse(tablePerms)
            tablePerms[role][perm] = true
        }

    }else{
        tablePerms = localStorage.getItem("currentTablePerms")

        if (tablePerms != null && tablePerms != undefined){
            tablePerms = JSON.parse(tablePerms)
            tablePerms[role][perm] = false
        }
    }

    localStorage.setItem("currentTablePerms", JSON.stringify(tablePerms))
}

const injectPermsToModal = (rolePerms) => {

    roles = Object.keys(rolePerms)
    let finalString = ``

    for (let role of roles){
        let roleDisplayName = role[0].toUpperCase() + role.slice(1)
        finalString += ` <div class="role-perms">
        <p class="font-bold">${roleDisplayName}</p>

        <div class="flex flex-row checkbox-row">`


        let perms = Object.keys(rolePerms[role])

        for (let perm of perms){
            let permDisplayName = perm[0].toUpperCase() + perm.slice(1)
            let checked = rolePerms[role][perm] == 1 ? "checked" : ""
            finalString +=  `<a href="#"
            class="block px-4 py-2 text-sm capitalize text-gray-700 hover:bg-blue-500 hover:text-white">
            <input ${checked} onchange="clickTablePermission('${role}', '${perm}')" type="checkbox" name="" id="checkbox-${role}-${perm}"> <span
                class="ml-3">${permDisplayName}</span>
        </a> `

        }

        finalString += `</div>

        </div>`



    }


    document.getElementById("role-perms-container").innerHTML = finalString
    document.querySelector('#modify-table-perms-btn').classList.remove('hidden')
}

const addConfigField = (fieldName, checkedStatus) => {
    let tableObjectName = getCurrentTableObjectName()
    let table = localStorage.getItem(tableObjectName);

    if (table != null && table != undefined) {
        table = JSON.parse(table);
        table.configure_fields[fieldName] = checkedStatus;
        localStorage.setItem(tableObjectName, JSON.stringify(table));
    }
}

const deleteCollectionField = (field_name) => {
    let tableObjectName = getCurrentTableObjectName()
    table = localStorage.getItem(tableObjectName)

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
        localStorage.setItem(tableObjectName, JSON.stringify(table))

    }
}

const populateEditTableModal = () => {

    let tableObjectName =  getCurrentTableObjectName()

    table = localStorage.getItem(tableObjectName)

    if (table != undefined && table != null){
        table = JSON.parse(table)

        console.log(table)

        let tableName = table.table_name
        let displayName = table.display_name

        document.querySelector('#edit-table-name #table_name').value = tableName
        document.querySelector('#edit-table-name #display_name').value = displayName
    }
}

const renameTableName = () => {
    tableName = document.querySelector('#edit-table-name #table_name').value
    displayName = document.querySelector('#edit-table-name #display_name').value
    tableObjectName = getCurrentTableObjectName()
    table = JSON.parse(localStorage.getItem(tableObjectName))


    request = $.ajax({
        url: `/tables/${table.table_name}/rename`,
        type: "POST",
        data: {
            "_token": document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            "table_name": tableName,
            "display_name": displayName
        }
    });

     // Callback handler that will be called on success
     request.done(function (response, textStatus, jqXHR){
        if (response.status == "success"){
            setSuccessAlert(response.message)
            changeTableHeader(tableName)
            updateTableNameFields(table.table_name, tableName, response.data.id)

            // Change table object data
            table.table_name = tableName
            table.display_name = displayName
            localStorage.setItem(tableObjectName, JSON.stringify(table))
        }
    });

    // Callback handler that will be called on failure
    request.fail(function (jqXHR, textStatus, errorThrown){
        setErrorAlert("OOps! something went wrong")
    });
}
