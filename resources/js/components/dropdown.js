let dropdownHover = document.querySelector('.relative');
let dropdownMenu = document.querySelector('#dropdownNavbar');

if (dropdownHover && dropdownMenu) {
    dropdownHover.addEventListener('mouseover', function () {
        dropdownMenu.style.display = 'block';
    });

    dropdownHover.addEventListener('mouseleave', function (event) {
        if (!dropdownMenu.contains(event.relatedTarget)) {
            dropdownMenu.style.display = 'none';
        }
    });

    dropdownMenu.addEventListener('mouseleave', function (event) {
        if (!dropdownHover.contains(event.relatedTarget)) {
            dropdownMenu.style.display = 'none';
        }
    });
} 
