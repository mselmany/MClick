$(document).ready(function () {

    var obj = function(){
        var _counter;
        var _couponCode;
                    
    }
    
   
     $("#submit-time").on("click", function (e) {
        
        var $timeInput = $("#time-input").val();

        if ($timeInput === "") {
            e.preventDefault();
            alert("Süre giriniz (Dakika cinsinden giriniz).");
            return false;
        } else {
            var r = confirm("Kullanıcıların banlanma süresi "+ $timeInput +" dakika olarak değiştirilecektir.Emin misiniz?");
            if (r === true) {
                $("#time").html($timeInput);
            } else return false;
        }

    });
    
    
    $("#submit-form").on("click", function (e) {
        
        var $counterInput = $("#counter-input").val();
        var $couponCodeInput = $("#coupon-code-input").val();
        var $couponNameInput = $("#coupon-name-input").val();

        if ($counterInput === "" || $couponCodeInput === "" || $couponNameInput === "") {
            e.preventDefault();
            alert("Tık sırasını, Kupon adını ve Kupon kodunu giriniz.");
            return false;
        } else {
            var r = confirm("Tık sırası : " + $counterInput + "\nKupon adı : " + $couponNameInput + "\nKupon kodu : " + $couponCodeInput + "\nBilgiler veri tabanına eklenecek.Emin misiniz?");
            if (r == true) {
                $("#list-block").append('<li class="list block"><span class="counter">' + $counterInput + '</span><span class="coupon-name">' + $couponNameInput + '</span><span class="coupon-code">' + $couponCodeInput + '</span><span class="remove-code">Sil</span></li>');
            } else return false;
        }

    });


    $("#counter-input,#time-input").keyup(function (e) {

        if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
            alert("Sadece rakam girmelisiniz.");
            return $(this).val("");
        }
        if (parseInt($(this).val()) > 1000000) {
            alert("1 ile 1 milyon arasında sayı girmelisiniz.");
            return $(this).val(1000000);
        }

    });
    
    $("#coupon-name-input,#coupon-code-input").keyup(function (e) {

        if ($(this).val().length > 20) {
            alert("En fazla 20 karakter girebilirsiniz.");
            return $(this).val($(this).val().substring(0,20));
        }

    });

    
    $(".remove-code").on("click",function(){
        var r = confirm("Bilgiler veri tabanından silinecek.Emin misiniz?");
        if (r == true) {
            $(this).parent(".list.block").remove();
        } else return false;
    });
    


});

