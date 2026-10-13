'use strict';

var ready = (callback) => {
  if (document.readyState != "loading") callback();
  else document.addEventListener("DOMContentLoaded", callback);
}

ready(() => { 

  var pageId = document.body.id;
  var winWidth = window.innerWidth;
  var mainNav = document.getElementById('main-nav');
  var navBg = document.getElementById('nav-bkg');
  var mainNav = document.getElementById('main-nav');
  var navClass = mainNav.classList;
  var mainLink = document.querySelectorAll('.main-link');
  var subMenu = document.querySelector('.sub-menu');
  var overlay = document.createElement('div');
  overlay.setAttribute('id', 'overlay');
  var searchBtn = document.getElementById('searchButton');
  var searchBox = document.getElementById('searchBox');
  searchBox.style.height = '37px';
  var hamburgerBtn = document.getElementById('hamburger-btn');

  // --- Underline Current Nav Link
  document.querySelectorAll('.main-link a').forEach((l) => { 
    if(l.parentElement.getAttribute('data-hover') == pageId) l.setAttribute('id','current-tab');
  });

  function outerHeight(menu) {
    var s = getComputedStyle(menu);
    return (
      menu.getBoundingClientRect().height +
      parseFloat(s.marginTop) +
      parseFloat(s.marginBottom)
    );
  }

  hamburgerBtn.addEventListener('click', function(){
    this.classList.toggle('is-active');
    var box = mainNav.getBoundingClientRect();
    var docElem = document.documentElement;
    var boxLeft = box.left + window.pageXOffset - docElem.clientLeft;
    subMenu.style.display = 'none';
    var searchStyle = searchBox.classList;
    if(searchStyle.contains('show-it')){
      searchStyle.replace('show-it', 'hide-it');
      searchStyle.replace('search-open', 'search-close');
      overlay.remove();
    }
     document.querySelectorAll('.sub-menu').forEach(menus => { 
      if(menus.classList.contains('sub-open')){
        menus.classList.remove('sub-open');
        menus.style.display = 'none';
      }
    });
    //mainNav.classList.remove('slide-back-mobile').remove('slide-in-mobile');
    if(boxLeft == -300){
       mainNav.classList.toggle('slide-in');
    }else{
       mainNav.classList.toggle('slide-back');
    }
  }, false);

 document.querySelectorAll('.main-link').forEach(ml => { 
  ml.childNodes[1].addEventListener('click', function(event){
    document.querySelectorAll('.sub-menu').forEach(menus => { 
      if(menus.classList.contains('sub-open')){
        menus.classList.remove('sub-open');
        menus.style.display = 'none';
      }
    });
    this.nextElementSibling.style.display = 'block';
    this.nextElementSibling.classList.add('sub-open');
    event.preventDefault();
  });
 });

//-------------- SHOW SEARCH -----------------

 searchBtn.addEventListener('click', function(){
    var style = window.getComputedStyle(searchBox);
    if(style.display === 'none'){
      var main = document.getElementsByTagName('main')[0];
      main.append(overlay);
      searchBox.classList.replace('hide-it', 'show-it');
      searchBox.classList.replace('search-close', 'search-open');
    }else{
      overlay.remove();
      searchBox.classList.replace('search-open', 'search-close');
      searchBox.classList.replace('show-it', 'hide-it');
    }
  }, false);

 //--------------- COOKIES POLICY POPUP ----------------
  var policy = getCookie('policyupdate');
  var policyPop = document.getElementById('policy-update');

  if(policy == null){
    policyPop.className = 'policy-up';
    var policyBtn = document.getElementById('policy-btn');

    policyBtn.querySelectorAll('.global-btn').forEach(pb => { 
      pb.addEventListener('click', function(e){
        e.preventDefault();
        var id = this.id;
        policyPop.className = 'policy-down';
        var d = new Date;
        d.setTime(d.getTime() + 24*60*60*1000*365);
        document.cookie = "policyupdate = visited;path=/;expires=" + d.toGMTString();
        policyPop.remove();
        if (id=='decline-cookies') document.location.href='/company/privacy-policy';
      });
    });

  }else{
    policyPop.remove();
  }

  function getCookie(name){
    var dc = document.cookie;
    var prefix = name + "=";
    var begin = dc.indexOf("; " + prefix);
    if (begin == -1){
        begin = dc.indexOf(prefix);
        if (begin != 0) return null;
    }
    else{
        begin += 2;
        var end = document.cookie.indexOf(";", begin);
        if (end == -1) {
        end = dc.length;
        }
    }
    return decodeURI(dc.substring(begin + prefix.length, end));
  } 

  //---------------- FOOTER SUBSCRIBE FORM ------------------//

  const footerForm = document.getElementById('footer-form');
  const footerInputs = document.querySelectorAll('#footer-form .get-value');
  const footerBtn = document.getElementById('subscribe-btn');

  footerForm.addEventListener('submit', async event => {
    let isNotEmpty = true;
    event.preventDefault();
    footerInputs.forEach(field => {
      if(field.value.length === 0){
        field.setAttribute('aria-required', 'true');
        field.style.border = '1px solid red';
        isNotEmpty = false;
      }
    });

    if(isNotEmpty){
      const div = document.getElementById('subscribe-form');
      let footerTxt = div.getElementsByTagName('p')[0];
      const url = '/support/process-footer-form';
      footerBtn.disabled = true;
      if(document.getElementById('form-error')) document.getElementById('form-error').remove();
      var errorBox = document.createElement('p');
      errorBox.setAttribute('id', 'form-error');
      const formData = new FormData(footerForm);
      try {
        const response = await fetch(url, {
          method: 'post',
          body: formData
        });
        const result = await response.text();
        if(result == 0){
          const txt = document.createTextNode('Something went wrong. Please try again.');
          errorBox.appendChild(txt);
          div.insertBefore(errorBox, footerForm);
          footerBtn.disabled = false;
        }else if(result == 2){
          const txt = document.createTextNode('Please provide valid email address.');
          errorBox.appendChild(txt);
          div.insertBefore(errorBox, footerForm);
          footerBtn.disabled = false;
        }else if(result == 3){
          const txt = document.createTextNode('Email already exists');
          errorBox.appendChild(txt);
          div.insertBefore(errorBox, footerForm);
          footerBtn.disabled = false;
        }else{
          location.href = '/support/signup-thank-you';
        }
      } catch (error) {
         console.log(error);
      }
    }
  });

});

//--------------------- SLIDER CLASS --------------------//

class Slider{
  timeoutId;

  constructor(slides, curr, nav, btn, dir, time){
    this.name = slides;
    this.playing = curr;
    this.navigation = nav;
    this.navbtn = btn;
    this.direction = dir;
    this.t = time;
  }

  getNextPrev(){
    const activeSlide = document.querySelector(this.playing);
    const activeIndex = this.name.indexOf(activeSlide);
    let next, prev;
    if(activeIndex === this.name.length - 1){
      next = this.name[0];
    }else{
      next = this.name[activeIndex + 1];
    }
    if(activeIndex === 0){
      prev = this.name[this.name.length - 1];
    }else{
      prev = this.name[activeIndex - 1];
    }
    return [next, prev];
  }

  getPos(){
    const activeSlide = document.querySelector(this.playing);
    const activeIndex = this.name.indexOf(activeSlide);
    const [next, prev] = this.getNextPrev();
    this.name.forEach((slide, index) => {
      slide.classList.add('fade-out');
      if(index === activeIndex){
        slide.classList.replace('fade-out', 'fade-in');
      }else if(slide === prev){
        slide.classList.replace('fade-in', 'fade-out');
      }else if(slide === next){
        slide.classList.replace('fade-in', 'fade-out');
      }else{
        slide.classList.replace('fade-in', 'fade-out');
      }
      slide.addEventListener("animationend", () => {
        slide.classList.remove('swap');
      });
    });
  }

  setArrows(){
    for(let i = 0;i<2;i++){
      var div = document.createElement("div");
      div.classList.add("slider-arrow");
      var dir = i == 0 ? 'prev-arrow' : 'next-arrow';
      div.classList.add(dir);
      this.navigation.after(div);
    } 
  }

  getArrows(){
    document.querySelectorAll('.slider-arrow').forEach((arr) => {
      arr.addEventListener("click", () => {
        if (arr.classList.contains("next-arrow")) this.getNext();
        else if (arr.classList.contains("prev-arrow")) this.getPrev();
      });
    });
  }

  getNext(){
    clearInterval(this.timeoutId);
    const current = document.querySelector(this.playing);
    const [next, prev] = this.getNextPrev();
    current.classList.add("swap");
    next.classList.add("swap");
    current.classList.replace('fade-in', 'fade-out');
    current.classList.remove("playing");
    next.classList.replace('fade-out', 'fade-in');
    next.classList.add("playing");
    this.getPos();
    this.currNavBtn();
    this.playLoop();
  }

  getPrev(){
    clearInterval(this.timeoutId);
    const current = document.querySelector(this.playing);
    const [next, prev] = this.getNextPrev();
    current.classList.add("swap");
    prev.classList.add("swap");
    current.classList.replace('fade-in', 'fade-out');
    current.classList.remove("playing");
    prev.classList.replace('fade-out', 'fade-in');
    prev.classList.add("playing");
    this.getPos();
    this.currNavBtn();
    this.playLoop();
  }

  setNav(){
    this.name.forEach((slide) => {
      const div = document.createElement("div");
      div.classList.add("slide-btn");
      this.navigation.appendChild(div);
    });
  }

  processNav(){
    document.querySelectorAll(this.navbtn).forEach((btn, i) => {
      btn.addEventListener("click", () => {
        this.getNav(i);
      });
    });
  }

  getNav(i) {
    clearTimeout(this.timeoutId);
    this.name.forEach((slide) => {
      slide.classList.remove("playing");
    });
    const current = this.name[i];
    current.classList.add("playing");
    this.getPos();
    this.currNavBtn();
    this.playLoop();
  }
   
  currNavBtn(){
    const navBtn = document.querySelectorAll(this.navbtn);
    navBtn.forEach((dot) => {
      dot.classList.remove("playing");
    });
    const activeSlide = document.querySelector(this.playing);
    const activeIndex = this.name.indexOf(activeSlide);
    navBtn[activeIndex].classList.add("playing");
    return activeSlide;
  }

  playLoop(){
    this.timeoutId = setTimeout(() => {
      this.getNext();
    }, this.t);
  }

  pauseLoop(){
     clearTimeout(this.timeoutId);
     return document.querySelector(this.playing);
  }

}

//------------------ PROCESS LAZY LOADING ------------------//

class lazyLoad{
 constructor(div){
   this.div = div;
 }

 maybeLoad(){
   const elem = this.div;
   const l = elem.length;
   for(let i=0;i<l;i++){
    let divId = elem[i].getAttribute('id');
    let div = document.getElementById(divId);
    let dataName = div.dataset.info;
    if(dataName == 'lazy-load' && this.inView(div)){
      div.classList.replace('hide-section', 'section-fadein');
      div.removeAttribute('data-info');
      var img = div.querySelectorAll('.lazy');
      for(var j = 0;j < img.length;j++){
         img[j].srcset = img[j].dataset.lazy;
         img[j].src = img[j].dataset.lazy;
         img[j].removeAttribute('data-lazy');
      }
    }
   }
 }

 inView(elem){
  if(typeof pageYOffset != 'undefined'){
    var view_top = pageYOffset;
  }else{
    const B = document.body; 
    const D = document.documentElement; 
    D = (D.clientHeight) ? D : B;
    var view_top =  D.scrollTop;
  }
  const view_bottom = view_top + window.innerHeight + 100;
  const height = elem.offsetHeight;
  const top = this.getTop(elem);
  const bottom = top + height;
  return (height > 0) && (top <= view_bottom) && (bottom >= view_top);
 }

 getTop(el){
    const de = el;
    const box = el.getBoundingClientRect();
    const top = box.top + window.pageYOffset - de.clientTop;
    return top;
 }

}