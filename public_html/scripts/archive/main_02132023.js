 $(function(){
  var myWindow = $(window);
  var hamburger = $("#hamburger-btn");
  var mainNav = $('#main-nav');
  var outerUl = $('#outer-ul');
  var mainLink = $('.main-link');
  var subMenu = $('.sub-menu');
  var navBkg = $('#nav-bkg');
  var winWidth = myWindow.width();
  var overlay = jQuery('<div id="overlay"></div>');
  var searchBtn = $("#searchButton");
  var searchBox = $("#searchBox");
  searchBox.css('height','37px');
  var pageId = $('body').attr('id');
  $.each($('#main-nav ul li a'),function(index){
      if($(this).parent().attr('data-hover') == pageId) $(this).attr('id','current-tab');
  });

  hamburger.click(function(e){
    hamburger.toggleClass("is-active");
    var newWinWidth = myWindow.width();
    var menuPosition = mainNav.offset();
    var percent = menuPosition.left / newWinWidth * 100;
    subMenu.css('display','none');
    mainLink.find('.sub-open').removeClass('sub-open').hide();
    mainLink.find('.fa-caret-up').removeClass('fa-caret-up').addClass('fa-caret-down');
        mainNav.removeClass('slide-back-mobile').removeClass('slide-in-mobile');
      if(menuPosition.left == -300){
         mainNav.toggleClass('slide-in');
      }else{
         mainNav.toggleClass('slide-back');
      }
    e.preventDefault();
  });

  if(winWidth > 1420){
     mainLink.addClass('desktop-link');
     var desktopLink = $('.desktop-link');
     desktopLink.mouseover(function(e){
    var subMenuH = $(this).children('ul').outerHeight();
    navBkg.css('height', subMenuH + 'px');
   });
  }else{
     mainNav.removeClass('reset-outer-ul').css('height','100%');
     searchBtn.attr('data-ms','mobile-search');
     searchBox.css('top','77px');
  }

  mainLink.children('a').click(function(e){
    if(hamburger.is(':hidden')){
      
    }else{
      e.preventDefault();
      $(this).parents('.main-link').siblings().find('.sub-open').removeClass('sub-open').hide();
      $(this).parents('.main-link').siblings().find('.fa-caret-up').removeClass('fa-caret-up').addClass('fa-caret-down');
        $(this).next().addClass('sub-open').slideToggle(300);
        if($(this).next().hasClass('.sub-open')){
          $(this).children('i').toggleClass('fa-caret-down');
        }
        else{
            $(this).children('i').toggleClass('fa-caret-up');
        }
    }
  });

  function toggleNav(){
    var newWin = myWindow.width();
    var newHeight = myWindow.height();
    if(newWin < 1420){
    mainNav.removeClass('reset-outer-ul').css('height','100%');
    mainLink.removeClass('desktop-link');
    subMenu.css('display','none');
    searchBtn.attr('data-ms','mobile-search');
    searchBox.hide();
    }else{
      overlay.remove();
      searchBtn.attr('data-ms','');
      searchBox.css({'top':'22px','height':'37px'});
      searchBox.fadeIn();
      mainLink.find('.sub-open').removeClass('sub-open').hide();
      subMenu.css('display','block');
      mainLink.children('a').find('.sub-open').css('display','block');
        mainNav.removeClass('slide-back').removeClass('slide-in').removeClass('slide-back-mobile').removeClass('slide-in-mobile').addClass('reset-outer-ul').height('65px');
        hamburger.removeClass('is-active');
        mainLink.addClass('desktop-link');
        var desktopLink = $('.desktop-link');
        $(document).ready(function(){
       desktopLink.mouseover(function(e){
        var subMenuH = $(this).children('ul').outerHeight();
        navBkg.css('height', subMenuH + 'px');
       });
      });
    }
  }
  
  myWindow.on('load, resize', toggleNav);

  searchBtn.click(function(e){
        e.preventDefault();
        $(this).toggleClass(function(){
        if(searchBox.is(':hidden')){
          overlay.appendTo($('main'));
          searchBox.css('top','47px');
          searchBox.fadeIn();
          searchBox.animate({
            height: "37px"
            }, {
            duration: 200,
            specialEasing:{
            width: 'linear'
            }
          });
        }else{
          if(searchBtn.attr('data-ms') == 'mobile-search'){
           overlay.remove();
           searchBox.hide();
          }
         }
      });
    });


var policy = getCookie("policyupdate");
var stickyBtn = $('#sticky-request');
var myWindow =  $(window);
if(policy == null){
 $('#policy-update').animate({'left':'0', 'bottom':'+='+'100px'}, {duration: 600, complete: function(){
   if(myWindow.width() < 845) stickyBtn.css('bottom','103px');
   if(myWindow.width() > 502 && myWindow.width() < 541) stickyBtn.css('bottom','107px');
   if(myWindow.width() > 336 && myWindow.width() < 502) stickyBtn.css('bottom','125px');
   if(myWindow.width() < 336) stickyBtn.css('bottom','140px');
 }});
 myWindow.on('load, resize', toggleSticky);
}else{
  $('#policy-update').remove();
  stickyBtn.css('bottom','0');
}

function toggleSticky(){
 var newWin = myWindow.width();
 if(newWin < 845){
   stickyBtn.css('bottom','103px');
 }
 else if(newWin > 502 && newWin < 541){
   stickyBtn.css('bottom','107px');
 }
 else if(newWin > 336 && newWin < 502){
   stickyBtn.css('bottom','125px');
 }
 else{
   stickyBtn.css('bottom','140px');
 }
}

$('#policy-btn a').click(function(e){
  e.preventDefault();
  //stickyBtn.css('bottom','0');
  //myWindow.off('load, resize', toggleSticky);
  $('#policy-update').animate({'left':'0', 'bottom':'-='+'200px'}, 
    { duration: 400, complete: function(){
        var d = new Date;
      d.setTime(d.getTime() + 24*60*60*1000*365);
      document.cookie = "policyupdate = visited;path=/;expires=" + d.toGMTString();
      $('#policy-update').remove();
    }
   });
});

function getCookie(name) {
  var dc = document.cookie;
  var prefix = name + "=";
  var begin = dc.indexOf("; " + prefix);
  if (begin == -1) {
      begin = dc.indexOf(prefix);
      if (begin != 0) return null;
  }
  else
  {
      begin += 2;
      var end = document.cookie.indexOf(";", begin);
      if (end == -1) {
      end = dc.length;
      }
  }
  return decodeURI(dc.substring(begin + prefix.length, end));
} 
});

function loadScript(url, callback){
  var script = document.createElement("script");
  script.type = "text/javascript";
  if (script.readyState){  //IE
      script.onreadystatechange = function(){
          if (script.readyState == "loaded" ||
                  script.readyState == "complete"){
              script.onreadystatechange = null;
              callback();
          }
      };
  }else{  //Others
      script.onload = function(){
          callback();
      };
  }
  script.src = url;
  document.getElementsByTagName("head")[0].appendChild(script);
}

(function($){
  $.fn.loadElem = function(mywin){
      var elem = this;
       function inView(elem) {
            var view_top = mywin.scrollTop() - 300;
            var view_bottom = view_top + mywin.height() + 600;
            var height = $(elem).height();
            var top = $(elem).offset().top;
            var bottom = top + height;
            return ( height > 0 ) && ( top <= view_bottom ) && ( bottom >= view_top );
        }

        function maybeLoad(elem){
            elem.each(function(i, div){
                if($(div).data( "info" ) === "lazy-load" && inView(div)){
                   $(div).data('info',null);
                   var divId = $(div).attr('id');
                   window[divId]();
                }
            });
        }
        maybeLoad(elem);   
  };
})(jQuery);
