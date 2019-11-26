window.onload = function() {
    Game.jsonGet();
    Game.log();
    startUp();
};

function createEvents () {
    document.getElementById('btnEndTurn').onclick = function() {
        Game.turnSwitch();
        Game.jsonSet();
    };
}

function startUp() {
    if (Game.players[Game.turn].moved === 'false') {
        createMoveOptionsMenu();
    } else {
        // Create secret passage logic
    }
}

//==============================================================
// FOR JOHN -- | NEXT TURN FUNCTION | --
//==============================================================
function createNextTurn() {
    var btnNextTurn = document.getElementById('btnNextTurn');
    btnNextTurn.onclick = function() {
        Game.movedSwitch();
        Game.turnSwitch();
        Game.jsonSet();
    }
}

// Generates move options screen and creates click events
// for the buttons
function createMoveOptionsMenu() {
    var rooms = ['Ballroom', 'Billiard Room', 'Lounge'];
    var secretPassage =
        (rooms.indexOf(Game.players[Game.turn].room) > -1);
    var html = '';

    html += '<button id="btnMove" class="btn btn-block ';
    html += 'btn-sm btn-dark">Move</button>';
    if (secretPassage) {
        html += '<button id="btnSecret" class="btn btn-block ';
        html += 'btn-sm btn-dark">Secret Passage</button>';
    }

    document.getElementById('divControlsInterface').innerHTML = html;

    // When this click event is triggered a dice roll is
    // simulated and the current player's roll property is updated.
    document.getElementById('btnMove').onclick = function() {
        var roll = Math.floor(Math.random() * 6) + 1;
        roll += Math.floor(Math.random() * 6) + 1;
        Game.players[Game.turn].roll = roll;
        Game.moveSwitch();
        Game.log();
        createMoveOnBoardMenu();
    };

    if (secretPassage) {
        // When this click event is triggered the secret passage
        // options menu is created.
        document.getElementById('btnSecret').onclick = function() {
            Game.moveSwitch();
        };
    }
}

function createMoveOnBoardMenu() {
    var roll = Game.players[Game.turn].roll;
    var html = '<div class="row"><div class="col-12 col-sm-6">';
    html += '<label id="lblRoll"></label></div>';
    html += '<div class="col-12 col-sm-6">';
    html += '<label id="lblMoves"></label>';
    html += '</div><div class="col-12">';
    html += '<button id="btnEndMove" class="btn btn-block btn-sm ';
    html += 'btn-success">End Move</button></div></div>';

    document.getElementById('divControlsInterface').innerHTML = html;

    document.getElementById('lblRoll').innerHTML = 'Roll | ' + roll;
    document.getElementById('lblMoves').innerHTML = 'Moves | 0';

    // When this click event is triggered the player's move is
    // completed and the 'moved' property is set to true.
    // Which signifies the players move is complete and the
    // 'move' property is set to false which signifies the
    // player cannot move on the board anymore on this turn.
    document.getElementById('btnEndMove').onclick = function() {
        Game.moveSwitch();
        Game.movedSwitch();
        Game.jsonSet();
    };
}

function createSecretPassageMenu() {
    var html = '';
    html += '<select id="selSecretPassage" ';
    html += 'class="form-control form-control-sm">';
    html += '</select><br>';
    html += '<button id="btnEndTurn" class="btn btn-block ';
    html += 'btn-sm btn-success">End Turn</button>';

    document.getElementById('divControlsInterface').innerHTML = html;

    var select = document.getElementById('selSecretPassage');
    var rooms = ['Ballroom', 'Billiard Room', 'Lounge'];
    var room = Game.players[Game.turn].room;

    for(var i = 0; i < room.length; ++i) {
        if (rooms[i] !== room) {
            select.innerHTML += '<option>' + room + '</option>';
        }
    }

}

// Note:
// Remember that the turn switches when the player ends their turn.
// The turn does not switch when the move is finished.
//
// Note:
// The current move logic is this:
// Player either rolls dice, use a secret passage
//     - If the player rolls the dice the logic to move around the board
//       if executed.
//     - If ((player[turn].moved === 'false') && (roomhasSecretPassage(player[turn].room))
//       add option to use the secret passage way
//     - If (player[turn].room !== player[turn].lastRoom)
//
//
//
//