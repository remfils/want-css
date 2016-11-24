(function($){
  var controller;

  var scenes = [];

  function initScrollscenes() {
    if (controller) {
      controller.destroy();
    }

    while(scenes.length) {
      var s = scenes.pop();
      s.destory();
    }

    setTimeout(function(){
      controller = new ScrollMagic.Controller()
      $('.scrollscene-dark-area').each(function(index, item) {
        var $item = $(item);

        if (!$item.is(':visible')) {
          return;
        }

        var scene = new ScrollMagic.Scene({triggerElement: item, duration: $item.outerHeight(true)})
              .setClassToggle('header.header', 'white')
        //.addIndicators()
              .triggerHook(0.04)
              .addTo(controller);

        scenes.push(scene);
      });
    }, 0);
  }

  initScrollscenes();

  var timer;

  $(window).on('resize', function () {
    if (timer) {
      clearTimeout(timer);
    }

    timer = setTimeout(function () {
      initScrollscenes();
    }, 10);
  });
})(jQuery);
