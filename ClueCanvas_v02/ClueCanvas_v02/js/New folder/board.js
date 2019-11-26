var board = [];
var cursorX = 15;
var cursorY = 15;
var clickX = 15;
var clickY = 15;

function loadBoard() {
    board = [];
    for(var y = 0; y < 15; ++y) {
        var row = [];
        for(var x = 0; x < 15; ++x) {
            var tile = new Tile(x, y, 1);
            tile.draw();
            row.push(tile);
        }
        board.push(row);
    }
}

function boardClick(e) {
    var pos = boardCoordinates(e.clientX, e.clientY);

    if ((pos['x'] === clickX) && (pos['y'] === clickY)) {

    } else {
        var tile = new Tile(cursorX, cursorY, 1);
        var rgba = rgbaColor(255, 244, 38, 0.8);
        clickX = pos['x'];
        clickY = pos['y'];
        tile.draw();
        getCircle(pos['x'], pos['y'], 1, rgba);
    }
}

function boardMove(e) {
    var pos = boardCoordinates(e.clientX, e.clientY);

    if ((pos['x'] === cursorX) && (pos['y'] === cursorY)) {

    } else {
        var tile = new Tile(cursorX, cursorY, 1);
        var rgba = rgbaColor(255, 244, 38, 0.8);
        cursorX = pos['x'];
        cursorY = pos['y'];
        tile.draw();
        getCircle(pos['x'], pos['y'], 1, rgba);
    }
}

function boardCoordinates(eX, eY) {
    var coordinates = [];
    var r = canvas.getBoundingClientRect();
    var x = eX - (r.left * (canvas.width  / r.width));
    var y = eY - (r.top * (canvas.height  / r.height));
    var s = canvas.width * (1 / 15);

    coordinates['x'] = Math.floor(x / s);
    coordinates['y'] = Math.floor(y / s);

    return coordinates;
}

function getCircle(x, y, r, color) {
    r = ((canvas.width/ 15) * r) / 2;
    x = ((canvas.width/ 15) * x) + r;
    y = ((canvas.width/ 15) * y) + r;

    c.beginPath();
    c.arc(x, y, r, 0, Math.PI * 2, false);
    c.fillStyle = color;
    c.strokeStyle = color;
    c.stroke();
    c.fill();
}

function rgbaColor(r, g, b, a) {
    return 'rgba(' + r + ', ' + g + ', ' + b + ', ' + a + ')';
}