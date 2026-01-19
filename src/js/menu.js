document.addEventListener('DOMContentLoaded', function() {
    var menuButton = document.getElementById('menu-button');
    var dropdown = document.getElementById('dropdown-example');

    menuButton.addEventListener('click', function() {
        if (dropdown.classList.contains('hidden')) {
            dropdown.classList.remove('hidden');
            dropdown.classList.add('block');
        } else {
            dropdown.classList.remove('block');
            dropdown.classList.add('hidden');
        }
    });
});



document.addEventListener('DOMContentLoaded', function() {
    var menuButton = document.getElementById('menu-button2');
    var dropdown = document.getElementById('dropdown-example2');

    menuButton.addEventListener('click', function() {
        if (dropdown.classList.contains('hidden')) {
            dropdown.classList.remove('hidden');
            dropdown.classList.add('block');
        } else {
            dropdown.classList.remove('block');
            dropdown.classList.add('hidden');
        }
    });
});
