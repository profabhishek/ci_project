///// Footer


jQuery(document).ready(function() {
             
             
        var owl = jQuery('#facilites');
              owl.owlCarousel({
                items: 6,
                loop: true,
                margin: 15,
                autoplay: true,
                autoplayTimeout: 300000, 
                autoplayHoverPause: true,
                nav:true,
         responsive: {
                  0: {
                    items: 4
                  },
                  600: {
                    items: 4
                  },
                  1199: { 
                    items: 6
                  }
                }
              });
         $('.prev').click(function(){
                owl.trigger('owl.prev')
              })
        
              $('.next').click(function(){
                owl.trigger('owl.next')
              })
             
            })


jQuery(document).ready(function() {
             
             
        var owl = jQuery('#campus');
              owl.owlCarousel({
                items: 4,
                loop: true,
                margin: 15,
                autoplay: true,
                autoplayTimeout: 2000, 
                autoplayHoverPause: true,
         nav:false,
         responsive: {
                  0: {
                    items: 1
                  },
                  600: {
                    items: 4
                  },
                  1199: { 
                    items: 4
                  }
                }
              });
         $('.prev').click(function(){
                owl.trigger('owl.prev')
              })
        
              $('.next').click(function(){
                owl.trigger('owl.next')
              })
             
            })

jQuery(document).ready(function() {
             
             
        var owl = jQuery('#testimonial');
              owl.owlCarousel({
                items: 2,
                loop: true,
                margin: 15,
                autoplay: true,
                autoplayTimeout: 3000, 
                autoplayHoverPause: true,
         nav:true,
         responsive: {
                  0: {
                    items: 1
                  },
                  600: {
                    items: 1
                  },
                  1199: { 
                    items: 2
                  }
                }
              });
         $('.prev').click(function(){
                owl.trigger('owl.prev')
              })
        
              $('.next').click(function(){
                owl.trigger('owl.next')
              })
             
            })

jQuery(document).ready(function() {
             
             
        var owl = jQuery('#footer-bottom-slider');
              owl.owlCarousel({
                items: 7,
                loop: true,
                margin: 15,
                autoplay: true,
                autoplayTimeout: 3000, 
                autoplayHoverPause: true,
         nav:true,
         responsive: {
                  0: {
                    items: 2
                  },
                  600: {
                    items: 3
                  },
                  1199: { 
                    items: 7
                  }
                }
              });
         $('.prev').click(function(){
                owl.trigger('owl.prev')
              })
        
              $('.next').click(function(){
                owl.trigger('owl.next')
              })
             
            })


$(window).scroll(function() {
   if ($("#wrapperNav").length) {
       //On scroll Navigation Fixed
        var headerFix = $('#wrapperNav');
        $(window).scroll(function () {
          if ($(this).scrollTop() > 40) {
            //alert('hi');  
            headerFix.addClass("headFix");
          } else {
            headerFix.removeClass("headFix");
          }
                             
      })
    }
  });









$(document).ready(function(){

    var myET = $('.myTicker').easyTicker({
        direction: 'up',
        easing: 'swing',
        speed: 'slow',
        interval: 3000,
        height: '199',
        visible: 2,
        mousePause: true,
        controls: {
            up: '.up',
            down: '.down',
            toggle: '.toggle',
            stopText: 'Stop !!!'
        },
        callbacks: {
            before: function(ul, li){
                console.log(this, ul, li);
                $(li).css('color', 'black');
            },
            after: function(ul, li){
                console.log(this, ul, li);
            }
        }
    }).data('easyTicker');

    cc = 1;
    $('.add').click(function(){
        $('.myTicker ul').append('<li>' + cc + ' Triangles can be made easily using CSS also without any images. This trick requires only div tags and some</li>');
        cc++;
    });

    $('.visible-3').click(function(){
        myET.options['visible'] = 3;

    });

    $('.visible-all').click(function(){
        myET.stop();
        myET.options['visible'] = 0 ;
        myET.start();
    });

});

  $(window).scroll(function() {
   if ($("#wrapperNav").length) {
       //On scroll Navigation Fixed
        var headerFix = $('#wrapperNav');
        $(window).scroll(function () {
          if ($(this).scrollTop() > 40) {
            //alert('hi');  
            headerFix.addClass("headFix");
          } else {
            headerFix.removeClass("headFix");
          }
                             
      })
    }
  });



