(function($) {
  $.fn.loadElem = function(mywin) {
      var elem = this;
       function inView(elem) {
            view_top = mywin.scrollTop() - 300;
            view_bottom = view_top + mywin.height() + 600;
            var height = $(elem).height();
            var top = $(elem).offset().top;
            var bottom = top + height;
            return ( height > 0 ) && ( top <= view_bottom ) && ( bottom >= view_top );
        }

        function maybeLoad(elem) {
            elem.each(function(i, div){
                if($(div).data( "info" ) === "lazy-load" && inView(div)) {
                   $(div).data('info',null);
                   var divId = $(div).attr('id');
                   if(divId == 'bar-box') barGraph();
                }
            })
        }
        maybeLoad(elem);
    
  };
})(jQuery);