<?php
session_start();

include_once('php/dice.php');
include_once('php/checklist.php');
include_once('php/functions.php');
include_once('php/dbConnect.php');
include_once('php/sql.php');
include_once ('php/notebook.php');
include_once ('php/sessionInit.php');
include_once ('php/sessionGet.php');
//include_once ('php/sessionSet.php');
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <!-- meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Clue Web App">
    <meta name="author" content="Bryce Moore, Ryan Johns, John Lougee">

    <!-- boostrap.css -->
    <link rel="stylesheet"
          href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"
          integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm"
          crossorigin="anonymous">

    <!-- Custom styles for this template -->
    <link rel="stylesheet" href="css/style.css" />

    <!-- Custom styles for this template -->
    <link rel="icon" type="img/png" href="favicon.png" />

    <!-- font-awesome.css -->
    <link rel="stylesheet"
          href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" />

    <title>NEIT | Clue</title>
</head>

<body>

<!-- navigation -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
    <a class="navbar-brand" href="index.php">
        <img src="favicon.png" width="30" height="30" class="d-inline-block align-top" alt="">
        NEIT
    </a>
</nav>

<!-- page content -->
<main class="container pt-5">
    <header class="row">
        <div class="col-lg-12">
            <h1 class="mt-4">Clue</h1>
            <p class="lead">by Bryce Moore, Justin Ferris, Angie Bustillo-Well and John Lougee</p>
            <hr>
        </div>
    </header>
    <section class="row" id="game-screen">
        <div class="col-6">
            <div class="row">
                <div class="col-12">
                    <canvas></canvas>
                </div>
            </div>
            <div id="dice" class="row">
                <div class="col-4">
                    <input type="text" id="die-a"
                           class="form-control form-control-sm text-center"
                    value="<?php echo $dice['a'] ?>">
                </div>
                <div class="col-4">
                    <input type="text" id="die-b"
                           class="form-control form-control-sm text-center"
                           value="<?php echo $dice['b'] ?>">
                </div>
                <div class="col-4">
                    <form method="post" action="index.php">
                        <button id="btn-roll" class="btn btn-block btn-sm btn-dark">
                            Roll
                        </button>
                        <input type="text" id="roll" name="roll" value="roll" hidden>
                    </form>
                </div>
            </div>
            <br>
            <br>
            <div id="selector" class="row">
                <?php include_once('php/guess-accuse.php') ?>
            </div>
        </div>

        <div class="col-6">


            <?php echo createTables($_SESSION['game']['gameId'], $_SESSION['game']['turn']) ?>


        </div>

    </section>
	<br />
<br />

</main><!-- /.container -->

<!-- jQuery-3.2.1.slim.min.js -->
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"
        integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN"
        crossorigin="anonymous"></script>

<!-- popper.js -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"
        integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q"
        crossorigin="anonymous"></script>

<!-- boostrap.js -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"
        integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl"
        crossorigin="anonymous"></script>

<!-- custom javascript -->
<script src="js/tile.js"></script>
<script src="js/board.js"></script>
<script src="js/index.js"></script>

<script>
    $(document).ready(function() {
        $('#showCards').hide();

        $('#btn-card1').click(function (e) {
//            //var chosenCard = $(e.target).val();



            var chosenCard = $('#txt-card1').val();
            $('#txt-chosenCard').val(chosenCard);
//            $("#imageCard1").attr('src',"img/Cards/" + chosenCard + ".jpg");
            $("#imageCard2").attr('src', "img/Cards/cardBack.jpg");
            $("#btn-card1").text("Card Chosen");
            $("#btn-card2").hide();
        });

        $('#btn-card2').click(function (e) {
            //var chosenCard = $(e.target).val();


            var chosenCard = $('#txt-card2').val();
            $('#txt-chosenCard').val(chosenCard);
//
//            $("#imageCard2").attr('src',"img/Cards/" + chosenCard + ".jpg");
            $("#imageCard1").attr('src', "img/Cards/cardBack.jpg");
            $("#btn-card2").text("Card Chosen");
            $("#btn-card1").hide();
        });

        $('#btn-showChoose').click(function (e) {
            $('#showCards').toggle();
        });

        $('#btn-chooseClose').click(function (e)
        {
            if(!empty('#txt-chosenCard')) {
                var chosenCard = $('txt-card1').val();
            }
            else if(!empty('#txt-chosenCard')) {
                var chosenCard = $('txt-card2').val();
            }

           $('#showCards').hide();
        });
    });
</script>
</body>


</html>