let dropdownHover = document.querySelector('.relative');
let dropdownMenu = document.querySelector('#dropdownNavbar');

if (dropdownHover && dropdownMenu) {
    dropdownHover.addEventListener('mouseover', function () {
        dropdownMenu.style.display = 'block';
    });

    dropdownMenu.addEventListener('mouseout', function (event) {
        if (!dropdownHover.contains(event.relatedTarget) && !dropdownMenu.contains(event.relatedTarget)) {
            dropdownMenu.style.display = 'none';
        }
    });
} 
