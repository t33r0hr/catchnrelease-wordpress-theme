(function($){


  const RG_HEAD = /\<head\>(.*?)\<\/head\>/gm


  function parse_tag ( tag_name, source ) {
    
    const pos_open = source.indexOf('<' + tag_name + '>') + (tag_name.length + 2) ;
    const pos_close = source.lastIndexOf('</' + tag_name + '>');

    if ( pos_open === -1 || pos_close === -1 ) {
      return undefined
    }
    return [pos_open, pos_close]
  }

  function parse_head_html ( source ) {

    const pos = parse_tag('head', source)
    if ( pos ) {
      const [ start, end ] = pos;
      return source.substr(start, end-start);
    }
    return undefined
  }

  function equal_node ( left, right, identical=false ) {

    if ( left.nodeType !== right.nodeType ) {
      return false
    }

    if ( left.nodeName !== right.nodeName ) {
      return false
    }

    if ( left.attributes ^ right.attributes ) {
      return false
    }

    if ( left.attributes.length !== right.attributes.length ) {
      return false
    }

    for (var i = 0; i < left.attributes.length; i++) {
      const left_item = left.attributes.item(i);
      const right_item = right.attributes.getNamedItem(left_item.name)

      if ( !right_item ) {
        return false
      }

      if ( identical ) {
        if ( right_item.value !== left_item.value ) {
          return false
        }
      }
    }

    return true
  }

  function find_equal_node ( node, source ) {



  }

  function replace_head ( new_head_contents ) {
    
    const $current_head = $('head');
    const current_head_contents = $current_head.children()
    const current_head_html = $current_head.html();

    const head_contents = $(new_head_contents);

    const scripts = Array.prototype.filter.call(head_contents.filter('script'),function(el){
      return !!el.src
    });

    const styles = Array.prototype.filter.call(head_contents.filter('style, link'),function(el){
      return !!el.href
    });

    for (var i = 0; i < scripts.length; i++) {
      const script = scripts[i]
      const current_script = Array.prototype.find.call(current_head_contents,function(el){
        return el.src === script.src
      })
      if ( !current_script ) {

        $current_head.append(script)

      }
    }

    for (var i = 0; i < styles.length; i++) {
      const style = styles[i]
      const current_style = Array.prototype.find.call(current_head_contents,function(el){
        return el.href === style.href
      })
      if ( !current_style ) {

        $current_head.append(style)

      }
    }
  }


  function update_zone ( selector, update_html ) {

    console.log('update', selector)
    //console.log(update_html)
    $(selector).html(update_html)

  }


  function update_page ( zones, new_source ) {

    const $new_source = $(new_source);

    const new_head = parse_head_html (new_source);
    replace_head(new_head);

    for (var i = 0; i < zones.length; i++) {
      const $zone_source = $new_source.find(zones[i])
      update_zone(zones[i], $zone_source.html())
    }

  }

  function request_page ( url_path ) {

    $.ajax({
      url: url_path,
      success: function(response){

        update_page(['.main-navigation ul.menu', '.site-content', '.site-footer .widget-area'], response)

        prevent_internal_links();

      }
    })

  }

  function on_pop_state ( ev ) {
    console.log('history pop state', ev);
    ev.preventDefault();
    ev.stopPropagation();
  }

  window.addEventListener('popstate', on_pop_state );

  function prevent_internal_links () {
    $('a').click(function(ev){
      
      if ( ev.target.host === location.host ) {
        ev.preventDefault()
        ev.stopPropagation()

        request_page(ev.target.pathname);
      }
      
    })
  }

  prevent_internal_links()

})(jQuery)