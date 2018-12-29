$(document).ready(function(){
	"use strict";
    
        /*==================================
* Author        : "ThemeSine"
* Template Name : Khanas HTML Template
* Version       : 1.0
==================================== */



/*=========== TABLE OF CONTENTS ===========
1. Scroll To Top 
2. Smooth Scroll spy
3. Progress-bar
4. owl carousel
5. welcome animation support
======================================*/

    // 1. Scroll To Top 
		$(window).on('scroll',function () {
			if ($(this).scrollTop() > 600) {
				$('.return-to-top').fadeIn();
			} else {
				$('.return-to-top').fadeOut();
			}
		});
		
		$('.return-to-top').on('click',function(){
				$('html, body').animate({
				scrollTop: 0
			}, 1500);
			return false;
		});
	
	
	
	// 2. Smooth Scroll spy
		
		$('.header-area').sticky({
           topSpacing:0
        });
		
		//=============

		$('li.smooth-menu a').bind("click", function(event) {
			event.preventDefault();
			var anchor = $(this);
			$('html, body').stop().animate({
				scrollTop: $(anchor.attr('href')).offset().top - 98
			}, 1200,'easeInOutExpo');
		});
		
		$('body').scrollspy({
			target:'.navbar-collapse',
			offset:0
		});

	// 3. Progress-bar
	
		var dataToggleTooTip = $('[data-toggle="tooltip"]');
		var progressBar = $(".progress-bar");
		if (progressBar.length) {
			progressBar.appear(function () {
				dataToggleTooTip.tooltip({
					trigger: 'manual'
				}).tooltip('show');
				progressBar.each(function () {
					var each_bar_width = $(this).attr('aria-valuenow');
					$(this).width(each_bar_width + '%');
				});
			});
		}
	
	// 4. owl carousel
	
		// i. client (carousel)
		
			$('#client').owlCarousel({
				items:7,
				loop:true,
				smartSpeed: 1000,
				autoplay:true,
				dots:false,
				autoplayHoverPause:true,
				responsive:{
						0:{
							items:2
						},
						415:{
							items:2
						},
						600:{
							items:4

						},
						1199:{
							items:4
						},
						1200:{
							items:7
						}
					}
				});
				
				
				$('.play').on('click',function(){
					owl.trigger('play.owl.autoplay',[1000])
				})
				$('.stop').on('click',function(){
					owl.trigger('stop.owl.autoplay')
				})


    // 5. welcome animation support

        $(window).load(function(){
        	$(".header-text h2,.header-text p").removeClass("animated fadeInUp").css({'opacity':'0'});
            $(".header-text a").removeClass("animated fadeInDown").css({'opacity':'0'});
        });

        $(window).load(function(){
        	$(".header-text h2,.header-text p").addClass("animated fadeInUp").css({'opacity':'0'});
            $(".header-text a").addClass("animated fadeInDown").css({'opacity':'0'});
        });

        
    //inquiry form    
    var frm_inquiry_add=$("#inquiry_add");
    $("#inquiry_submit").click(function(){
    $.ajax({
            type:"POST",
            url:frm_inquiry_add.attr("action"),
            data:$("#inquiry_add").serialize(),
            success: function(response){
                console.log(response);  
            }
        });
    });
    
    //contact form
    var contact_frm=$("#contact_frm");
    $("#contact_submit").click(function(){
    $.ajax({
            type:"POST",
            url:contact_frm.attr("action"),
            data:$("#contact_frm").serialize(),
            success: function(response){
                console.log(response);
                 
                 if (response.status == 'ERROR'){
                  
                 }else{
                  var alert_error = '<div class="alert alert-success" role="alert">';
                  alert_error = 'This is a success alert—check it out!';
                  alert_error = '</div>';
                  $("#myModal").hide();
                  $("#contact_frm").reset();
                }
            }
        });
    });
    
});	

function get_alert_msg(){
     var alert = '';
     alert += '<div class="alert alert-warning alert-dismissible fade show" role="alert">';
     alert += '<strong>Holy guacamole!</strong> You should check in on some of those fields below.';
     alert += '<button type="button" class="close" data-dismiss="alert" aria-label="Close">';
     alert += '<span aria-hidden="true">&times;</span>';
     alert += '</button>';
     alert += '</div>';
     alert += '';
     return alert;
}

function inquiry_frm(product_id){ 
 $("#myModal").find("#product_id").val(product_id);
}
	