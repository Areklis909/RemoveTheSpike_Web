
const img = document.querySelector('img');
img.addEventListener('click', function() {
    if(this.getAttribute('src') === 'img/rysunek4.png') {
        this.setAttribute('src', 'img/header_background.png');
    } else {
        this.setAttribute('src', 'img/rysunek4.png');
    }
    this.removeEventListener('click');

});


function foo() {
    this.setAttribute('src', 'img/header_background.png');
}

function leaveHandler() {
    this.setAttribute('src', 'img/rysunek4.png');
}