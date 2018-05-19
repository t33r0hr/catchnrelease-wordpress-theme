(function($){

  function getAudio () {
    return $('.widget_theme_audio_widget audio')
  }

  function getAudioElement () {
    return getAudio()[0]
  }

  function getCustomPlayer () {
    return $('.navigation-top .widget_theme_audio_widget');
  }

  function getCustomPlayerCheckbox () {
    return $('.navigation-top .widget_theme_audio_widget input[type=checkbox]');
  }

  
  /*const customPlayer_PlayButton = customPlayer.find('button.play');
  const customPlayer_PauseButton = customPlayer.find('button.pause');*/

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
  
  const storedState = readStoredState()

  function UpdatePlayerState () {
    if ( storedState !== 'playing' ) {
      const a = getAudioElement()
      console.log('AUDIO UNSETTING AUTOPLAY', a)
      a.autoplay = false
      const clone = document.createElement('audio')
      clone.loop = true
      clone.innerHTML = a.innerHTML
      a.parentElement.replaceChild(clone,a);
      clone.pause();
    } else {
      getAudioElement().play()
    }
  }

  function registerEventListeners ( audioElement=getAudio() ) {
    audioElement.on('play',function(ev){
      //console.log('audio started playing', ev)
      toggleState('playing')
      getCustomPlayerCheckbox().attr('checked', true );
      writeStoredState('playing');
    })

    audioElement.on('pause',function(ev){
      toggleState('paused')
      getCustomPlayerCheckbox().attr('checked', false );
      writeStoredState('paused');
    })
  }
    
  UpdatePlayerState();

  if ( window.__THEME_AUDIO__ ) {
    //console.log('window.__THEME_AUDIO__ already exists', window.__THEME_AUDIO__)
    return
  }

  window.__THEME_AUDIO__ = true

  registerEventListeners()

  const player = getAudio()
  const playerElement = getAudioElement()

  const customPlayer = getCustomPlayer()
  const customPlayer_checkbox = getCustomPlayer().find('input[type=checkbox]');


  getCustomPlayerCheckbox().change (function(ev){
    ////console.log('Toggled Audio Checkbox', ev);
    if ( ev.target.checked ) {
      playerElement.play();
    } else {
      playerElement.pause();
      writeStoredState('paused')
    }
  } )
  
  //player.attr('controls',null);

  //window.__THEME_AUDIO__ = player;

  toggleState('loading');

  UpdatePlayerState()
  
  toggleState(storedState)

  /*if ( storedState === 'playing' ) {
    playerElement.play();
  }*/

  /** debuggin */
/*
  getAudio().on('play pause load unload', function(ev){
    console.log('audio event "%s"', ev.type, ev);
  })*/


})(jQuery);