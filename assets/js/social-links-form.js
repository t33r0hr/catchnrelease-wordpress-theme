(function($){


  window.cnr_toggle_social_form_group = function  ( ev ) {

    console.log('cnr_toggle_social_form_group', ev)

    const link_field_groups = $('ul.cnr-social-links li')

    function handleLinkGroup ( group ) {

      const groupToggle = group.find('input[type="checkbox"]')

      const groupFields = group.find('ul:first')
      groupFields.hide()

      groupToggle.change ( (ev) => {
        ev.target.checked === true ? groupFields.show() : groupFields.hide()
      } )

    }

    for (var i = 0; i < link_field_groups.length; i++) {
      handleLinkGroup($(link_field_groups[i]))
    }
  }

})(jQuery)