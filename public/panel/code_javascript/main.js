$(document).ready(function () {

    
   
    $("#submit-form").on("click",function(e){
        e.preventDefault();
        var $counterInput = $("#counter-input").val();
        var $couponCodeInput = $("#coupon-code-input").val();
        
        if( $counterInput === "" || $couponCodeInput === "" ){
            alert("Tık sırasını ve Kupon kodunu giriniz.");
            return false;
        }else{
            var r = confirm("Tık sırası : "+$counterInput+"\nKupon kodu : "+$couponCodeInput+"\nBilgiler veri tabanına eklenecek.Emin misiniz?");
            if (r == true) {
                $("#list-block").append('<li class="list block"><span class="counter">'+$counterInput+'</span><span class="coupon-code">'+$couponCodeInput+'</span></li>');
            } else return false;
        }
        
        
        
        /*
        $("#list-block > .list.block").each(function(){
            if( $counterInput === $(this).find(".counter").text() ) $counterChecker = "counterExist";
            else $counterChecker = "counterNoneExist";
            if( $couponCodeInput === $(this).find(".coupon-code").text() ) $couponcodeChecker = "couponcodeExist";
            else $couponcodeChecker = "couponcodeNoneExist";
        });
        
        if( $counterInput === "" || $couponCodeInput === "" ){
            alert("Tık sırasını ve Kupon kodunu giriniz.");
            return false;
        }else if( $counterChecker === "counterExist" && $couponcodeChecker === "couponcodeExist" ){
            alert("Tık sırası ve Kupon kodu zaten mevcut.Lütfen değiştiriniz.");
            return $("#counter-input,#coupon-code-input").val("");
        }else if( $counterChecker === "counterExist" ){
            alert("Tık sırası zaten mevcut.Farklı bir sıra giriniz.");
            return $("#counter-input").val("");
        }else if( $couponcodeChecker === "couponcodeExist" ){
            alert("Kupon kodu zaten mevcut.Farklı bir kod giriniz.");
            return $("#coupon-code-input").val("");
        }else{
            $("#list-block").append('<li class="list block"><span class="counter">'+$counterInput+'</span><span class="coupon-code">'+$couponCodeInput+'</span></li>');
        }
        */
        
    });



    
    $("#counter-input").keyup(function (e) {

        if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
            alert("Sadece rakam girmelisiniz.");
            return $(this).val("");
        }
        if (parseInt($(this).val()) > 1000000) {
            alert("1 ile 1 milyon arasında sayı girmelisiniz.");
            return $(this).val(1000000);
        }

    });






});

