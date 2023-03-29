document.addEventListener("DOMContentLoaded", function(e) {

    const tabs = document.querySelectorAll('[data-tab]');
    const content = document.getElementsByClassName('active');

    const toggleContent = function() {

        // Part One
        if (!this.classList.contains("active")) {
            Array.from(content).forEach( item => {
                item.classList.remove('active');
            });

            this.classList.add('active');
        }
    };

    Array.from(tabs).forEach( item => {
        item.addEventListener('click', toggleContent);
    });
});
