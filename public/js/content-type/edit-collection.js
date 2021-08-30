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
