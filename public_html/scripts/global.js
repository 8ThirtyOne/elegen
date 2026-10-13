'use strict';

let ready = (callback) => {
  if (document.readyState != "loading") callback();
  else document.addEventListener("DOMContentLoaded", callback);
}

ready(() => { 

  const pageId = document.body.id;
  let winWidth = window.innerWidth;
  const mainNav = document.getElementById('main-nav');
  const navBg = document.getElementById('nav-bkg');
  const navClass = mainNav.classList;
  const mainLink = document.querySelectorAll('.main-link');
  const subMenu = document.querySelector('.sub-menu');
  const overlay = document.createElement('div');
  overlay.setAttribute('id', 'overlay');
  const searchBtn = document.getElementById('searchButton');
  const searchBox = document.getElementById('searchBox');
  searchBox.style.height = '37px';
  const hamburgerBtn = document.getElementById('hamburger-btn');

  //---- Underline Current Nav Link ----//
  document.querySelectorAll('.main-link a').forEach((l) => { 
    if(l.parentElement.getAttribute('data-hover') == pageId) l.setAttribute('id','current-tab');
  });

  if(winWidth > 1420){
     document.querySelectorAll('.main-link').forEach(link => { 
     link.classList.add('desktop-link');
     link.addEventListener('mouseover', function() { 
        const id = this.childNodes[3].getAttribute('id');
        const subMenuH = outerHeight(document.getElementById(id));
        navBg.style.height = subMenuH + 'px';
     }, false);
    });
  }else{
     navClass.remove('reset-outer-ul');
     mainNav.style.height = '100%';
     searchBox.style.top = '77px';
  }

  function outerHeight(menu) {
    const s = getComputedStyle(menu);
    return (
      menu.getBoundingClientRect().height +
      parseFloat(s.marginTop) +
      parseFloat(s.marginBottom)
    );
  }

  window.onresize = toggleNav;

  function toggleNav(){
    const navClass = mainNav.classList;
    if(window.innerWidth < 1420){
       navClass.remove('reset-outer-ul');
       mainNav.style.height = '100%';
       document.querySelectorAll('.main-link').forEach(ml => { 
         ml.classList.remove('desktop-link');
       });
       document.querySelectorAll('.sub-menu').forEach(sm => { 
         sm.style.display = 'none';
       });
    }else{
       overlay.remove();
       document.querySelectorAll('.sub-menu').forEach(sm => { 
         sm.style.display = 'block';
       });
       navClass.remove('slide-back');
       navClass.remove('slide-in');
       navClass.remove('slide-back-mobile');
       navClass.remove('slide-in-mobile');
       navClass.add('reset-outer-ul');
       mainNav.style.height = '65px';
       hamburgerBtn.classList.remove('is-active');
       document.querySelectorAll(".main-link").forEach(ml => { 
         ml.classList.add('desktop-link');
         ml.addEventListener('mouseover', function() { 
            const id = this.childNodes[3].getAttribute('id');
            const subMenuH = outerHeight(document.getElementById(id));
            navBg.style.height = subMenuH + 'px';
          }, false);
       });
       document.querySelectorAll('.sub-menu').forEach(menus => { 
          if(menus.classList.contains('sub-open')){
            menus.classList.remove('sub-open');
            menus.style.display = 'none';
          }
      });
    }
  }

  hamburgerBtn.addEventListener('click', function(){
    this.classList.toggle('is-active');
    const newWinWidth = window.innerWidth;
    const box = mainNav.getBoundingClientRect();
    const docElem = document.documentElement;
    const boxLeft = box.left + window.pageXOffset - docElem.clientLeft;
    subMenu.style.display = 'none';
    const searchStyle = searchBox.classList;
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
    const style = window.getComputedStyle(hamburgerBtn);
    if(style.display === 'none'){
     //normal clicks
    }else{
      document.querySelectorAll('.sub-menu').forEach(menus => { 
        if(menus.classList.contains('sub-open')){
          menus.classList.remove('sub-open');
          menus.style.display = 'none';
        }
      });
      this.nextElementSibling.style.display = 'block';
      this.nextElementSibling.classList.add('sub-open');
      event.preventDefault();
    }
  });
 });

//-------------- SHOW SEARCH -----------------

 searchBtn.addEventListener('click', function(){
    const style = window.getComputedStyle(searchBox);
    if(style.display === 'none'){
      const main = document.getElementsByTagName('main')[0];
      main.append(overlay);
      //searchBox.style.top = '67px';
      searchBox.classList.replace('hide-it', 'show-it');
      searchBox.classList.replace('search-close', 'search-open');
    }else{
      overlay.remove();
      searchBox.classList.replace('search-open', 'search-close');
      searchBox.classList.replace('show-it', 'hide-it');
    }
  }, false);

 //--------------- COOKIES POLICY POPUP ----------------//
 
  const policy = getCookie('policyupdate');
  const policyPop = document.getElementById('policy-update');

  if(policy == null){
    policyPop.className = 'policy-up';
    const policyBtn = document.getElementById('policy-btn');

    policyBtn.querySelectorAll('.global-btn').forEach(pb => { 
      pb.addEventListener('click', function(e){
        e.preventDefault();
        const id = this.id;
        policyPop.className = 'policy-down';
        const d = new Date;
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
    const dc = document.cookie;
    const prefix = name + "=";
    let begin = dc.indexOf("; " + prefix);
    let end = 0;
    if (begin == -1){
        begin = dc.indexOf(prefix);
        if (begin != 0) return null;
    }
    else{
        begin += 2;
        end = document.cookie.indexOf(";", begin);
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
    if(this.direction == 'fade'){
        this.name.forEach((slide, index) => {
        const slideClass = slide.classList;
        if(!slideClass.contains('fade-out')) slideClass.add('fade-out');
        if(index === activeIndex){
          slide.classList.replace('fade-out', 'fade-in');
        }else if(slide === prev){
          slide.classList.replace('fade-in', 'fade-out');
        }else if(slide === next){
          slide.classList.replace('fade-in', 'fade-out');
        }else{
          slide.classList.replace('fade-in', 'fade-out');
        }
        slide.addEventListener('animationend', () => {
          slide.classList.remove('swap');
        });
      });
    }
    else if(this.direction == 'horizontal'){
      slides.forEach((slide, index) => {
        const slideClass = slide.classList;
        if (index === activeIndex) {
          if(!slideClass.contains('slider-right')) slideClass.add('slider-right');
          slideClass.replace('slider-right', 'slider-zero');
        } else if (slide === prev) {
          if(!slideClass.contains('slider-zero')) slideClass.add('slider-zero');
          slideClass.add('slider-zero');
          slideClass.replace('slider-zero', 'slider-left');
        } else if (slide === next) {
          if(!slideClass.contains('slider-left')) slideClass.add('slider-left');
          slideClass.add('slider-left');
          slideClass.replace('slider-left', 'slider-right');
        } else {
           if(!slideClass.contains('slider-left')) slideClass.add('slider-left');
          slideClass.add('slider-left');
          slideClass.replace('slider-left', 'slider-right');
        }
        slide.addEventListener('transitionend', () => {
          slide.classList.remove('swap');
        });
      });
    }
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
      /*if(div.classList.contains('section-slider')){
        const sliders = document.querySelectorAll('.section-slider');
        sliders.forEach((sl, i) => {
          const slides = Array.from(sl.querySelectorAll('.slide'));
          const id = '#'+sl.getAttribute('id');
          let slider = new Slider(slides, id+' .slide.playing' , sl.querySelector('.slide-nav'), 
                                  id+' .slide-btn', 'fade', 7000);
          slider.getPos();
          slider.playLoop();
          slider.setNav();
          slider.currNavBtn();
          slider.processNav();
          slider.setArrows();
          slider.getArrows();
        });
      }*/
      div.removeAttribute('data-info');
      var img = div.querySelectorAll('.lazy');
      if(img){
        for(var j = 0;j < img.length;j++){
           img[j].srcset = img[j].dataset.lazy;
           img[j].src = img[j].dataset.lazy;
           img[j].removeAttribute('data-lazy');
        }
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
