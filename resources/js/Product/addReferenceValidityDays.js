function getElementByProductId(label, productId){
    return document.getElementById(label+'_'+productId);
}

document.addEventListener("DOMContentLoaded", function(e) {

    const referenceDays = document.querySelectorAll('[data-product]');
    document.getElementById('success-output').classList.add('hidden');

    // set reference validity days in list
    Array.from(referenceDays).forEach( item => {
        item.addEventListener('click', addReferenceDays, )
    });

    Array.from(referenceDays).forEach( item => {
        if(item.dataset['status'] === "OK") {
            item.classList.add('hidden');
        }
    });

    function addReferenceDays(e) {
        const request = new XMLHttpRequest();
        const productId = e.target.dataset['product'];
        const outputStatusChange = getElementByProductId('output-status-change', productId);
        const outputRemainingDayChange = getElementByProductId('output-remaining-day-change',productId);
        const buttonAddReferenceDays = getElementByProductId('addReferenceDays', productId);
        const output = document.getElementById('success-output');

        request.open("POST", e.target.dataset['url'], true);
        request.onload = () => {
            const parse = JSON.parse(request.response);
            output.classList.remove('hidden')

            if(parse.product_status === "OK") {
                outputStatusChange.classList.remove('bg-orange-300/60');
                outputStatusChange.classList.remove('bg-red-300/60');
                outputStatusChange.classList.add('bg-emerald-300/60');
            }

            setTimeout(() => {
                output.innerHTML = "Error : Time out"
                output.classList.add('hidden')
            }, 3000);

            buttonAddReferenceDays.classList.add('hidden');
            output.innerHTML =
                request.status === 200
                    ?  e.target.dataset['name']+" modifié avec succès"
                    : `Error ${request.status} occurred when trying to send data.<br />`;

            outputStatusChange.innerHTML =
                request.status === 200
                    ?  parse.product_status
                    : `Error ${request.status} occurred when trying to send product status.<br />`;

            outputRemainingDayChange.innerHTML =
                request.status === 200
                    ?  parse.remaining_day
                    : `Error ${request.status} occurred when trying to send remaining day.<br />`;

        }
        request.send(e.target);
        e.preventDefault();
    }

});
