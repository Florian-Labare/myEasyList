document.addEventListener("DOMContentLoaded", function(e) {

    var productIds = document.getElementsByClassName('incrementDays')
    for (var i = 0; i < productIds.length; i++) {
        var slider = document.getElementById("add_days_"+productIds[i].id);
        var output = document.getElementById("increment_"+productIds[i].id);

        output.innerHTML = slider.value;
        slider.oninput = function(e)  {
            var output = document.getElementById("increment_"+e.target.dataset['product']);
            output.innerHTML = this.value;
        }
    }

});
