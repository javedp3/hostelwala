/*============== Main Js Start ========*/
/*============================ header menu show hide =========*/
$(".sidebar-menu-show-hide").on("click", function () {
  $(".sidebar-menu-wrapper").addClass("show");
  $(".sidebar-overlay").addClass("show");
});

$(".sidebar-overlay, .close-hide-show").on("click", function () {
  $(".sidebar-menu-wrapper").removeClass("show");
  $(".sidebar-overlay").removeClass("show");
});
(function ($) {
  "use strict";

  /*============== Header Hide Click On Body Js ========*/
  $(".navbar-toggler.header-button").on("click", function () {
    if ($(".body-overlay").hasClass("show")) {
      $(".body-overlay").removeClass("show");
    } else {
      $(".body-overlay").addClass("show");
    }
  });
  $(".body-overlay").on("click", function () {
    $(".header-button").trigger("click");
  });

  /* ==========================================
  *     Start Document Ready function
  ==========================================*/
  $(document).ready(function () {
    "use strict";
    /*================== Community dropdown hide show ==========*/
    $(".single-item-menu").on("click", function () {
      var postTopMenu = $(this).find(".post-top-menu");

      if (postTopMenu.hasClass("show")) {
        postTopMenu.removeClass("show");
        $(".body-overlay").removeClass("everyone-btn-hide");
      } else {
        $(".post-top-menu").removeClass("show");
        $(this).find(".post-top-menu").addClass("show");
        $(".body-overlay").addClass("everyone-btn-hide");
      }
    });

    $(".single-item-share").on("click", function () {
      var postTopMenu = $(this).find(".share-item");

      if (postTopMenu.hasClass("show")) {
        postTopMenu.removeClass("show");
        $(".body-overlay").removeClass("everyone-btn-hide");
      } else {
        $(".post-top-menu").removeClass("show");
        $(this).find(".post-top-menu").addClass("show");
        $(".body-overlay").addClass("everyone-btn-hide");
      }
    });

    $(".body-overlay").on("click", function () {
      $(".post-top-menu").removeClass("show");
      $(".body-overlay").removeClass("everyone-btn-hide");
    });


    // /*================== Filter dropdown hide show ==========*/
    $(".hostel-top-filer").on("click", function () {
      $(".filter-search").toggleClass("hide show");
    });

    /*================== Password Show Hide Js ==========*/
    $(".toggle-password-change").on("click", function () {
      var target = $(this).siblings("input");
      if (target.attr("type") === "password") {
        target.attr("type", "text");
        $(this).removeClass("fa-eye-slash");
        $(this).addClass("fa-eye");
      } else {
        target.attr("type", "password");
        $(this).removeClass("fa-eye");
        $(this).addClass("fa-eye-slash");
      }
    });

    /*================== Show Login Toggle Js ==========*/
    $("#showlogin").on("click", function () {
      $("#checkout-login").slideToggle(700);
    });

    /*================== Show Coupon Toggle Js ==========*/
    $("#showcupon").on("click", function () {
      $("#coupon-checkout").slideToggle(400);
    });

    /*============** Mgnific Popup **============*/
    $(".image-popup").magnificPopup({
      type: "image",
      gallery: {
        enabled: true,
      },
    });

    $(".popup_video").magnificPopup({
      type: "iframe",
    });

    /*========================= Product list-slider Js Start ==============*/
    $(".product-list-slider").slick({
      slidesToShow: 1,
      slidesToScroll: 1,
      autoplay: true,
      autoplaySpeed: 2000,
      speed: 1500,
      dots: true,
      pauseOnHover: false,
      arrows: false,
      prevArrow: '<button type="button" class="slick-prev"><i class="fas fa-long-arrow-alt-left"></i></button>',
      nextArrow: '<button type="button" class="slick-next"><i class="fas fa-long-arrow-alt-right"></i></button>',
      responsive: [
        {
          breakpoint: 1199,
          settings: {
            arrows: false,
            slidesToShow: 1,
            dots: false,
          },
        },
        {
          breakpoint: 991,
          settings: {
            arrows: false,
            slidesToShow: 1,
          },
        },
        {
          breakpoint: 767,
          settings: {
            arrows: false,
            slidesToShow: 1,
          },
        },
      ],
    });

     /*========================= Testimonials Js Start ==============*/
    $(".testimonial-slider").slick({
      slidesToShow: 1,
      slidesToScroll: 1,
      autoplay: true,
      autoplaySpeed: 2000,
      speed: 1500,
      dots: true,
      pauseOnHover: false,
      arrows: false,
      prevArrow: '<button type="button" class="slick-prev"><i class="fas fa-long-arrow-alt-left"></i></button>',
      nextArrow: '<button type="button" class="slick-next"><i class="fas fa-long-arrow-alt-right"></i></button>',
      responsive: [
        {
          breakpoint: 1199,
          settings: {
            arrows: false,
            slidesToShow: 1,
            dots: false,
          },
        },
        {
          breakpoint: 991,
          settings: {
            arrows: false,
            slidesToShow: 1,
          },
        },
        {
          breakpoint: 767,
          settings: {
            arrows: false,
            slidesToShow: 1,
          },
        },
      ],
    });
    /*======================= Mouse hover Js Start ============*/
    $(".mousehover-item").on("mouseover", function () {
      $(".mousehover-item").removeClass("active");
      $(this).addClass("active");
    });

    /*================== Sidebar Menu Js Start =============== */
    // Sidebar Dropdown Menu Start
    $(".has-dropdown > a").on("click", function () {
      $(".sidebar-submenu").slideUp(200);
      if ($(this).parent().hasClass("active")) {
        $(".has-dropdown").removeClass("active");
        $(this).parent().removeClass("active");
      } else {
        $(".has-dropdown").removeClass("active");
        $(this).next(".sidebar-submenu").slideDown(200);
        $(this).parent().addClass("active");
      }
    });

    /*==================== Sidebar Icon & Overlay js ===============*/
    $(".dashboard-body__bar-icon").on("click", function () {
      $(".sidebar-menu").addClass("show-sidebar");
      $(".sidebar-overlay").addClass("show");
    });
    $(".sidebar-menu__close, .sidebar-overlay").on("click", function () {
      $(".sidebar-menu").removeClass("show-sidebar");
      $(".sidebar-overlay").removeClass("show");
    });

    /*================= Increament & Decreament Js Start ======*/
    const productQty = $(".product-qty");
    productQty.each(function () {
      const qtyIncrement = $(this).find(".product-qty__increment");
      const qtyDecrement = $(this).find(".product-qty__decrement");
      let qtyValue = $(this).find(".product-qty__value");
      qtyIncrement.on("click", function () {
        var oldValue = parseFloat(qtyValue.val());
        var newVal = oldValue + 1;
        qtyValue.val(newVal).trigger("change");
      });
      qtyDecrement.on("click", function () {
        var oldValue = parseFloat(qtyValue.val());
        if (oldValue <= 0) {
          var newVal = oldValue;
        } else {
          var newVal = oldValue - 1;
        }
        qtyValue.val(newVal).trigger("change");
      });
    });

    /*======================= Event Details Like Js Start =======*/
    $(".hit-like").each(function () {
      $(this).on(click(function () {
          $(this).toggleClass("liked");
        })
      );
    });

    $(document).ready(function () {
      "use strict";
      $(".odometer").each(function () {
        $(this).isInViewport(function (status) {
          if (status === "entered") {
            var el = $(this);
            el.html(el.attr("data-odometer-final"));
          }
        });
      });
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

    /* =================== User Profile Upload Photo Js Start ========== */
    function readURL(input) {
      if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function (e) {
          $("#imagePreview").css(
            "background-image",
            "url(" + e.target.result + ")"
          );
          $("#imagePreview").hide();
          $("#imagePreview").fadeIn(650);
        };
        reader.readAsDataURL(input.files[0]);
      }
    }
    $("#imageUpload").on('change', function () {
      readURL(this);
    });
  });

  /*==========================================
  *      End Document Ready function
  // ==========================================*/

  /*========================= Preloader Js Start =====================*/

  $(window).on("load", function () {
    $("#loading").fadeOut();
  });

  /*========================= Header Sticky Js Start ==============*/
  $(window).on("scroll", function () {
    if ($(window).scrollTop() >= 300) {
      $(".header").addClass("fixed-header");
    } else {
      $(".header").removeClass("fixed-header");
    }
  });

  /*============================ Scroll To Top Icon Js Start =========*/
  var btn = $(".scroll-top");

  $(window).scroll(function () {
    if ($(window).scrollTop() > 300) {
      btn.addClass("show");
    } else {
      btn.removeClass("show");
    }
  });

  btn.on("click", function (e) {
    e.preventDefault();
    $("html, body").animate({ scrollTop: 0 }, "300");
  });

  /*============================ Header Search =========*/

  $(".header-search-icon").on("click", function () {
    $(".header-search-hide-show").addClass("show");
    $(".header-search-icon").hide();
    $(".close-hide-show").addClass("show");
  });

  $(".close-hide-show").on("click", function () {
    $(".close-hide-show").removeClass("show");
    $(".header-search-hide-show").removeClass("show");
    $(".header-search-icon").show();
  });

  /*=========================  Light and dark Start =================*/
  var mode = localStorage.getItem("mode") || "light";
  if (mode === "dark") {
    $("body").addClass("dark");
    $(".cookies-card").addClass("dark");
    $(".normal-logo").addClass("hidden");
    $(".dark-logo").removeClass("hidden");
    $(".footer-logo-normal").addClass("hidden");
    $(".footer-logo-dark").removeClass("hidden");
  }
  $("#light-dark-checkbox").on("click", function () {
    if (mode === "light") {
      mode = "dark";
      $("body").addClass("dark");
      $(".cookies-card").addClass("dark");
      $(".normal-logo").addClass("hidden");
      $(".dark-logo").removeClass("hidden");
      $(".footer-logo-dark").removeClass("hidden");
      $(".footer-logo-normal").addClass("hidden");
    } else {
      mode = "light";
      $("body").removeClass("dark");
      $(".cookies-card").removeClass("dark");
      $(".dark-logo").addClass("hidden");
      $(".normal-logo").removeClass("hidden");
      $(".footer-logo-dark").addClass("hidden");
      $(".footer-logo-normal").removeClass("hidden");
    }
    localStorage.setItem("mode", mode);
  });

  /* === dark and light icon handle with local storage ===*/
  $(".mon-icon").on("click", function () {
    $(this).addClass("show");
    $(".sun-icon").addClass("show");
    localStorage.setItem("mode", "dark");
  });

  $(".sun-icon").on("click", function () {
    $(this).removeClass("show");
    $(".mon-icon").removeClass("show");
    localStorage.setItem("mode", "light");
  });

  /*=== On page load, check the stored mode and apply it ===*/
  $(document).ready(function () {
    "use strict";
    var mode = localStorage.getItem("mode");
    if (mode === "dark") {
      $(".mon-icon").addClass("show");
      $(".sun-icon").addClass("show");
    } else {
      $(".mon-icon").removeClass("show");
      $(".sun-icon").removeClass("show");
    }
  });

  /*=== On page load, check the stored mode and apply it ===*/
  $(document).ready(function () {
    "use strict";
    var mode = localStorage.getItem("mode");
    if (mode === "dark") {
      $(".mon-icon").addClass("show");
      $(".sun-icon").addClass("show");
    } else {
      $(".mon-icon").removeClass("show");
      $(".sun-icon").removeClass("show");
    }
  });

  /*========== header menu show hide =========*/
  $(".sidebar-menu-show-hide").on("click", function () {
    $(".sidebar-menu-wrapper").addClass("show");
    $(".sidebar-overlay").addClass("show");
  });

  $(".sidebar-overlay, .close-hide-show").on("click", function () {
    $(".sidebar-menu-wrapper").removeClass("show");
    $(".sidebar-overlay").removeClass("show");
  });

  /*========== Search input show hide =========*/
  $("#search-input-show").on("click", function () {
    $(".search-input-wrap").toggleClass("show");
  });

  $("#search-input-show").on("click", function () {
    $(".search-input-wrap").addClass("show");
  });
  $(document).on("click", function (event) {
    if (
      !$(event.target).closest(".search-input-wrap, #search-input-show").length
    ) {
      $(".search-input-wrap").removeClass("show");
    }
  });
  /*============================ Dashboard Menu show hide =========*/
  $(".dashboard-show-hide").on("click", function () {
    $(".dashboard_profile").addClass("show");
    $(".sidebar-overlay").addClass("show");
  });

  $(".sidebar-overlay, .close-hide-show").on("click", function () {
    $(".dashboard_profile").removeClass("show");
    $(".sidebar-overlay").removeClass("show");
  });
})(jQuery);
