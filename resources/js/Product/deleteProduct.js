document.addEventListener("DOMContentLoaded", function(e) {
    const elementsToDelete = document.querySelectorAll('[data-productid]');
    const deleteAllButton =  document.getElementById("delete-all");

    Array.from(elementsToDelete).forEach( item => {
        item.addEventListener('click', deleteProduct, )
    });

    const formDelete = document.forms.namedItem("deleteAllProducts");
    formDelete.addEventListener(
        "submit",
        (event) => {
            const outputDeleteAll = document.querySelector("#output-message-delete-all");

            const formData = new FormData(formDelete);
            const request = new XMLHttpRequest();
            request.open("POST", deleteAllButton.dataset['deleteurl'], true);
            request.onload = (progress) => {

                outputDeleteAll.classList.remove('hidden')
                setTimeout(() => {
                    outputDeleteAll.innerHTML = "Error : Time out"
                    outputDeleteAll.classList.add('hidden')
                }, 3000);

                document.getElementById('container-table-products').remove();
                deleteAllButton.remove();

                outputDeleteAll.innerHTML =
                    request.status === 200
                        ? "Produits supprimés"
                        :  `Error ${request.status} problème lors de la suppression de tous les produits.<br />`;
            };

            request.send(formData);
            event.preventDefault();
        },
        false
    );


    function deleteProduct(e){
        console.log(e.target.dataset['urldelete']);
        const outputDelete = document.querySelector("#output-message-delete");
        const request = new XMLHttpRequest();
        request.open("POST", e.target.dataset['urldelete'], true);
        console.log(request);
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
