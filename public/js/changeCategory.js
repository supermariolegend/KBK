function deleteCategory(categoryID) {
    if(confirm('Are you sure you want to delete the category ' + document.getElementById('categoryName' + categoryID).value + '?')) {
        if(document.getElementById('productCat' + categoryID)) {
            if(document.getElementById('productCat' + categoryID).value == 1) {
                alert('This category has products in it. Delete the products first, then delete the category');
                return;
            }
        }
        document.getElementById('deleteCategory' + categoryID).submit();
    }
}