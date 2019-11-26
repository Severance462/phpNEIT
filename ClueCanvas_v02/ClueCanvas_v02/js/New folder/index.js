var canvas = document.querySelector('canvas');
var c = canvas.getContext('2d');

window.onload = function() {
    load();
    window.addEventListener('resize', load);
    canvas.addEventListener('click', boardClick);
    canvas.addEventListener('mousemove', boardMove);
}

function load() {
    loadCanvas();
    loadBoard();
}

function loadCanvas() {
    canvas.style.width = '100%';
    canvas.style.height = canvas.clientWidth + 'px';
    canvas.width = canvas.clientWidth;
    canvas.height = canvas.clientHeight;
}