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
                let role_perms = response.role_perms
                data.configure_fields = JSON.parse(data.configure_fields)
                data.fields = JSON.parse(data.fields)
                localStorage.setItem(storeName, JSON.stringify(data))
                localStorage.setItem("currentTablePerms", JSON.stringify(role_perms))


                injectPermsToModal(role_perms)
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
