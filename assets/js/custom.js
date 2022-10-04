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
  /* POP-UP STAFF DETAILS */

  $('.column.post-type-music').on("click", function (e) {
    e.preventDefault();
    var target = $(this);
    var post_id = $(this).attr('data-postid');
    var parent = $(this).parents('.parent-wrap');
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
        });
      }
    });
  });
});