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


  const player = getThemeAudio();

  window.__THEME_AUDIO__ = {
    player,
    playing: readStoredState() === 'playing',
    play: () => {
      __THEME_AUDIO__.playing = true;
      getThemeAudioEl().play();
    },
    pause: () => {
      __THEME_AUDIO__.playing = false;
      getThemeAudioEl().pause();
    },
    handleEvent: ( ev ) => {
      if ( !__THEME_AUDIO__.playing ) {
        ev.target.pause();
      }
    }
  };

  const playerElement = getThemeAudioEl()


  const customPlayer = getCustomPlayer()
  const customPlayer_checkbox = getCustomPlayer().find('input[type=checkbox]');
  /*const customPlayer_PlayButton = customPlayer.find('button.play');
  const customPlayer_PauseButton = customPlayer.find('button.pause');*/

  function readStoredState () {
    return localStorage.getItem('cnr-theme-state') || 'playing';
  }

  function writeStoredState ( state ) {
    localStorage.setItem('cnr-theme-state', state);
  }

  function toggleState ( nextState ) {

    const currentState = customPlayer.attr('state') || 'loading'

    if ( nextState !== currentState ) {

      customPlayer.removeClass(currentState);
      customPlayer.addClass(nextState);

    } else if ( !currentState ) {      

      customPlayer.addClass(nextState);

    }

    customPlayer.attr('state', nextState);

  }

  customPlayer_checkbox[0].addEventListener ( 'change', function(ev){

    if ( ev.target.checked ) {
      __THEME_AUDIO__.play();
    } else {
      __THEME_AUDIO__.pause();
    }

  } )
  
  //player.attr('controls',null);
  
  player.on('play',function(ev){
    toggleState('playing')
    customPlayer_checkbox.attr('checked', true );
    writeStoredState('playing');
  })

  player.on('pause',function(ev){
    toggleState('paused')
    customPlayer_checkbox.attr('checked', false );
    writeStoredState('paused');
  })


  toggleState('loading');

  const storedState = readStoredState()

  if ( storedState !== 'playing' ) {
    playerElement.autoplay = false
    //player.attr('autoplay', null);
  }
  
  toggleState(storedState)

  /*if ( storedState === 'playing' ) {
    playerElement.play();
  }*/


})(jQuery);