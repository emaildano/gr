// Theme by default loads a jQuery as dependency of the main script.
// Let's include it using ES6 modules import.
import $ from "jquery";
const slick = require('slick-carousel');

/*
   Copyright 2013 Ivan Gilchrist
   Licensed under the Apache License, Version 2.0 (the "License");
   you may not use this file except in compliance with the License.
   You may obtain a copy of the License at
       http://www.apache.org/licenses/LICENSE-2.0
   Unless required by applicable law or agreed to in writing, software
   distributed under the License is distributed on an "AS IS" BASIS,
   WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
   See the License for the specific language governing permissions and
   limitations under the License.
*/

(function($) {
  $.fn.inView = function(options) {
    // Set default Options
    var defaults = {
      triggerPoint: "top", // 'top', 'whole'
      triggerOffset: 200,
      inViewClass: "in-view"
    };
    var opts = $.extend({}, defaults, options);
    var selector = this.selector;
    var elTop;
    var winBottom = $(window).scrollTop() + $(window).height();

    function fade_in() {
      $(selector).each(function(i) {
        var el = $(this);

        // var elTop = el.offset().top + opts.triggerOffset; // + $(this).outerHeight();
        // var winBottom = $(window).scrollTop() + $(window).height();

        if (opts.triggerPoint === "whole") {
          elTop =
            $(this).offset().top + opts.triggerOffset + $(this).outerHeight();
        } else {
          elTop = $(this).offset().top + opts.triggerOffset;
        }

        /* If the object is completely visible in the window, fade it it */
        if (winBottom > elTop) {
          el.addClass(opts.inViewClass);
        }
      });
    }

    $(document).ready(function() {
      fade_in();

      /* Every time the window is scrolled ... */
      $(window).scroll(function() {
        winBottom = $(window).scrollTop() + $(window).height();
        fade_in();
      });
    });
  };
})(jQuery);

/**
 * SCROLL ELEMENT
 */
(function($) {
  $.fn.scrollElement = function(options) {
    // Set default Options
    var defaults = {
      useOffset: true, // Whether or not to offset items below bottom of viewport
      defaultOffset: "100", // Distance before element appears to start animation
      disableMobile: false // Will return false on mobile
    };
    var opts = $.extend({}, defaults, options);

    /**
     * Return false on function if is mobile and disableMobile is set to true
     */
    if (
      opts.disableMobile &&
      /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(
        navigator.userAgent
      )
    ) {
      return false;
    }

    // Window Vars
    var windowYOffset = window.pageYOffset;
    var winHeight =
      "innerHeight" in window
        ? window.innerHeight
        : document.documentElement.offsetHeight;
    var navToggle = $("#filter-toggle");
    var winBottom = windowYOffset + winHeight;
    var body = document.body;
    var html = document.documentElement;
    var docHeight = Math.max(
      body.scrollHeight,
      body.offsetHeight,
      html.clientHeight,
      html.scrollHeight,
      html.offsetHeight
    );

    // Recalc height on resize
    $(window).on("resize", function() {
      var winHeight =
        "innerHeight" in window
          ? window.innerHeight
          : document.documentElement.offsetHeight;
      var docHeight = Math.max(
        body.scrollHeight,
        body.offsetHeight,
        html.clientHeight,
        html.scrollHeight,
        html.offsetHeight
      );
    });

    // Recalc scroll amount
    $(document).on("scroll", function() {
      windowYOffset = window.pageYOffset;
      winBottom = windowYOffset + winHeight;
    });

    /**
     * Run the functions needed to update translate on element
     * @param  {object} el object to run function on.
     */
    function runScrollElement(el) {
      var thisTop = el.offset().top;

      // console.log(el.className + ' ' + thisTop);

      /**
       * If the element is below the viewport, return false, as all others
       * after should be below as well.
       */
      if (opts.useOffset && thisTop - opts.defaultOffset > winBottom) {
        return;
      }

      /**
       * If the element is within the viewport, get the speed and
       * adjust translate relative to top of el.
       *
       * speed variable made opposite of magnitude, so a negative number
       * scrolls _slower_, and a positive number scrolls _faster_.
       *
       * scrollThrough variable moves element relative to page placement
       */
      var speed = el.attr("data-speed") * -1;
      var val;

      /**
       * Add `start-zero` class to element to have it start at zero
       */
      if (el.hasClass("scroll-start-zero")) {
        val = windowYOffset * speed;
      } else {
        val = (windowYOffset - thisTop) * speed;
      }

      if (val > docHeight) {
        val = docHeight;
      }

      el.css({
        "-webkit-transform": "translate3d( 0px, " + val + "px, 0px)",
        "-ms-transform": "translate3d( 0px, " + val + "px, 0px)",
        transform: "translate3d( 0px, " + val + "px, 0px)"
      });
    }

    return this.each(function() {
      var el = $(this);

      $(document).on("scroll", function() {
        // Return if mobile toggle is viewable
        if (navToggle.css("display") === "block") {
          el.removeAttr("style");
          return;
        }

        runScrollElement(el);
      });
    });
  };
})(jQuery);

// Determine if IE and if so, which version
function msieversion() {
  var ua = window.navigator.userAgent;
  var msie = ua.indexOf("MSIE ");

  if (msie > 0 || !!navigator.userAgent.match(/Trident.*rv\:11\./)) {
    // If Internet Explorer, return version number
    var version = parseInt(ua.substring(msie + 5, ua.indexOf(".", msie)));
    var ieClass = "ie-" + version;
    $("body").addClass("ie-browser " + ieClass);
  }

  return false;
}

/* ========================================================================
 * DOM-based Routing
 * Based on http://goo.gl/EUTi53 by Paul Irish
 *
 * Only fires on body classes that match. If a body class contains a dash,
 * replace the dash with an underscore when adding it to the object below.
 *
 * .noConflict()
 * The routing is enclosed within an anonymous function so that you can
 * always reference jQuery with $, even when in .noConflict() mode.
 *
 * Google CDN, Latest jQuery
 * To use the default WordPress version of jQuery, go to lib/config.php and
 * remove or comment out: add_theme_support('jquery-cdn');
 * ======================================================================== */

(function($) {
  function filter_toggle_class_toggle() {
    $("body, #nav-filter, #js--filter--link-wrapper").toggleClass(
      "open-filter"
    );
    $("#js--resp-filter-title i").toggleClass("fa-angle-down fa-angle-up");
  }

  function filter_toggle() {
    $("#js--nav-filter-toggle, #js--resp-filter-title").click(function(event) {
      event.preventDefault();
      filter_toggle_class_toggle();
    });
  }

  function blogSlider() {
    $(".blog-module--slider").slick({
      arrows: false,
      dots: true
    });
  }

  function primaryTest() {
    if ($("#primary-break").css("display") === "block") {
      return true;
    } else {
      return false;
    }
  }

  var respTest = primaryTest();

  $(window).resize(function() {
    respTest = primaryTest();
  });

  // Use this variable to set up the common and page specific functions. If you
  // rename this variable, you will also need to rename the namespace below.
  var Sage = {
    // All pages
    common: {
      init: function() {
        // Check for IE, if so, add body class
        msieversion();

        // JavaScript to be fired on all pages
        $("#filter-toggle").click(function() {
          $(this).toggleClass("open-nav");
          $("#nav-menu, body").toggleClass("open-nav");
        });

        $("#close-features").click(function() {
          filter_toggle_class_toggle();
        });

        // Fade In Images on Scroll
        $(".fade-in").inView({
          triggerOffset: 150
        });
      },
      finalize: function() {
        // JavaScript to be fired on all pages, after page specific JS is fired
      }
    },
    // Home page
    front_page: {
      init: function() {
        // JavaScript to be fired on the home page

        /**
         * Swiper
         * Page header swiper functionality
         */

        var $dragContent = $("#dragged-content"),
          dragContent = $dragContent.width(),
          dragMargin = $dragContent.css("margin-left"),
          dragWidthInit = $("#swipe-wrapper").width(),
          $header = $(".navigation"),
          $title = $("#dragged-title");

        function resetVars() {
          $dragContent.width("auto");

          $dragContent = $("#dragged-content");
          dragContent = $dragContent.width();
          dragMargin = $(".site-logo").css("margin-left");
          dragWidthInit = $("#swipe-wrapper").width();
          $header = $(".navigation");
          $title = $("#dragged-title");
        }

        function swiperContent() {
          if (respTest) {
            $dragContent.css({
              width: dragContent,
              "margin-left": dragMargin
            });
          } else {
            $dragContent.removeAttr("style");
          }
        }

        // Setup fixed width for content
        swiperContent();

        // Click action
        $("#drag-control").click(function() {
          var el = $(this);

          if (el.hasClass("active-swipe")) {
            $title.toggleClass("visible");
            setTimeout(function() {
              $("#drag-container").animate(
                {
                  width: "100%"
                },
                500,
                function() {
                  $header.removeClass("open-swipe");
                }
              );
            }, 100);
            el.removeClass("active-swipe");
          } else {
            $header.addClass("open-swipe");
            $("#drag-container").animate(
              {
                width: "0"
              },
              500,
              function() {
                $title.toggleClass("visible");
              }
            );
            el.addClass("active-swipe");
          }
        });

        $(window).resize(function() {
          resetVars();
          swiperContent();
        });

        // Slider
        $("#js-slider").slick({
          arrows: false,
          dots: true
        });

        $("#js-modal-close").click(function(event) {
          event.preventDefault();

          var $modal = $("#js-modal-wrapper");
          $modal.addClass("fade-out");
          setTimeout(function() {
            $modal.css("display", "none");
          }, 500);
        });
      },
      finalize: function() {
        // JavaScript to be fired on the home page, after the init JS

        $(window).load(function() {
          setTimeout(function() {
            document.getElementsByTagName("body")[0].className +=
              " logo-animate";
          }, 500);
        });
      }
    },
    clients_archive: {
      init: function() {
        // Add class on filter click
        $(".client-fliter--link").click(function(event) {
          event.preventDefault();

          var el = $(this);
          var target = el.attr("data-target");

          console.log(target);

          // Remove all active classes
          $(".client-list--entry, .client-fliter--link")
            .removeClass("active")
            .addClass("inactive");

          // Add active class to targeted attribute
          $("." + target)
            .addClass("active")
            .removeClass("inactive");
          el.addClass("active");

          $("#j2--client-toggle span").text(el.text());
          $("#j2--client-toggle i").toggleClass("fa-angle-down fa-angle-up");
          $(".client-filter--list").toggleClass("open-nav");
        });

        // Masonry
        $(window).load(function() {
          if (respTest) {
            $(".client-list").masonry({
              itemSelector: ".client-list--entry"
            });
          }
        });

        $("#j2--client-toggle").click(function() {
          $("i", this).toggleClass("fa-angle-down fa-angle-up");
          $(".client-filter--list").toggleClass("open-nav");
        });
      }
    },
    single_staff: {
      init: function() {
        if (respTest) {
          $("#js-bio-aside").lowFloat({ float: "left" });
        }
      }
    },
    page_profile: {
      init: function() {
        $(".scroll-item").scrollElement({
          useOffset: false,
          defaultOffset: 0,
          disableMobile: true
        });
      }
    },
    single_projects: {
      init: function() {
        $(".scroll-item").scrollElement({
          disableMobile: true
        });
      }
    },
    projects_archive: {
      init: function() {
        // Filter Projects Toggle
        filter_toggle();

        // Filter on initialization if neccessary
        var $wrapper = $("#js--filter-container");
        var $archive = $("#js--filter-archive");
        var wrapperInit = $wrapper.attr("data-filtered");
        var $vault = $("#js--filter-vault");
        var $archiveVault = $("#js--filter-archive-vault");
        var initUrl = window.location.href;
        var $title = $(".js--title");
        var $wrapperInit;

        // Remove modules from a wrapper and place them in a vault
        function removeMods(elWrapper, el, vaultWrapper) {
          elWrapper
            .find(el)
            .not($wrapperInit)
            .remove()
            .clone()
            .appendTo(vaultWrapper)
            .addClass("removing");
        }

        // Hide wrapper if archive
        function hideWrapper(filterName) {
          if (filterName === "filter-archive") {
            $wrapper.fadeOut(350);
          } else {
            $wrapper.fadeIn(350);
          }
        }

        // sort function callback
        function sort_mods(a, b) {
          return $(b).data("order") < $(a).data("order") ? 1 : -1;
        }

        // If page has a type already passed in the URL
        if (wrapperInit) {
          $wrapperInit = $("." + wrapperInit);
          var title = wrapperInit.replace("filter-", "");

          if (title === "all") {
            title = "Projects";
          }

          hideWrapper(wrapperInit);

          // Animate the module, remove it, clone it, move it to the vault
          removeMods($wrapper, ".project-module", "#js--filter-vault");
          removeMods(
            $archive,
            ".project-archive-module",
            "#js--filter-archive-vault"
          );

          // Update Title
          $title.text(title);
        }

        // On filter click
        $(".js--filter-projects--link").click(function(event) {
          event.preventDefault();

          // Set vars
          var el = $(this);
          var target = $(this).attr("data-type");
          var $target = $("." + target);
          var currentUrl = window.location.href;
          var typeIndex = currentUrl.indexOf("?type=");
          var newUrl;

          $(".project-module").removeClass("fade-in");

          // Update URL
          if (typeIndex >= 0) {
            originalUrl = currentUrl.substring(0, typeIndex);
            if (target === "filter-all") {
              newUrl = originalUrl;
            } else {
              newUrl = originalUrl + "?type=" + target;
            }
          } else {
            if (target === "filter-all") {
              newUrl = currentUrl;
            } else {
              newUrl = currentUrl + "?type=" + target;
            }
          }
          window.history.replaceState(null, null, newUrl);

          // Remove active class from other links, add active to link clicked
          $(".js--filter-projects--link").removeClass("active");
          el.addClass("active");

          // Toggle the states (close the menu)
          filter_toggle_class_toggle();

          // Hide Wrapper if needed
          hideWrapper(target);

          // Change the title
          title = target.replace("filter-", "");
          if (title === "all") {
            title = "Projects";
          }
          $title.text(title);

          // Animate the module, remove it, clone it to the vault
          $wrapper
            .find(".project-module")
            .not($target)
            .addClass("removing");
          $archive
            .find(".project-archive-module")
            .not($target)
            .addClass("removing");

          setTimeout(function() {
            $wrapper
              .find(".removing")
              .remove()
              .clone()
              .appendTo("#js--filter-vault");
            $archive
              .find(".removing")
              .remove()
              .clone()
              .appendTo("#js--filter-archive-vault");
          }, 350);

          // Get relevant modules out of the vault and move them to the main container
          setTimeout(function() {
            $vault
              .find("." + target)
              .remove()
              .clone()
              .appendTo("#js--filter-container");
            $archiveVault
              .find("." + target)
              .remove()
              .clone()
              .appendTo("#js--filter-archive");
            $wrapper
              .find(".project-module")
              .sort(sort_mods)
              .appendTo("#js--filter-container"); // sort elements
          }, 350);

          setTimeout(function() {
            $wrapper.find(".removing").removeClass("removing");
            $archive.find(".removing").removeClass("removing");
          }, 375);
        });
      }
    },
    news_page: {
      init: function() {
        blogSlider();
      }
    },
    page_contact: {
      init: function() {
        if (!respTest) {
          return false;
        }

        // Document Vars
        var $map = $("#map");
        var address = $map.attr("data-address");
        var infoContent = $("#map-content").html();

        // Google Vars
        var geocoder = new google.maps.Geocoder();
        var latitude;
        var longitude;

        /**
         * Geo encode address. When created, initialize the map.
         * If geocode fails, map will not be created.
         */
        geocoder.geocode({ address: address }, function(results, status) {
          latitude = results[0].geometry.location.lat();
          longitude = results[0].geometry.location.lng();

          // Geo Vars
          var latlng = new google.maps.LatLng(latitude, longitude);

          // Recenter map by pixels
          google.maps.Map.prototype.setCenterWithOffset = function(
            latlng,
            offsetX,
            offsetY
          ) {
            var map = this;
            var ov = new google.maps.OverlayView();
            ov.onAdd = function() {
              var proj = this.getProjection();
              var aPoint = proj.fromLatLngToContainerPixel(latlng);
              aPoint.x = aPoint.x + offsetX;
              aPoint.y = aPoint.y + offsetY;
              map.setCenter(proj.fromContainerPixelToLatLng(aPoint));
            };
            ov.draw = function() {};
            ov.setMap(this);
          };

          // Initialize Map
          var map = new google.maps.Map(document.getElementById("map"), {
            center: latlng,
            zoom: 16,
            disableDefaultUI: true,
            scrollwheel: false,
            scaleControl: false,
            styles: [
              {
                featureType: "all",
                elementType: "labels.text.fill",
                stylers: [
                  { saturation: 36 },
                  { color: "#000000" },
                  { lightness: 40 }
                ]
              },
              {
                featureType: "all",
                elementType: "labels.text.stroke",
                stylers: [
                  { visibility: "on" },
                  { color: "#000000" },
                  { lightness: 16 }
                ]
              },
              {
                featureType: "all",
                elementType: "labels.icon",
                stylers: [{ visibility: "off" }]
              },
              {
                featureType: "administrative",
                elementType: "geometry.fill",
                stylers: [{ color: "#000000" }, { lightness: 20 }]
              },
              {
                featureType: "administrative",
                elementType: "geometry.stroke",
                stylers: [
                  { color: "#000000" },
                  { lightness: 17 },
                  { weight: 1.2 }
                ]
              },
              {
                featureType: "landscape",
                elementType: "geometry",
                stylers: [{ color: "#000000" }, { lightness: 20 }]
              },
              {
                featureType: "poi",
                elementType: "geometry",
                stylers: [{ color: "#000000" }, { lightness: 21 }]
              },
              {
                featureType: "road.highway",
                elementType: "geometry.fill",
                stylers: [{ color: "#000000" }, { lightness: 17 }]
              },
              {
                featureType: "road.highway",
                elementType: "geometry.stroke",
                stylers: [
                  { color: "#000000" },
                  { lightness: 29 },
                  { weight: 0.2 }
                ]
              },
              {
                featureType: "road.arterial",
                elementType: "geometry",
                stylers: [{ color: "#000000" }, { lightness: 18 }]
              },
              {
                featureType: "road.local",
                elementType: "geometry",
                stylers: [{ color: "#000000" }, { lightness: 16 }]
              },
              {
                featureType: "transit",
                elementType: "geometry",
                stylers: [{ color: "#000000" }, { lightness: 19 }]
              },
              {
                featureType: "water",
                elementType: "geometry",
                stylers: [{ color: "#000000" }, { lightness: 17 }]
              }
            ]
          });

          // Recenter map by pixels
          var offX = 95;
          var offY = 130;

          if (!respTest) {
            offY = 260;
          }

          map.setCenterWithOffset(latlng, offX, offY);

          // Create Custom Marker
          var plusMarker = {
            path:
              "M13.6, 13.6V0h2.7v13.6H30v2.7H16.4V30h-2.7V16.4H0v-2.7H13.6 z",
            fillColor: "#00bdd4",
            fillOpacity: 0.8,
            scale: 0.5,
            strokeColor: "gold",
            strokeWeight: 0
          };

          // Initialize Marker
          var marker = new google.maps.Marker({
            position: latlng,
            icon: plusMarker,
            map: map,
            title: ""
          });

          var infoWindow = new google.maps.InfoWindow({
            content: infoContent
          });

          marker.addListener("click", function() {
            infoWindow.open(map, marker);
          });

          google.maps.event.trigger(marker, "click");

          // When the dom is ready
          google.maps.event.addListener(infoWindow, "domready", function() {
            var iwOuter = $(".gm-style-iw");

            // Remove white background, arrow, and close button
            iwOuter.prev().css({ display: "none" });
            iwOuter.next().css({ display: "none" });
          });
        });
      }
    }
  };

  // The routing fires all common scripts, followed by the page specific scripts.
  // Add additional events for more control over timing e.g. a finalize event
  var UTIL = {
    fire: function(func, funcname, args) {
      var namespace = Sage;
      funcname = funcname === undefined ? "init" : funcname;
      if (
        func !== "" &&
        namespace[func] &&
        typeof namespace[func][funcname] === "function"
      ) {
        namespace[func][funcname](args);
      }
    },
    loadEvents: function() {
      // Fire common init JS
      UTIL.fire("common");

      // Fire page-specific init JS, and then finalize JS
      $.each(document.body.className.replace(/-/g, "_").split(/\s+/), function(
        i,
        classnm
      ) {
        UTIL.fire(classnm);
        UTIL.fire(classnm, "finalize");
      });

      // Fire common finalize JS
      UTIL.fire("common", "finalize");
    }
  };

  // Load Events
  $(document).ready(UTIL.loadEvents);
})(jQuery); // Fully reference jQuery after this point.

// Add body class on window load
window.onload = function() {
  document.getElementsByTagName("body")[0].className += " loaded";
};
