(function($){


  const player = $('.navigation-top .widget audio');
  const playerElement = player[0];

  const customPlayer = $('.navigation-top .widget-audio-player');
  const customPlayer_PlayButton = customPlayer.find('button.play');
  const customPlayer_PauseButton = customPlayer.find('button.pause');

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

  customPlayer_PlayButton.click(function(ev){
    playerElement.play();
    writeStoredState('playing')
  });

  
  customPlayer_PauseButton.click(function(ev){
    playerElement.pause();
    writeStoredState('paused')
  });
  
  //player.attr('controls',null);
  
  player.on('play',function(ev){
    toggleState('playing')
  })

  player.on('pause',function(ev){
    toggleState('paused')
  })

  window.__THEME_AUDIO__ = player;

  toggleState('loading');

  const storedState = readStoredState()

  if ( storedState !== 'playing' ) {
    player.attr('autoplay', null);
  }
  
  toggleState(storedState)




})(jQuery);