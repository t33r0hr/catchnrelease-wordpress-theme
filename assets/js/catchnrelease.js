(function($){
  
  if ( window.CATCHANDRELEASE ) {
    return
  }

  window.CATCHANDRELEASE = 1

  $('p > span.embed-youtube').each((i,e)=>{
    $(e).parent().addClass('responsive-media');
  })


})(jQuery)