<!--
To change this template use Tools | Templates.
-->
<!DOCTYPE html>
<html>
    <?php $path = base_url();  ?>
<head>
    <title>Clicked</title>
    <script src="<?php echo $path ?>public/MClick/code_javascript/jquery.min.js"></script>
</head>
<body>
    <div id="click" class="click"> Tikla </div>
    <script>
        
        //var counter = 0;
        
        var foo = function(){
            var counter = 0;
            var IPBanStatus = false;
        }
                
        function guncel(dataKullan){
         $.ajax({ 
                    type:'POST', 
                    url:'<?php echo base_url(); ?>MClick/preLoad',  		
                    success:function(cevap){
                        var res = $.parseJSON(cevap);                     
                                    
                         foo.counter = res.sayac;
                         foo.IPBanStatus = res.yasakMi;
                        console.log(foo.counter+"-"+foo.IPBanStatus);
                        //$("#click").text(foo.counter+"-"+foo.IPBanStatus);
                        //dataKullan(json_obj);
                       
                    }
                });
    }
        guncel();
     
//         var sonuc = guncel(function(res){
       
//         foo.counter = res.sayac;
//         foo.IPBanStatus = res.yasakMi;
//         //Request.print(counter);
//         console.log(foo.counter+"-"+foo.IPBanStatus);
//             $("#click").text(foo.counter);
//     });
        
        
     $("#click").on("click",function(){

            //Request.sync();
           guncel(function(res){
                                                                  
        counter = res.SAYAC;
        IPBanStatus = res.BAN;
               
           console.log(counter+"-"+IPBanStatus);
           });
        });
</script>
</body>
</html>