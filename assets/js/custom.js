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
  /* ==============
       FILTER 
  ================== */

  /* SCHEDULE page */

  $('.types .select-styled').click(function () {
    $(this).next('.select-options').slideToggle();
  });
  $(document).on('click', '.types .select-options li', function () {
    var parent = $(this).parents('div.select');
    var slug = $(this).attr('rel').replace('.', '');
    var selected = $(this).text().trim();
    parent.find('.select-styled').text(selected);
    parent.find('.select-options').slideUp('fast');
    /* if ALL */

    if (slug == 'sched-act') {
      $('.schedule ul.list li').show();
    } else {
      $('.schedule ul.list li').each(function () {
        if ($(this).hasClass(slug)) {
          $(this).show();
        } else {
          $(this).hide();
        }
      });
    }
  });
  $('.filter-custom .select-styled').click(function () {
    $(this).next('.select-options').slideToggle();
    $('.filter-custom .select-styled').not(this).next('.select-options').slideUp();
  });
  $(document).on('click', '.filter-custom .select .select-options li', function (e) {
    e.preventDefault();
    var slug = $(this).attr('rel');
    var selected = $(this).text().trim();
    var parent = $(this).parents('div.select');
    parent.find('.select-styled').text(selected);
    parent.find('.select-styled').attr('data-selected', slug);
    parent.find('.select-options').slideUp('fast');
    /* if ALL */
    // if(slug=='all') {
    //   $('.repeatable-content-blocks .content-block').show();
    // } else {
    //   $('.repeatable-content-blocks .content-block').each(function(){
    //     if( $(this).hasClass(slug) ) {
    //       $(this).show();
    //     } else {
    //       $(this).hide();
    //     }
    //   });
    // }

    /* Check first other filters */

    var selectedFilters = [];
    $('.filter-custom .select-styled').each(function () {
      var selected = $(this).attr('data-selected');

      if (selected != 'all') {
        selectedFilters.push(selected);
      }
    }); //let uniqueItems = (selectedFilters.length) ? unique(selectedFilters) : '';

    var selectedList = selectedFilters.length ? '.' + selectedFilters.join('.') : '';
    $('.repeatable-content-blocks .content-block').not(selectedList).hide();

    if ($('.repeatable-content-blocks .content-block' + selectedList).length) {
      $('.repeatable-content-blocks .content-block').hide().removeClass('found');
      $('.repeatable-content-blocks .content-block' + selectedList).show().addClass('found');
    } else {
      $('.repeatable-content-blocks .content-block').hide().removeClass('found');
    } //checkFoundItems();

  });

  function checkFoundItems() {
    var count = $('.repeatable-content-blocks .content-block.found').length;

    if (count) {
      $('h3.notfound').remove();
    } else {
      if ($('h3.notfound').length == 0) {
        $('.repeatable-content-blocks .wrapper').append('<h3 class="notfound">No record found.</h3>');
      }
    }
  }
  /* Close Filter */


  $(document).on('click', function (e) {
    if ($(e.target).closest("div.select").length === 0) {
      $("div.select .select-options").slideUp();
    }
  });

  function unique(array) {
    return array.filter(function (el, index, arr) {
      return index == arr.indexOf(el);
    });
  }

  $('#filterStyle select').each(function () {
    //$(this).niceSelect();
    $(this).find('option').each(function () {
      console.log(this.value);
    });
  });
});