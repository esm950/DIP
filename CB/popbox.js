(function(){

  $.fn.popbox = function(options){
    var settings = $.extend({
      selector      : this.selector,
      open          : '.open',
      box           : '.box',
      arrow         : '.arrow',
      arrow_border  : '.arrow-border',
      close         : '.close'
    }, options);

    var methods = {
      open: function(event){
        event.preventDefault();

        var pop = $(this);
        var box = $(this).parent().find(settings['box']);

        //set the length of the box same as td(popword-->div:popbox--->td)
        box.css({'width': (pop.parent().parent().width())});
        //set the arrow in middle 
        box.find(settings['arrow']).css({'left': box.width()/2 - 10});
        box.find(settings['arrow_border']).css({'left': box.width()/2 - 10});

        
        //The box is out==>Close it!
        if(box.css('display') == 'block'){
          methods.close();
        //The box is closed==>Open it!
        } else {
   //Any existing menu box?Close them first!
   //popword->popbox---> td---->tr----->table--->find all open boxes---->close all
          pop.parent().parent().parent().parent().find(settings['box']).fadeOut("fast");
          //make the box appear by change from not display to block display
          box.css({'display': 'block', 'top': 10});
        }
      },

      close: function(){
        $(settings['box']).fadeOut("fast");
      }
    };

    //User clicks?
    $(document).bind('click', function(event){
 
    //CLICKING ELSEWHERE OTHER THAN THE COMMENT?
      if(!$(event.target).closest(settings['selector']).length) {
         //CLOSE THE REPLY BOX!
        methods.close();
         }
      
    });

    return this.each(function(){
      $(this).css({'width': $(settings['box']).width()}); // Width needs to be set otherwise popbox will not move when window resized.
      $(settings['open'], this).bind('click', methods.open);
      $(settings['open'], this).parent().find(settings['close']).bind('click', function(event){
        event.preventDefault();
        methods.close();
      });
    });
  }

}).call(this);
