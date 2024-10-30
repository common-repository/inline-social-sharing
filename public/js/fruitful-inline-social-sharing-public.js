jQuery(function($) {
  'use strict';

  /**
   * jQuery function to prevent default anchor event and take the href * and the title to make a share popup
   *
   * @param  {[object]} e           [Mouse event]
   * @param  {[integer]} intWidth   [Popup width defalut 500]
   * @param  {[integer]} intHeight  [Popup height defalut 400]
   * @param  {[boolean]} blnResize  [Is popup resizeabel default true]
   */
  $.fn.customerPopup = function(e, intWidth, intHeight, blnResize) {

    // Prevent default anchor event
    e.preventDefault();

    // Set values for window
    var intWidth = intWidth || '500';
    var intHeight = intHeight || '400';
    var strResize = (blnResize ? 'yes' : 'no');

    // Set title and open popup with focus on it
    var strTitle = ((typeof this.attr('title') !== 'undefined') ? this.attr('title') : 'Social Share'),
      strParam = 'width=' + intWidth + ',height=' + intHeight + ',resizable=' + strResize,
      objWindow = window.open(this.attr('href'), strTitle, strParam).focus();
  }

  /* ================================================== */

  if ($('.fiss-share-buttons-wrapper').length) {
    $('.fiss-share-buttons a').on("click", function(e) {
      $(this).customerPopup(e);
    });

    calcWidth();
    $( window ).resize(calcWidth);
  }

  function calcWidth() {
    var width = $('.fiss-share-buttons-wrapper').width();

    var totalWidth = 0;
    $('.fiss-share-buttons-wrapper a').each(function(index) {
      totalWidth += parseInt($(this).width(), 10);
    });

    if ( (totalWidth / $('.fiss-share-buttons-wrapper').length) + 100 >  width) {
      $('.fiss-share-buttons-wrapper').addClass('fiss-small');
    } else {
      $('.fiss-share-buttons-wrapper').removeClass('fiss-small');

      totalWidth = 0;
      $('.fiss-share-buttons-wrapper a').each(function(index) {
        totalWidth += parseInt($(this).width(), 10);
      });

      if ( (totalWidth / $('.fiss-share-buttons-wrapper').length) + 100 >  width) {
        $('.fiss-share-buttons-wrapper').addClass('fiss-small');
      }
    }
  }

});
