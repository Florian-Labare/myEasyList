document.addEventListener("DOMContentLoaded", function(e) {
    const form = document.forms.namedItem("sendProducts");
    form.addEventListener(
        "submit",
        (event) => {
            const output = document.querySelector("#output");
            const lists = document.getElementsByClassName('optionLists');

            const formData = new FormData(form);

            for(var i = 0; i < lists.length; i ++ ) {
                if(lists[i].selected === true) {
                    const request = new XMLHttpRequest();
                    request.open("POST", lists[i].dataset['url'], true);
                    request.onload = (progress) => {

                        output.classList.remove('hidden')
                        setTimeout(() => {
                            output.innerHTML = "Error : Time out"
                            output.classList.add('hidden')
                        }, 3000);

                        if(request.status === 404) {
                            output.classList.remove('bg-green-50');
                            output.classList.add('bg-red-100');
                        }

                        output.innerHTML =
                            request.status === 200
                                ? "Produit(s) ajouté(s) à la liste avec succès"
                                :  `Error ${request.status} aucune liste n'a été sélectionnée.<br />`;
                    };

                    request.send(formData);
                    event.preventDefault();
                }
            }
        },
        false
    );
});
