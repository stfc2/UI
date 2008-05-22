  function start() {
      for ( var i = 1; i <= 10; i++ ) {
          if ( document.getElementById( "timer"+i )) {
              var params = document.getElementById( "timer"+i ).title.split( "_" );
              var time = parseInt( params[1] );
              var type = params[3];
              timer( "timer"+i, time, type );
          }
      }
  }

  function timer( timer, time, type ) {
      var t = time;

      if ( t > 0 ) {
          var h = Math.floor( t / 3600 );
          var m = Math.floor( ( t - h * 3600 ) / 60 );
          var s = t - h * 3600 - m * 60;

          if ( type == 1 ) {
              if ( h == 0 ) h = "";
              else h = h + " Ore ";

              if ( m == 0 && h == 0 ) m = "";
              else m = m + " Minuti ";

              if ( s == 0 && m == 0 && h == 0 ) s = "";
              else s = s + " Secondi";

              document.getElementById( timer ).firstChild.nodeValue = h + m + s;
          }
          else if ( type == 2 ) {
              if ( m < 10 ) m = "0" + m;
              if ( s < 10 ) s = "0" + s;

              document.getElementById( timer ).firstChild.nodeValue = h + ":" + m + ":" + s;
          }
          else if ( type == 3 ) {
              if ( h == 0 ) h = "";
              else h = h + " Ore ";

              if ( m == 0 && h == 0 ) m = "";
              else m = m + " Minuti ";

              if ( s == 0 && m == 0 && h == 0 ) s = "";
              else s = s + " Secondi";

              document.getElementById( timer ).firstChild.nodeValue = h + m + s;
          }
          else if ( type == 4 ) {
              if ( m < 10 ) m = "0" + m;
              if ( s < 10 ) s = "0" + s;

              document.getElementById( timer ).firstChild.nodeValue = h + ":" + m + ":" + s;
          }
          else if ( type == 5 ) {
              if ( m < 10 ) m = "0" + m;
              if ( s < 10 ) s = "0" + s;

              document.getElementById( timer ).firstChild.nodeValue = h + ":" + m + ":" + s;
          }

          var time = t - 1;
          window.setTimeout( 'timer( "'+timer+'", "'+time+'", "'+type+'" )', 1000 );
      }
      else {
          if ( type == 1 ) document.getElementById( timer ).firstChild.nodeValue= "Completato";
          else if ( type == 2 ) document.getElementById( timer ).firstChild.nodeValue= "0:00:00";
          else if ( type == 3 ) window.setTimeout( 'timer( "'+timer+'", "180", "'+type+'" )', 1000 );
          else if ( type == 4 ) window.setTimeout( 'timer( "'+timer+'", "180", "'+type+'" )', 1000 );
          else if ( type == 5 ) document.getElementById( timer ).firstChild.nodeValue= "Al completamento";
      }
  }
