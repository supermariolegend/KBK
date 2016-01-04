if(document.getElementById("deleteProductErrorMessage")) {
    alert("The following error came up when deleting that product:\n" + document.getElementById("deleteProductErrorMessage").value);
}

function deleteProduct(productID) {
    if(confirm('Are you sure you want to delete the product ' + document.getElementById('productName' + productID).value + '?')) {
        document.getElementById('deleteProduct' + productID).submit();
    }
}