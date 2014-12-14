$(document).ready(function() {
    
    var foo = function() {
        var counter;
        var IPBanStatus = false;
        var odulAdi = '';
        var kupon = '';
        var kazandiMi;
    }
    
        function btnClicked() { // butona tıklanınca
            
            $.ajax({
                type: 'POST',
                url: 'MClick/clicked',
                success: function(cevap) {
                    var res = $.parseJSON(cevap);
                    foo.kazandiMi = res.kazandiMi;
                    foo.odulAdi = res.odulAdi;
                    foo.kupon = res.kupon;
                    foo.IPBanStatus = res.yasakMi;
                    foo.counter = res.sayac;
                    
                    console.log("btnClicked() çalıştı \n ### kazandiMi: " + foo.kazandiMi + "\n --- counter: "+foo.counter + "\n --- odulAdi: " + foo.odulAdi + "\n --- kupon: " + foo.kupon + "\n --- kazandiMi: " + foo.kazandiMi + "\n --- IPBanStatus: " + foo.IPBanStatus);

                    Request.result(foo.kazandiMi);
                }
            });
            
        }
    
    
        (function guncel() { // sayfaya girdiğinde ve yenilediğinde
            $.ajax({
                type: 'POST',
                url: 'MClick/preLoad',
                success: function(cevap) {
                    var res = $.parseJSON(cevap); 
                    foo.kazandiMi = res.kazandiMi;
                    foo.odulAdi = res.odulAdi;
                    foo.kupon = res.kupon;
                    foo.IPBanStatus = res.yasakMi;
                    foo.counter = res.sayac;
                    
                    console.log("guncel() çalıştı \n kazandiMi: " + foo.kazandiMi + "\n counter: " + foo.counter + "\n IPBanStatus: " + foo.IPBanStatus);
                    
                    Request.print(foo.counter); // counter ı ekrana yazdır
                    Request.state(foo.IPBanStatus,foo.kazandiMi); // ban durumunu ve kazandıyda o ekranda kalmasını sağla - eğer kazanmadıysa ban zamanı kalkınca butonu tıklanabilir haline getir
                }
            });
        })();
    
     
        (function poll() { // her üç saniyede bir server dan
            setTimeout(function() {
                $.ajax({
                    url: "MClick/preLoad",
                    success: function(data) {
                        
                        foo.IPBanStatus = data.yasakMi;
                        foo.counter = data.sayac;
                        
                        console.log("poll() çalıştı \n kazandiMi: " + foo.kazandiMi + "\n counter: "+data.sayac + "\n IPBanStatus: " + data.yasakMi);
                        
                        Request.print(foo.counter); // counter ı ekrana yazdır
                        Request.state(foo.IPBanStatus,foo.kazandiMi); // 3 snyede bir ban durumunu ve kazandıyda o ekranda kalmasını sağla - eğer kazanmadıysa ban zamanı kalkınca butonu tıklanabilir haline getir
                    },
                    dataType: "json",
                    complete: poll
                });
            }, 3000);
        })();
     
    
    
    
    var digitLength = function(a) { // Request.print ile ilgili
        return a.toString().length;
    }
    var reverseDigits = function(a) { // Request.print ile ilgili
        return a.toString().split('').reverse().join('');
    }
    var Request = {
        print: function(c) { // sadece serverdan alınan counter ı ekrana css class ları ile gösterir
            for(var d = 1; d <= digitLength(c); d++) {
                var $elemClasses = document.getElementById("digit-" + d).className;
                $elemClasses = "";
                $elemClasses += " is-n-" + reverseDigits(c).substring(d - 1, d);
                $("#digit-" + d).removeClass().addClass($elemClasses);
            }
        }/*,
        sending: function(a) { 
            if(a === false) $("body").removeClass("lost won").addClass("sent");
        }*/,
        result: function(a) { // a:true/won or false/lost
            if(a === false) { // kazanmadıysa
                setTimeout(function() { // 1.5 snye sonra
                    $("body").removeClass("sent won").addClass("lost"); // olmadı butonunu göster
                }, 1500);
            } else if(a === true) { // kazandıysa
                setTimeout(function() {
                    $("body").removeClass("sent lost").addClass("won"); // kazandı butonunu ve bilgileri göster
                    $(".winner-count").text(foo.counter);
                    $("#coupon-codes #coupon-name,.coupon-owner").text(foo.odulAdi);
                    $("#coupon-codes #coupon-code").text(foo.kupon);
                }, 1500);
            }
        },
        state: function(a,b) { // a:IPBanStatus b:kazandiMi
            
            if( a === true ) { // banlı ise
                if( b === false || b === undefined ){ // ve kazanmamışsa 
                    $("body").removeClass("sent won").addClass("lost"); // olmadı butonunu göster
                } else if( b === true ){ // veya kazanmışsa 
                    $("body").removeClass("sent lost").addClass("won"); // kazandı ekranını ve bilgileri göster
                    $(".winner-count").text(foo.counter);
                    $("#coupon-codes #coupon-name,.coupon-owner").text(foo.odulAdi);
                    $("#coupon-codes #coupon-code").text(foo.kupon);
                }
            } else { // banlı değilse
                if( b === false || b === undefined ){ // ve kazanmamışsa
                    $("body").removeClass("sent won lost"); // banlı olmadığı için tekrar butona basabilmek için butonu ilk haline geçir
                }
            } 
            
            /*
              if( a === true ) {
                $("body").removeClass("sent won").addClass("lost");
            } else {
                $("body").removeClass("sent won lost");
            } 
              
              -----------
            
             if( a === false && b === true ) {
                $("body").removeClass("sent won").addClass("lost");
            } else if( a === false && b === false ) {
                $("body").removeClass("sent won lost");
            } else if( a === true ) {
                $("body").removeClass("sent lost").addClass("won");
                $(".winner-count").text(counter);
                $("#coupon-codes #coupon-name,.coupon-owner").text(foo.odulAdi);
                $("#coupon-codes #coupon-code").text(foo.kupon);
            } 
             */
        }
    }
        
    
    $("#click").on("click", function() {
        
        if( foo.IPBanStatus === false && ( foo.kazandiMi === undefined || foo.kazandiMi === false ) ) { // banlı değilken ve kazanmamışken buton tıklama aktif
            $("body").removeClass("button-more-is-active"); // alttaki alanı gizle
            
            console.log("Tıklandı");
            
            $("body").removeClass("lost won").addClass("sent"); // çekiliyor butonuna geç
            
            Request.print(++foo.counter); // serverdan bağımsız counterı burda artır (sadece anında görüntü için)
                        
            btnClicked(); // server işlerini yap
            
        } else return console.log("Bloklusun");
    });
    
    
    
    window.onbeforeunload = function (e) {
        e = e || window.event;
        if( foo.kazandiMi === true ){
        // For IE and Firefox prior to version 4
        if (e) {
            e.returnValue = "Çıkarsanız kazandığınız kupon bilgileri kaybolacak.Çıkmak istediğinizden emin misiniz?";
        }
        // For Safari
        return "Çıkarsanız kazandığınız kupon bilgileri kaybolacak.Çıkmak istediğinizden emin misiniz?";
        }
    };
    
    
    
    
    
    
    
    
    
    $(".tab-title").on("click", function() {
        var $tabIndex = $(this).index();
        if(!$("#down-content").hasClass("tab-" + ($tabIndex + 1)) && $tabIndex + 1) {
            $("#down-content").removeClass().addClass("tab-" + ($tabIndex + 1));
        }
        return false;
    });
    $(".more").on("click", function() {
        $("body").toggleClass("button-more-is-active");
    });
});