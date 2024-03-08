window.onload = () => {
  // Variables
  const images = [
    "/assets/imgs/aguacate.jpg",
    "/assets/imgs/apple.jpg",
    "/assets/imgs/arandanos.jpg",
    "/assets/imgs/kiwi.jpg",
    "/assets/imgs/manzana.jpg",
    "/assets/imgs/melon.jpg",
    "/assets/imgs/naranja.jpg",
    "/assets/imgs/piña.jpg",
    "/assets/imgs/kiwis.jpg",
    "/assets/imgs/naranja.jpg",
    "/assets/imgs/uvas.jpg",
  ];

  const timeInterval = 1000;
  let currentPosition = 0;
  let backButton = document.getElementById("backward");
  let advanceButton = document.getElementById("forward");
  let imgContainer = document.getElementById("images");
  // let playButton = document.getElementById("play");
  // let stopButton = document.getElementById("stop");
  let interval;

  // Función para pasar fotos
  function nextImage() {
    if (currentPosition >= images.length - 1) {
      currentPosition = 0;
    } else {
      currentPosition++;
    }
    showImage();
  }

  // Función para retroceder foto
  function previousImage() {
    if (currentPosition <= 0) {
      currentPosition = images.length - 1;
    } else {
      currentPosition--;
    }
    showImage();
  }

  // Función que actualiza la imagen dependiendo de posiciónActual
  function showImage() {
    imgContainer.style.backgroundImage = `url(${images[currentPosition]})`;
    console.log("Displaying image:", images[currentPosition]);
  }

  // Activar autoplay
  function playInterval() {
    interval = setInterval(nextImage, timeInterval);
    // Desactivamos los botones de control
    advanceButton.setAttribute("disabled", true);
    backButton.setAttribute("disabled", true);
    playButton.setAttribute("disabled", true);
    stopButton.removeAttribute("disabled");
  }

  function stopInterval() {
    clearInterval(interval);
    // Activamos los botones de control
    advanceButton.removeAttribute("disabled");
    backButton.removeAttribute("disabled");
    playButton.removeAttribute("disabled");
    stopButton.setAttribute("disabled", true);
  }

  // Eventos
  advanceButton.addEventListener("click", nextImage);
  backButton.addEventListener("click", previousImage);
  // playButton.addEventListener("click", playInterval);
  // stopButton.addEventListener("click", stopInterval);
  // Iniciar
  showImage();
};

/*!
 * Elevator.js
 *
 * MIT licensed
 * Copyright (C) 2015 Tim Holman, http://tholman.com
 */

/*********************************************
 * Elevator.js
 *********************************************/

var Elevator = function (options) {
  "use strict";

  // Elements
  var body = null;

  // Scroll vars
  var animation = null;
  var duration = null; // ms
  var customDuration = false;
  var startTime = null;
  var startPosition = null;
  var endPosition = 0;
  var targetElement = null;
  var verticalPadding = null;
  var elevating = false;

  var startCallback;
  var mainAudio;
  var endAudio;
  var endCallback;

  var that = this;

  /**
   * Utils
   */

  // Thanks Mr Penner - http://robertpenner.com/easing/
  function easeInOutQuad(t, b, c, d) {
    t /= d / 2;
    if (t < 1) return (c / 2) * t * t + b;
    t--;
    return (-c / 2) * (t * (t - 2) - 1) + b;
  }

  function extendParameters(options, defaults) {
    for (var option in defaults) {
      var t = options[option] === undefined && typeof option !== "function";
      if (t) {
        options[option] = defaults[option];
      }
    }
    return options;
  }

  function getVerticalOffset(element) {
    var verticalOffset = 0;
    while (element) {
      verticalOffset += element.offsetTop || 0;
      element = element.offsetParent;
    }

    if (verticalPadding) {
      verticalOffset = verticalOffset - verticalPadding;
    }

    return verticalOffset;
  }

  /**
   * Main
   */

  // Time is passed through requestAnimationFrame, what a world!
  function animateLoop(time) {
    if (!startTime) {
      startTime = time;
    }

    var timeSoFar = time - startTime;
    var easedPosition = easeInOutQuad(
      timeSoFar,
      startPosition,
      endPosition - startPosition,
      duration
    );

    window.scrollTo(0, easedPosition);

    if (timeSoFar < duration) {
      animation = requestAnimationFrame(animateLoop);
    } else {
      animationFinished();
    }
  }

  //            ELEVATE!
  //              /
  //         ____
  //       .'    '=====<0
  //       |======|
  //       |======|
  //       [IIIIII[\--()
  //       |_______|
  //       C O O O D
  //      C O  O  O D
  //     C  O  O  O  D
  //     C__O__O__O__D
  //    [_____________]
  this.elevate = function () {
    if (elevating) {
      return;
    }

    elevating = true;
    startPosition = document.documentElement.scrollTop || body.scrollTop;
    updateEndPosition();

    // No custom duration set, so we travel at pixels per millisecond. (0.75px per ms)
    if (!customDuration) {
      duration = Math.abs(endPosition - startPosition) * 1.5;
    }

    requestAnimationFrame(animateLoop);

    // Start music!
    if (mainAudio) {
      mainAudio.play();
    }

    if (startCallback) {
      startCallback();
    }
  };

  function browserMeetsRequirements() {
    return (
      window.requestAnimationFrame && window.Audio && window.addEventListener
    );
  }

  function resetPositions() {
    startTime = null;
    startPosition = null;
    elevating = false;
  }

  function updateEndPosition() {
    if (targetElement) {
      endPosition = getVerticalOffset(targetElement);
    }
  }

  function animationFinished() {
    resetPositions();

    // Stop music!
    if (mainAudio) {
      mainAudio.pause();
      mainAudio.currentTime = 0;
    }

    if (endAudio) {
      endAudio.play();
    }

    if (endCallback) {
      endCallback();
    }
  }

  function onWindowBlur() {
    // If animating, go straight to the top. And play no more music.
    if (elevating) {
      cancelAnimationFrame(animation);
      resetPositions();

      if (mainAudio) {
        mainAudio.pause();
        mainAudio.currentTime = 0;
      }

      updateEndPosition();
      window.scrollTo(0, endPosition);
    }
  }

  function bindElevateToElement(element) {
    if (element.addEventListener) {
      element.addEventListener("click", that.elevate, false);
    } else {
      // Older browsers
      element.attachEvent("onclick", function () {
        updateEndPosition();
        document.documentElement.scrollTop = endPosition;
        document.body.scrollTop = endPosition;
        window.scroll(0, endPosition);
      });
    }
  }

  function init(_options) {
    // Take the stairs instead
    if (!browserMeetsRequirements()) {
      return;
    }

    // Bind to element click event.
    body = document.body;

    var defaults = {
      duration: undefined,
      mainAudio: false,
      endAudio: false,
      preloadAudio: true,
      loopAudio: true,
      startCallback: null,
      endCallback: null,
    };

    _options = extendParameters(_options, defaults);

    if (_options.element) {
      bindElevateToElement(_options.element);
    }

    if (_options.duration) {
      customDuration = true;
      duration = _options.duration;
    }

    if (_options.targetElement) {
      targetElement = _options.targetElement;
    }

    if (_options.verticalPadding) {
      verticalPadding = _options.verticalPadding;
    }

    window.addEventListener("blur", onWindowBlur, false);

    if (_options.mainAudio) {
      mainAudio = new Audio(_options.mainAudio);
      mainAudio.setAttribute("preload", _options.preloadAudio);
      mainAudio.setAttribute("loop", _options.loopAudio);
    }

    if (_options.endAudio) {
      endAudio = new Audio(_options.endAudio);
      endAudio.setAttribute("preload", "true");
    }

    if (_options.endCallback) {
      endCallback = _options.endCallback;
    }

    if (_options.startCallback) {
      startCallback = _options.startCallback;
    }
  }

  init(options);
};

if (typeof module !== "undefined" && module.exports) {
  module.exports = Elevator;
}

document.addEventListener("DOMContentLoaded", function () {
  const elevator = new Elevator({
    element: document.getElementById("elevator"),
  });
});

elevator.elevate();

// Función para cambiar a modo oscuro
document.getElementById('dark-mode-toggle').addEventListener('click', function() {
  document.body.classList.toggle('dark-mode');
});

// Lógica correspondiente al slider de artículos más vendidos
let swiperCards; // Declarar la variable en un alcance superior

document.addEventListener('DOMContentLoaded', function() {
    swiperCards = new Swiper('.card-content', {
      loop: true,
      spaceBetween: 30,
      grabCursor: true,
    
      pagination: {
        el: '.swiper-pagination',
        clickable: true,
        dynamicBullets: true,
      },
    
      navigation: {
        nextEl: '.swiper-button-next',
        prevEl: '.swiper-button-prev',
      },
    
      breakpoints: {
          600: {
              slidesPerView: 2,
          },
          968: {
              slidesPerView: 3,
          },
        }
    });
});

