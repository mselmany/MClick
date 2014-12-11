<!DOCTYPE html>
<html>
                    <?php $path = base_url();  ?>
    <head>
        <link href="http://fonts.googleapis.com/css?family=Source+Sans+Pro:300,600,900|Playfair+Display:400,900|Montserrat:400,700|Raleway:300,900|Lato:300,900|Nunito:300,700|Open+Sans:300italic,400italic,400,600,700,800&subset=latin,latin-ext" rel="stylesheet" type="text/css">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
        <meta name="apple-mobile-web-app-capable" content="yes">
        <meta name="description" content="" />
        <meta charset=utf-8 />
        <script src="<?php echo $path ?>public/MClick/code_javascript/jquery.min.js"></script>
        
        <link rel="stylesheet" href="<?php echo $path ?>public/panel/code_css/css.css">
        <script src="<?php echo $path ?>public/panel/code_javascript/main.js"></script>
        <title>1MClick</title>
    </head>

    <body class="mode-1">
        <button class="status"></button>

        <div class="top-field">

            <header class="header">
                <p class="header-title"><a href="">1MClick</a></p>
                <p class="header-description">Panel - Kupon kodu ekleme/çıkarma</p>
            </header>
            
            <div class="panel-field">
                <ul class="list-title">
                   <li class="list title"><span class="counter">Tık Sırası</span><span class="coupon-code">Kupon Kodu</span></li>
                </ul>
                <ul class="list-block" id="list-block">
                    <li class="list block"><span class="counter">23475</span><span class="coupon-code">ABCDEFGH12345678</span></li>
                </ul>
                <ul class="input-block">
                    <li class="list">
                        <form action="#" method="POST">
                            <input type="number" id="counter-input" min="1" max="1000000" placeholder="Sıra Girin"><input type="text" id="coupon-code-input" placeholder="Kupon kodunu girin"><input type="submit" id="submit-form" value="Kodu ekle">
                        </form>
                    </li>
                </ul>
            </div>

            

        </div>

        

    </body>

</html>