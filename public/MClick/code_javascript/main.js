$(document).ready(function() {
    var foo = function() {
        var counter = 0;
        var IPBanStatus = false;
        var odulAdi = '';
        var kupon = '';
        var kazandiMi;
       
    }

        function btnClicked() {
            $.ajax({
                type: 'POST',
                url: 'MClick/clicked',
                success: function(cevap) {
                    var res = $.parseJSON(cevap);
                    foo.odulAdi = res.odulAdi;
                    foo.kazandiMi = res.kazandiMi;
                    foo.kupon = res.kupon;
                    foo.IPBanStatus = res.yasakMi;
                    foo.counter = res.sayac;
                        console.log(foo.odulAdi + "-" + foo.kazandiMi + "-" +foo.kupon + "-" + foo.IPBanStatus );
                    //Request.print(foo.counter);
                }
            });
        }
    
    
    
    
        (function guncel() {
            $.ajax({
                type: 'POST',
                url: 'MClick/preLoad',
                success: function(cevap) {
                    var res = $.parseJSON(cevap);
                    foo.counter = res.sayac;
                    foo.IPBanStatus = res.yasakMi;
                    console.log(foo.counter + "-" + foo.IPBanStatus);
                    Request.print(foo.counter);
                }
            });
        })();
    
    (function poll() {
        setTimeout(function() {
            $.ajax({
                url: "MClick/preLoad",
                success: function(data) {
                    Request.print(data.sayac);
                },
                dataType: "json",
                complete: poll
            });
        }, 3000);
    })();
        
    
    
    var digitLength = function(a) {
        return a.toString().length;
    }
    var reverseDigits = function(a) {
        return a.toString().split('').reverse().join('');
    }
    var Request = {
        print: function(c) {
            for(var d = 1; d <= digitLength(c); d++) {
                var $elemClasses = document.getElementById("digit-" + d).className;
                $elemClasses = "";
                $elemClasses += " is-n-" + reverseDigits(c).substring(d - 1, d);
                $("#digit-" + d).removeClass().addClass($elemClasses);
            }
        },
        sending: function() {
            if(foo.IPBanStatus === false) $("body").removeClass("lost won").addClass("sent");
            return foo.IPBanStatus = true;
        },
        result: function(a,odulAdi,kupon) { // a:true/won or false/lost
            if(a === false) {
                $("body").removeClass("sent won").addClass("lost");
            } else if(a === true) {
                $("body").removeClass("sent lost").addClass("won");
                $(".winner-count").text(counter);
                $("#coupon-codes #coupon-name").text(odulAdi);
                $("#coupon-codes #coupon-code").text(kupon);
            }
            return false;
        },
        reset: function() {
            $("body").removeClass("lost won sent");
            return foo.IPBanStatus = false;
        }
    }
    
    
    
    
    
    
    
    
    
    
    $("#click").on("click", function() {
        btnClicked();
        if(foo.IPBanStatus === false) {
            $("body").removeClass("button-more-is-active");
            Request.sending();
            
            setTimeout(function() {
                Request.print(foo.counter);
            }, 1500);            
            
        } else 
            return false;
    });
    
    
    
    
    
    
    
    
    
    
    
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