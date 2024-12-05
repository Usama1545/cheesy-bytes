(function ($) {
  "use strict";

  /*========== Main Slider ===========*/
  var $slide = $(".slider-active")
  .slick({
      infinite: true,
      slidesToShow: 1,
      slidesToScroll: 1,
      arrows: false,
      fade: true,
      speed: 2000,
      autoplaySpeed: 4000,
      autoplay: true,
  }).slickAnimation()
  .on({
      beforeChange: function(event, slick, currentSlide, nextSlide) {
      $(".slick-slide", this).eq(currentSlide).addClass("preve-slide");
      $(".slick-slide", this).eq(nextSlide).addClass("slide-animation");
      },
      afterChange: function() {
      $(".preve-slide", this).removeClass("preve-slide　slide-animation");
      }
  });
  $slide.find(".slick-slide").eq(0).addClass("slide-animation");

  /*============** Btn hover style **============*/
  $(function () {
    $('.btn-posnawr')
      .on('mouseenter', function (e) {
        var parentOffset = $(this).offset(),
          relX = e.pageX - parentOffset.left,
          relY = e.pageY - parentOffset.top;
        $(this).find('span').css({ top: relY, left: relX })
      })
      .on('mouseout', function (e) {
        var parentOffset = $(this).offset(),
          relX = e.pageX - parentOffset.left,
          relY = e.pageY - parentOffset.top;
        $(this).find('span').css({ top: relY, left: relX })
      });
    // $('[href=#]').click(function () { return false });
  });         

  /*============** Sticky Header **============*/
  $(window).on('scroll', function () {
    var scroll = $(window).scrollTop();
    if (scroll < 380) {
      $("#sticky-header").removeClass("sticky");
    } else {
      $("#sticky-header").addClass("sticky");
    }
  });

  /*============** meanmenu **============*/
  $('#mobile-nav').meanmenu({
    meanMenuContainer: '.mobile-nav',
    meanScreenWidth: "1199",
    meanMenuOpen: '<span></span><span></span><span></span>',
  });

  /*============** Search Bar **============*/

  if ($(".search-toggler").length) {
    $(".search-toggler").on("click", function (e) {
      e.preventDefault();
      $(".search_popup_wrap").toggleClass("active");
      $(".mobile-nav__wrapper").removeClass("expanded");
      $("body").toggleClass("locked");
    });
  }

  /*============** Data-Background Js **============*/
  $("[data-background").each(function () {
    $(this).css("background-image", "url( " + $(this).attr("data-background") + "  )");
  });

  $("[data-bg-color]").each(function () {
    $(this).css("background-color", $(this).attr("data-bg-color"))
  })


  /*==========  Wow Js ==========*/
  new WOW().init();

  /*==========  Service Slider  ==========*/
  $('.service_active').slick({
    dots: false,
    autoplay: false,
    infinite: true,
    arrows: true,
    autoplaySpeed: 3000,
    prevArrow: '<button type="button" class="slick-prev"> <i class="las la-arrow-left"></i> </button>',
    nextArrow: '<button type="button" class="slick-next"> <i class="las la-arrow-right"></i> </button>',
    slidesToShow: 3,
    centerPadding: '60px',
    responsive: [
      {
        breakpoint: 1200,
        settings: {
          arrows: false,
          slidesToShow: 3
        }
      },
      {
        breakpoint: 992,
        settings: {
          arrows: false,
          slidesToShow: 2
        }
      },
      {
        breakpoint: 768,
        settings: {
          arrows: false,
          slidesToShow: 1
        }
      },
      {
        breakpoint: 500,
        settings: {
          arrows: false,
          slidesToShow: 1
        }
      }
    ]
  });

  /*==========  Testimonial Slider  ==========*/
  $('.testimonials_active').slick({
    dots: false,
    autoplay: false,
    infinite: true,
    arrows: false,
    slidesToShow: 3,
    centerPadding: '60px',

    responsive: [
      {
        breakpoint: 992,
        settings: {
          arrows: false,
          slidesToShow: 2
        }
      },
      {
        breakpoint: 768,
        settings: {
          arrows: false,
          slidesToShow: 1
        }
      },
      {
        breakpoint: 500,
        settings: {
          arrows: false,
          slidesToShow: 1
        }
      }
    ]
  });

  /*============** Mgnific Popup **============*/
  $(".image-popup").magnificPopup({
    type: "image",
    gallery: {
      enabled: true,
    },
  });

  $('.popup_video').magnificPopup({
    type: 'iframe',
  });

  $('.slider-for').slick({
    slidesToShow: 1,
    slidesToScroll: 1,
    arrows: false,
    fade: true,
    asNavFor: '.slider-nav'
  });

  $('.slider-nav').slick({
    slidesToShow: 3,
    slidesToScroll: 1,
    asNavFor: '.slider-for',
    dots: false,
    centerMode: true,
    focusOnSelect: true,
    arrows: false,
  });



  /*========== scroll to top  ==========*/
  var scrollPath = document.querySelector('.scroll-up path');
  var pathLength = scrollPath.getTotalLength(null);
  scrollPath.style.transition = scrollPath.style.WebkitTransition = 'none';
  scrollPath.style.strokeDasharray = pathLength + ' ' + pathLength;
  scrollPath.style.strokeDashoffset = pathLength;
  scrollPath.getBoundingClientRect();
  scrollPath.style.transition = scrollPath.style.WebkitTransition = 'stroke-dashoffset 10ms linear';
  var updatescroll = function () {
    var scroll = $(window).scrollTop();
    var height = $(document).height() - $(window).height();
    var scroll = pathLength - (scroll * pathLength / height);
    scrollPath.style.strokeDashoffset = scroll;
  }
  updatescroll();
  $(window).scroll(updatescroll);
  var offset = 50;
  var duration = 950;
  jQuery(window).on('scroll', function () {
    if (jQuery(this).scrollTop() > offset) {
      jQuery('.scroll-up').addClass('active-scroll');
    } else {
      jQuery('.scroll-up').removeClass('active-scroll');
    }
  });
  jQuery('.scroll-up').on('click', function (event) {
    event.preventDefault();
    jQuery('html, body').animate({
      scrollTop: 0
    }, duration);
    return false;
  });

  $('.datepicker').datepicker();    

  /*==========  counterUp  ==========*/
  var counter = $('.counter');
  counter.counterUp({
    time: 2500,
    delay: 100
  });

  /*============** Number Increment Decrement **============*/
  $(".add").on("click", function () {
    if ($(this).prev().val() < 999) {
      $(this)
        .prev()
        .val(+$(this).prev().val() + 1);
    }
  });
  $(".sub").on("click", function () {
    if ($(this).next().val() > 1) {
      if ($(this).next().val() > 1)
        $(this)
          .next()
          .val(+$(this).next().val() - 1);
    }
  });

  /*============** Peloaders **============*/
  $(window).on('load', function () {
    $("#loading").fadeOut(800);
  })

  /*========== Btn hover  ==========*/
  $('.theme_btn_hover')
    .on('mouseenter', function (e) {
      var parentOffset = $(this).offset(),
        relX = e.pageX - parentOffset.left,
        relY = e.pageY - parentOffset.top;
      $(this).find('b').css({ top: relY, left: relX })
    })
  $('.theme_btn_hover').on('mouseout', function (e) {

    var parentOffset = $(this).offset(),
      relX = e.pageX - parentOffset.left,
      relY = e.pageY - parentOffset.top;
    $(this).find('b').css({ top: relY, left: relX })

  })

  $(".single-input .eye_icon_show").click(function () {
    var input = $($(this).attr("rel"));
    if (input.attr("type") == "password") {        
      input.attr("type", "text");
    } else {
      input.attr("type", "password");
    }
  });


  // ========== Basic Table  ==========
  $('#table_res').basictable({ breakpoint: 768 });



})(jQuery);