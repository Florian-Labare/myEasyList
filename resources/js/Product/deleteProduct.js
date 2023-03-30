document.addEventListener("DOMContentLoaded", function(e) {
    const elementsToDelete = document.querySelectorAll('[data-productid]');
    const deleteAllButton =  document.getElementById("delete-all");
    console.log(elementsToDelete);

    Array.from(elementsToDelete).forEach( item => {
        item.addEventListener('click', deleteProduct, )
    });

    function deleteAllproducts(e) {
        const outputDeleteAll = document.querySelector("#output-message-delete-all")
        for(let i = 0; i < elementsToDelete.length; i++) {
            const request = new XMLHttpRequest();
            request.open("POST", elementsToDelete[i].dataset['urldelete'], true);
            request.onload = () => {

                outputDeleteAll.classList.remove('hidden')
                setTimeout(() => {
                    outputDeleteAll.innerHTML = "Error : Time out"
                    outputDeleteAll.classList.add('hidden')
                }, 3000);

                outputDeleteAll.innerHTML =
                    request.status === 200
                        ? "Produits supprimés avec succès"
                        : `Error ${request.status} un problème est survenu lors de la suppression.<br />`;
            };

            request.send(e.target);
            e.preventDefault();
        }
    }
    deleteAllButton.addEventListener('click', deleteAllproducts);

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

});
