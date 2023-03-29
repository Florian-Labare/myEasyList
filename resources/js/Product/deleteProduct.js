const elementsToDelete = document.querySelectorAll('[data-productid]');

Array.from(elementsToDelete).forEach( item => {
    item.addEventListener('click', deleteProduct, )
});

function deleteProduct(e){
    const outputDelete = document.querySelector("#output-message-delete");
    const request = new XMLHttpRequest();
    request.open("POST", e.target.dataset['urldelete'], true);
    request.onload = () => {
        const productLine = document.getElementById('product-line_'+e.target.dataset['productid']);
        productLine.remove();

        outputDelete.classList.remove('hidden')
        setTimeout(() => {
            outputDelete.innerHTML = "Error : Time out"
            outputDelete.classList.add('hidden')
        }, 3000);

        outputDelete.innerHTML =
            request.status === 200
                ? "Produit supprimé avec succès"
                : `Error ${request.status} un problème est survenu lors de la suppression.<br />`;
    };

    request.send(e.target);
    e.preventDefault();
}

