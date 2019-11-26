function Tile(x, y, s){
    this.x = getTileSize(x);
    this.y = getTileSize(y);
    this.s = getTileSize(s);
    this.src = getTileSrc(x, y);

    var i = this;

    this.draw = function() {
        var img = new Image();
        img.src = this.src;
        img.onload = function() {
            c.drawImage(img, i.x, i.y, i.s, i.s);
        }
    }

    function getTileSrc(x, y) {
        return 'img/board-' + y + '-' + x + '.jpeg';
    }

    function getTileSize(input) {
        var w = canvas.width;
        return input * (w / 15);
    }
}

[1,1,1,0,0,0,0,0,0,0,0,0,0,0]
[1,1,1,0,0,0,0,0,0,0,0,0,0,0]
[1,1,1,0,0,0,0,0,0,0,0,0,0,0]
[0,0,0,0,0,0,0,0,0,0,0,0,0,0]
[0,0,0,0,0,0,0,0,0,0,0,0,0,0]
[0,0,0,0,0,0,0,0,0,0,0,0,0,0]