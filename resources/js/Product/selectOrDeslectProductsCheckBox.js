document.addEventListener("DOMContentLoaded", function(e) {
    const inputs = document.getElementsByName('products[]');
    const selectAll = document.getElementById('selectAll');
    const deselectAll = document.getElementById('deselectAll');

    const selects = ()=> {
        for(var i = 0; i < inputs.length; i++){
            if(inputs[i].type == 'checkbox')
                inputs[i].checked = true;
        }
    }

    const deSelect = ()=> {
        for(var i = 0; i < inputs.length; i++){
            if(inputs[i].type == 'checkbox')
                inputs[i].checked = false;
        }
    }

    selectAll.addEventListener('click', selects);
    deselectAll.addEventListener('click', deSelect);
});
