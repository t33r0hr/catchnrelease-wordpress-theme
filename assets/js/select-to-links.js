(function($){

  $('.widget_polylang .lang-item a').each((idx,el) => {

    $(el).text($(el).attr('lang').substr(0,2).toUpperCase())

  })


})(jQuery);