(function($){
  var resizeListenerFunction = function() {
    var window_width = window.innerWidth;
    var $col1 = $('.right-align-design-fix.col-1');

    if (window_width > 1000 || window_width < 768) {
      // $col1.attr('style', 'width: ');
      $col1.css('width', '');
      return;
    }

    var total_left_width = $('.block-width-das-ist > .col-2').first().outerWidth() + $('.block-width-das-ist > .col-3').first().outerWidth();

    console.debug(total_left_width);
    console.debug(window_width - total_left_width);

    $col1.attr('style', 'width: ' + (window_width - total_left_width - 53*2 - 20) + 'px !important'); // need to have 20px not to break column layout
  };

  $(window).on('resize', resizeListenerFunction);

  resizeListenerFunction();
})(jQuery);