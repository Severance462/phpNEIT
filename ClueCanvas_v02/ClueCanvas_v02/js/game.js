var Game = {
    id: 0,
    playersCount: 0,
    turn: 0,
    players: {},
    log: function() {
        console.clear();
        console.log(Game);
    },
    moveSwitch: function() {
        this.players[this.turn].move =
            String((this.players[this.turn].move === 'false'));
    },
    movedSwitch: function() {
        this.players[this.turn].moved =
            String((this.players[this.turn].move === 'false'));
    },
    turnSwitch: function() {
        this.turn++;
        if (this.turn === this.playersCount) {
            this.turn = 0;
        }
    },
    jsonGet: function() {
        var rawGameData = document.getElementById('gameData');
        var gameData = JSON.parse(rawGameData.innerHTML.trim());
        var playerData = document.getElementById('playerData');

        this.id = gameData.gameId;
        this.playersCount = gameData.numPlayers;
        this.turn = gameData.turn;
        this.players = JSON.parse(playerData.innerHTML.trim());
    },
    jsonSet: function() {
        var gameObj = {
            gameId: this.id,
            numPlayers: this.playersCount,
            turn: this.turn
        };
        var gameData = JSON.stringify(gameObj);
        var playerData = JSON.stringify(this.players);

        var html = '';
        html += '<form method="post" action="php/sessionSet.php">';
        html += '<input type="text" id="game" name="game">';
        html += '<input type="text" id="players" name="players">';
        html += '<input type="submit" id="sendJSON">';
        html += '</form>';

        document.getElementById('formData').innerHTML = html;
        document.getElementById('game').value = gameData;
        document.getElementById('players').value = playerData;
        document.getElementById('sendJSON').click();
    }
};