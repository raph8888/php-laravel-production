<!DOCTYPE html>
<html lang="en">
<head>
    <title>Copiadora Montes Claros</title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta name="description" content="Copiadora Montes Claros é a mais tradicional copiadora da cidade. 
    Cópias, plastificação, encadernação, reforma de livros e documentos, envio de fax, impressão e digitalização 
    de documentos.">

    <meta name="csrf-token" content="{{ csrf_token() }}"/>

    <link href="https://fonts.googleapis.com/css?family=Raleway:300,400,500,700" rel="stylesheet" type="text/css">
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css" rel="stylesheet"
          type="text/css">
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css" rel="stylesheet" type="text/css">
    <link rel='stylesheet' href='http://codepen.io/assets/libs/fullpage/jquery-ui.css'>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.0.0-alpha1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
    <link rel="stylesheet" type="text/css" href="style/style.css">
    <?php $dayid = "li-" . date('d-m-Y'); ?>
    <style>

        .tabelaacesso {
            padding-left: 60px;
        }

        #<?php echo $dayid; ?> {
        background-color: #7092BE !important;
        color:white !important;}
        .end {
            background-color: #E0D4D4 !important;
        }

    </style>

    <script>
        $(function () {
            $('#task-name').focus();
        });
    </script>


    <!-- jQuery library -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>

    <!-- Latest compiled JavaScript -->
    <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>

    <script>
        $(function () {

            /*  $(".first").hide();
             $(".second").hide();
             $(".third").hide();*/

            $(".primeiro").hide();
            $(".segundo").hide();
            $(".terceiro").hide();
            $(".quarto").hide();
            $(".quinto").hide();
            $(".sexto").hide();
            $(".setimo").hide();
            $(".oitavo").hide();
            $(".nono").hide();

            setTimeout(function () {
                $(".primeiro").fadeIn(2000);
            }, 300);

            setTimeout(function () {
                $(".segundo").fadeIn(2000);
            }, 800);

            setTimeout(function () {
                $(".terceiro").fadeIn(2000);
            }, 1300);

            setTimeout(function () {
                $(".quarto").fadeIn(2000);
            }, 1800);

            setTimeout(function () {
                $(".quinto").fadeIn(2000);
            }, 2300);

            setTimeout(function () {
                $(".sexto").fadeIn(2000);
            }, 2800);

            setTimeout(function () {
                $(".setimo").fadeIn(2000);
            }, 3300);

            setTimeout(function () {
                $(".oitavo").fadeIn(2000);
            }, 3800);

            setTimeout(function () {
                $(".nono").fadeIn(2000);
            }, 4300);
        });
    </script>

    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    </script>


    <script src="https://maps.googleapis.com/maps/api/js"></script>

</head>

<body>


<div class="container">


    <div class="row">
        <div class="col-xs-12">
            <a href="http://copiadoramoc.com/public/flush" title="Sair da Área Administrativa"><p
                        style="float:right; padding-right: 20px; padding-top: 20px;">Sair da Área Administrativa</p>
            </a>
        </div>
    </div>


    <div class="row">
        <div class="hidden-xs col-md-2">
            <img src="images/Untitled.png" style="width: 100%; max-width: 180px;">
        </div>
        <div class="col-xs-12 col-md-8 text-center">
            <a href="http://copiadoramoc.com/public/" align="center"
               style="text-decoration: none; color: #5196D5;">
                <h1>Copiadora Montes Claros</h1>
            </a>
            <a href="http://copiadoramoc.com/public/status"><h2>Área Administrativa</h2></a>

        </div>
        <div class="hidden-xs col-md-2">
            <img src="images/Untitled.png" style="width: 100%; max-width: 180px;">
        </div>
    </div>

</div>

@yield('content')

<br><br><br><br><br><br>

<div class="text-center"><p class="text-center">Rua Coronel Altino de Freitas, 399 - Montes Claros - MG, 39400-023</p>

    <p>(38) 3221-0798</p></div>

<!--<br><br><br><a href="loginadmin.php"><p style="float:right;">acesso administrativo</p></a>-->
<br><br><br>

</body>
</html>