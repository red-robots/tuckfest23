"use strict";

/**
 *	Custom jQuery Scripts
 *	Date Modified: 04.12.2022
 *	Developed by: Lisa DeBona
 */
jQuery(document).ready(function ($) {
  // const swiper = new Swiper('.slideshow .swiper', {
  //   // Optional parameters
  //   direction: 'vertical',
  //   loop: true,

  //   // If we need pagination
  //   pagination: {
  //     el: '.swiper-pagination',
  //   },

  //   // Navigation arrows
  //   navigation: {
  //     nextEl: '.swiper-button-next',
  //     prevEl: '.swiper-button-prev',
  //   },

  //   // And if we need scrollbar
  //   scrollbar: {
  //     el: '.swiper-scrollbar',
  //   },
  // });

  $('#menutoggle').on('click', function (e) {
    e.preventDefault();
    $('body').addClass('mobile-menu-open');
    $('#site-navigation').addClass('show');
  });
  $('#closeMobileNav').on('click', function (e) {
    e.preventDefault();
    $('body').removeClass('mobile-menu-open');
    $('#site-navigation').removeClass('show');
  });
  $(document).on('click', '.main-navigation li', function (e) {
    var linkClasses = $(this).attr("class").split(' ');
    $("#masthead ul.submenu").removeClass('active');
    if ($(this).hasClass("dimmer")) {
      $('#dimmer').addClass('activate');
    }
    $("#masthead ul.submenu").each(function () {
      var target = $(this);
      var menu_classes = $(this).attr("class").split(' ');
      $(linkClasses).each(function (a, b) {
        if ($.inArray(b, menu_classes) != -1) {
          target.addClass('active');
          if ($(".subnav#js-tsn").length) {
            $(".subnav#js-tsn").hide();
          }
        }
      });
    });
  });
  $(".menu-item-type-custom.menu-item-has-children > a").on("click", function (e) {
    var link = $(this).attr("href").trim().replace(/\s/g, '');
    if (link == '#') {
      e.preventDefault();
      var parent_id = $(this).parents(".menu-item-has-children").attr("id");
      $(this).next(".sub-menu").addClass('active');
      if ($("#subnavdata ul.sub-menu").length) {
        $("#subnavdata ul.sub-menu").each(function () {
          var submenu = $(this);
          if (submenu.hasClass("link-" + parent_id)) {
            submenu.toggleClass('animated fadeInDown active');
          } else {
            submenu.removeClass('animated fadeInDown active');
          }
        });
        if ($('body').has('home')) {
          $("body.home #subNavs").addClass("animated fadeInDown");
        }
      }
    }
  });
  $("#primary-menu.menu li.menu-item-has-children").each(function () {
    if ($(this).find("ul.sub-menu").length) {
      var id = $(this).attr("id");
      $(this).find("ul.sub-menu").addClass("link-" + id).appendTo("#subnavdata");
    }
  });
  var swiper = new Swiper('.slideshow .swiper', {
    autoplay: {
      delay: 10000
    },
    speed: 500,
    loop: true,
    preventClicks: false,
    fadeEffect: {
      crossFade: true
    },
    effect: "fade",
    /*  "slide", "fade", "cube", "coverflow" or "flip" */
    pagination: {
      el: '.swiper-pagination',
      clickable: true
    },
    preventClicksPropagation: false,
    navigation: {
      nextEl: '.swiper-button-next',
      prevEl: '.swiper-button-prev'
    }
  });

  /*
     *
     *   Colorbox
     *
     ------------------------------------*/
  $('a.gallery').colorbox({
    rel: 'gal',
    width: '95%',
    height: '95%'
  });
  $('a.colorbox').colorbox({
    inline: true,
    width: "90%"
  });
  $(".youtube").colorbox({
    inline: true,
    width: "60%"
  });

  /*
        FAQ dropdowns
  __________________________________________
  */
  $('.question').click(function () {
    $(this).next('.answer').slideToggle(500);
    $(this).toggleClass('close');
    $(this).find('.plus-minus-toggle').toggleClass('collapsed');
    $(this).parent().toggleClass('active');
  });

  /* POP-UP STAFF DETAILS */
  $('.column.post-type-music').on("click", function (e) {
    e.preventDefault();
    var target = $(this);
    var post_id = $(this).attr('data-postid');
    var parent = $(this).parents('.parent-wrap');
    $('.column.post-type-music').not(target).removeClass('active');
    target.addClass('active');
    $.ajax({
      url: frontajax.ajaxurl,
      type: 'post',
      dataType: "json",
      data: {
        action: 'getPostData',
        post_id: post_id
      },
      beforeSend: function beforeSend() {
        //$(".ml-loader-wrap").show();
        if ($('.event-details').length) {
          $('.event-details').remove();
        }
        $(window).on('orientationchange resize', function () {
          if ($('.event-details').length) {
            $('.event-details').remove();
          }
        });
      },
      success: function success(response) {
        if (response.content) {
          if ($(window).width() < 821) {
            $(response.content).appendTo(target);
          } else {
            $(response.content).appendTo(parent);
          }
          $(window).on('orientationchange resize', function () {
            if ($(window).width() < 821) {
              $(response.content).appendTo(target);
            } else {
              $(response.content).appendTo(parent);
            }
          });
        }
      },
      complete: function complete() {
        $('.close-event-info').on('click', function () {
          $('#event-details').remove();
          target.removeClass('active');
        });
      }
    });
  });
});