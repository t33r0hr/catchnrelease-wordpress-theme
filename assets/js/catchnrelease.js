(function($){
  
  if ( window.CATCHANDRELEASE ) {
    return
  }

  window.CATCHANDRELEASE = 1

  function cnr_attachResponsiveClass () {
    $('p > span.embed-youtube').each((i,e)=>{
      $(e).parent().addClass('responsive-media');
    })
  }

  if ( 'function' === typeof window.h5r_addHook ) {
    window.h5r_addHook('done', cnr_attachResponsiveClass)
  }
  cnr_attachResponsiveClass()


})(jQuery)