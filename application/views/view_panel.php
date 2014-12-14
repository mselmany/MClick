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

    <body>

        <div class="top-field">

            <header class="header">
                <p class="header-title"><a href="#">1MClick</a></p>
                <p class="header-description">Panel - Kupon kodu ekleme/çıkarma</p>
            </header>
            
            <div class="panel-field">
                
                
                <div class="block-field counter-field">
                    <span id="show-counter">Sayaç : <?php echo $sure->sayac; ?></span> <!--sayıcın görüntüsü-->
                </div>
                
                <?php //foreach($data as $kupon):?>
                
               <div class="block-field time-field">
                   <ul class="list-title">
                       <li class="list title"><span class="coupon-name">Bloklama Süresi</span>
                       </li>
                   </ul>
                   <ul class="list-block">
                       <li class="list block"><span id="time"><?php echo $sure->dakika; ?></span> <!--#time ı buraya çek-->
                       </li>
                   </ul>
                   <ul class="input-block">
                       <li class="list">
                           <form action="<?php echo base_url().'MClick/sureUpdate' ?>" method="POST">
                               <input name="sure" type="number" id="time-input" min="1" max="1000000" placeholder="Süre girin(dk)">
                               <input type="submit" id="submit-time" value="Değiştir">
                           </form>
                       </li>
                   </ul>
                </div>
                
                <div class="block-field counter-reset-field">
                    <ul class="list-title">
                        <li class="list title"><span class="coupon-name">Sayaç Sıfırlama</span>
                        </li>
                    </ul>
                    <ul class="list-block">
                        <li class="list block"><span id="reset-counter">Sayaç : <?php echo $sure->sayac; ?></span> <!--sayacı ı buraya çek-->
                        </li>
                    </ul>
                    <ul class="input-block">
                        <li class="list">
                            <form action="<?php echo base_url().'MClick/sifirla' ?>" method="POST">
                                <input type="submit" id="submit-reset-counter" value="Sıfırla">
                            </form>
                        </li>
                    </ul>
                </div>
                
                <?php //endforeach; ?>
               
                <div class="block-field codes-field">
                    <ul class="list-title">
                       <li class="list title"><span class="counter">Tık Sırası</span><span class="coupon-name">Kupon Adı</span><span class="coupon-code">Kupon Kodu</span></li>
                    </ul>
                    <?php foreach($data as $kupon):?>
                    <ul class="list-block" id="list-block">
                        <li class="list block">
                            <span class="counter"><?php echo $kupon['kuponSayac']; ?></span>
                            <span class="coupon-name"><?php echo $kupon['odulAdi']; ?></span>
                            <span class="coupon-code"><?php echo $kupon['kuponKodu']; ?></span>
                            <span class="remove-code"><a href="<?php echo base_url().'MClick/del/'.$kupon['kuponSayac']; ?>">Sil</a></span>       
                        </li>                          
                    </ul>   
                    <?php endforeach; ?>
                    <ul class="input-block">
                        <li class="list">
                            <form action="<?php echo base_url().'MClick/add' ?>" method="POST">
                                <input name="kuponSayac" type="number" id="counter-input" min="1" max="1000000" placeholder="Sıra Girin">
                                <input name="odulAdi" type="text" id="coupon-name-input" placeholder="Kupon adını girin">
                                <input name="kuponKodu" type="text" id="coupon-code-input" placeholder="Kupon kodunu girin">
                                <input name="gonder" type="submit" id="submit-form" value="Kodu ekle">
                                <?php echo validation_errors(); ?>
                            </form>
                        </li>
                    </ul>
                    
                </div>
            </div> 

             

        </div>

        

    </body>

</html>