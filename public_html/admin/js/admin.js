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

  $.each($('#left-sidebar ul li a'),function(index){
      if($(this).parent().attr('data-hover') == pageId) $(this).attr('id','current-sidebar');
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

});
