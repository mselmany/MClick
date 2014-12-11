$(document).ready(function () {

     var counter = 0;
     var IPBanStatus = false;
    var base_url = 'app/';
    
     
    function guncel(dataKullan){
         $.ajax({ 
                    type:'POST', 
                    url:'app/dene.php',  		
                    success:function(cevap){
                        var json_obj = $.parseJSON(cevap);                     
                                               
                        dataKullan(json_obj);
                       
                    }
                });
    }
     
   var sonuc = guncel(function(res){
       
        counter = res.SAYAC;
        IPBanStatus = !res.BAN;
        Request.print(counter);
        console.log(counter+"-"+IPBanStatus);
    });
    
     
    
    
    var digitLength = function(a){
        return a.toString().length;
    }
    var reverseDigits = function(a){
        return a.toString().split('').reverse().join('');
    }


    var Request = {
                    
        print : function(c){
            for( var d = 1; d <= digitLength(c); d++ ){
                var $elemClasses = document.getElementById("digit-" + d ).className;
                $elemClasses = "";
                $elemClasses += " is-n-"+reverseDigits(c).substring(d - 1, d);
                $("#digit-" + d ).removeClass().addClass($elemClasses);
            }
        },
        sending : function (){
            if( IPBanStatus === false ) $("body").removeClass("lost won").addClass("sent");
            return IPBanStatus = true;
        },
        result : function (a){ // a:true/won or false/lost
            if( a === false ) {
                $("body").removeClass("sent won").addClass("lost");
            } else if( a === true ) {
                $("body").removeClass("sent lost").addClass("won");
                $(".winner-count").text(counter);
                $("#coupon-codes #coupon-name").text("250TL-TEKNOSA");
                $("#coupon-codes #coupon-code").text("ABCD-EFGH-1234-0000");
            }
            return false;
        },
        reset : function (){
            $("body").removeClass("lost won sent");
            return IPBanStatus = false;
        }
        
    }
    


    /*
    setInterval(function(){
        Request.init(++counter);
    },1000);
    */
  
    
    $("#click").on("click",function(){

            //Request.sync();
           guncel(function(res){
       
        counter = res.SAYAC;
        IPBanStatus = !res.BAN;
        
        if( IPBanStatus === false ){
            $("body").removeClass("button-more-is-active");

                       
            Request.print(counter);

            
            Request.sending();

            setTimeout(function(){

                if( counter%2 === 1 ) Request.result(false); 
                else Request.result(true);
                //return false;
                setTimeout(function(){
                    Request.reset();
                },1500);

            },1500);
            

        }else return false;
    });
       

        //$(".status").text(counter +" , "+ digitLength(counter) +" - "+ reverseDigits(counter) +" (  "+ $elemClasses +"  ) ");

    });

    $(".tab-title").on("click",function(){
        var $tabIndex = $(this).index();
        if( !$("#down-content").hasClass("tab-"+($tabIndex+1)) && $tabIndex+1 ){
            $("#down-content").removeClass().addClass("tab-"+($tabIndex+1));
        } 
        return false;
    });

    $(".more").on("click",function(){
        $("body").toggleClass("button-more-is-active");
    });












});

