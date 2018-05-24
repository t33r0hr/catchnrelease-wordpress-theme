(function($){



  function replaceLinkCaptions () {
    $('.widget_polylang .lang-item a').each((idx,el) => {

      $(el).text($(el).attr('lang').substr(0,2).toUpperCase())

    })
  }

  replaceLinkCaptions()

  const obs = new MutationObserver((record) => {
    replaceLinkCaptions()
  } )

  obs.observe(
    $('.widget_polylang').parent()[0],
    {childList: true}
  );

  window.addEventListener('DOMContentLoaded',()=>{
    replaceLinkCaptions()
  })

})(jQuery);