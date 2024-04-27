<!DOCTYPE html>
<html>
    <head>
    	<title>ETH Contract Platform | Wallet</title>
        <meta charset="UTF-8">
        <link href="./assets/bootstrap.min.css" rel="stylesheet" />
        <link href="./assetsjquery.datetimepicker.min.css" rel="stylesheet" />
        <link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" 
            rel="stylesheet" 
            async
            integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" 
            crossorigin="anonymous"  
        />
        <script src="./assets/jquery.min.js"></script>
        <script src="./assets/angular.min.js"></script>
        <script src="./assets/underscore.js"></script>
        <script src="./assets/moment.js"></script>
        <script src="./assets/web3.min.js"></script>
        <script src="./assets/bootstrap.bundle.min.js">
        </script>
        <style type="text/css">
        	body{
        		background: #f4f4f4;
        	}
        </style>
    </head>

    <body >
        <?php require("contractv1.php") ?>
        <script type="text/javascript">
            var APP_CONF={
                APP_MODE: 'online',
            };

            const appModule = angular.module('app', []);
            window.appModule = appModule;
            window.AUTH={token: ""}

            function randomId(length) {
                var chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOP1234567890";
                var pass = "";
                for (var x = 0; x < length; x++) {
                    var i = Math.floor(Math.random() * chars.length);
                    pass += chars.charAt(i);
                }
                return pass;
            }

            window.APP_CONF=APP_CONF;

            $(document).ready(function(){
                setTimeout(function () {
                    angular.bootstrap(document, ['app']);
                }, 25);
            });
        </script>

		<?php require("./templates/navbar.php") ?>
		<?php require("./templates/wallet.php") ?>

        <script src="./assets/typeahead.bundle.js"></script>
  </body>
</html>