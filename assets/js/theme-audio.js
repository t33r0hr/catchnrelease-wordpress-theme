(function($){

 
  if ( window.__THEME_AUDIO__ ) {
    return
  }

  function getThemeAudio () {
    return $('.navigation-top .widget_theme_audio_widget audio');
  }

  function getCustomPlayer () {
    return $('.navigation-top .widget_theme_audio_widget .controls');
  }

  function getThemeAudioEl () {
    return document.querySelector('.navigation-top .widget_theme_audio_widget audio');
  }

  function getPlayerCheckbox () {
    return getCustomPlayer().find('input[type=checkbox]');
  }

  function readStoredState () {
    return localStorage.getItem('cnr-theme-state') || 'playing';
  }

  function writeStoredState ( state ) {
    localStorage.setItem('cnr-theme-state', state);
  }

  function toggleState ( nextState ) {

    const customPlayer = getCustomPlayer()
    const currentState = customPlayer.attr('state') || 'loading'

    if ( nextState !== currentState ) {

      customPlayer.removeClass(currentState);
      customPlayer.addClass(nextState);

    } else if ( !currentState ) {      

      customPlayer.addClass(nextState);

    }

    customPlayer.attr('state', nextState);

  }

  window.__THEME_AUDIO__ = {

    inited: false,

    player: getThemeAudio(),
    
    playing: readStoredState() === 'playing',

    init: ( player=getThemeAudioEl() ) => {
      if ( __THEME_AUDIO__.inited ) {
        return;
      }

      const state = readStoredState();
      if ( state !== 'playing' ) {
        player.autoplay = false
      } else {
        getPlayerCheckbox().attr('checked', true );        
      }

      __THEME_AUDIO__.inited = true
    },

    play: ( player=getThemeAudioEl() ) => {
      __THEME_AUDIO__.playing = true;
      player.play();
      writeStoredState('playing');
    },
    pause: ( player=getThemeAudioEl() ) => {
      __THEME_AUDIO__.playing = false;
      player.pause();
      writeStoredState('paused');
    },
    handleControlCheckbox: ( ev ) => {
      if ( ev.target.checked ) {
        __THEME_AUDIO__.play();
      } else {
        __THEME_AUDIO__.pause();
      }
    },
    handleEvent: ( ev ) => {
      if ( !__THEME_AUDIO__.inited ) {
        __THEME_AUDIO__.init(ev.target);
      }
      //console.log('__THEME_AUDIO__::Event(%s)', ev.type)
      if ( !__THEME_AUDIO__.playing ) {
        __THEME_AUDIO__.pause(ev.target)
        getPlayerCheckbox().attr('checked', false );
      }
    }
  };

})(jQuery);