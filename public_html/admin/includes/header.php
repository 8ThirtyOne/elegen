
<body id="<?php echo $bodyid; ?>">

<header role="banner">

    <div id="main-header-wrap">
    
      <section id="main-header" class="clear-header">

          <div id="nav-wrap">

             <div id="logo-wrap">

				  <a href="/" id="header-logo">
		
					<svg version="1.1" id="header-logo-img" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
					     viewBox="0 0 591 75" style="enable-background:new 0 0 591 75;" xml:space="preserve">
					<style type="text/css">
					    .ht0{fill:#FFFFFF}
					</style>
					<g>
					    <path class="ht0" d="M13.32,15.09H53.3V2.07H0v13.02H13.32z M53.3,60.15H13.32V44.08h38.55V31.57H13.32H0v41.8h53.3V60.15z"/>
					    <polygon class="ht0" points="104.35,2.07 104.35,73.37 154.39,73.37 154.39,60.96 117.78,60.96 117.78,2.07    "/>
					    <path class="ft0" d="M217.65,15.09h39.97V2.07h-53.3v13.02H217.65z M257.62,60.15h-39.97V44.08h38.55V31.57h-38.55h-13.32v41.8
					        h53.3V60.15z"/>
					    <path class="ht0" d="M369.91,11.02c-7.32-7.22-16.88-10.88-26.45-10.88c-25.12,0-37.63,18.51-37.63,38.55
					        c0,18.72,10.88,36.31,37.63,36.31c12.51,0,21.36-4.78,28.38-12.82V32.18h-30.51v12h18.21v12.61c-5.59,4.48-10.48,5.7-16.07,5.7
					        c-17.7,0-24.51-12.1-24.51-23.8c0-14.65,9.26-26.24,24.51-26.24c6.2,0,13.32,2.54,18.11,7.12L369.91,11.02z"/>
					    <path class="ht0" d="M436.62,15.09h39.97V2.07h-53.3v13.02H436.62z M476.6,60.15h-39.97V44.08h38.55V31.57h-38.55H423.3v41.8h53.3
					        V60.15z"/>
					    <polygon class="ht0" points="576.57,46.28 541.69,2.07 530.8,2.07 530.8,73.37 544.23,73.37 544.23,25.3 581.66,73.37 590,73.37 
					        590,2.07 576.57,2.07    "/>
					</g>
					</svg>


				  </a>
				  <button id="hamburger-btn" class="hamburger hamburger--collapse" type="button">
					  <span class="hamburger-box">
						<span class="hamburger-inner"></span>
					  </span>
				  </button>

			  </div>
			  
              <nav id="main-nav">
                
                <ul id="outer-ul">
                    
                    <li class="main-link" data-hover="manager">
                    
	                <a href="#">MANAGE</a>
					<ul id="gnb-products" class="sub-menu">
						<ul class="gnb_theme-green gnb_dt-none">
							<li><a href="/admin/manager/list">Manager Accounts</a></li>
							<li><a href="/admin/manager/subscribers/list">Subscribers</a></li>
						</ul>
                   </ul>
                
                    </li>

           <li class="main-link" data-hover="news">
                    
                    <a href="#"><i class="fa fa-caret-down"></i>NEWS &amp; EVENTS</a>
					<ul id="gnb-news" class="sub-menu">
						<ul class="gnb_theme-green gnb_dt-none">
							<li><a href="/admin/news-events/events/list">Events</a></li>
							<li><a href="/admin/news-events/news/list">News</a></li>
						</ul>
                    </ul>

                    </li>
                    
                    <li class="main-link" data-hover="resources">
                    
                    <a href="#">RESOURCES</a>
					<ul id="gnb-resources" class="sub-menu">
						<ul class="gnb_theme-green gnb_dt-none">
							<li><a href="/admin/resources/literatures/list">Literature</a></li>
							<li><a href="/admin/resources/videos/list">Videos</a></li>
						</ul>
                   </ul>

                    </li>

                    <li class="main-link" data-hover="support">
                    
                    <a href="#"><i class="fa fa-caret-down"></i>SUPPORT</a>
						<ul id="gnb-support" class="sub-menu">
						<ul class="gnb_theme-green gnb_dt-none">
							<li><a href="/admin/support/request-info/list">Request Info</a></li>
						</ul>
                        </ul>
            
                    </li>

                  <li class="main-link" data-hover="company">
                    
                    <a href="#"><i class="fa fa-caret-down"></i>COMPANY</a>
										<ul id="gnb-news" class="sub-menu">
											<ul class="gnb_theme-green gnb_dt-none">
												<li><a href="/admin/company/elegen-team/list">Elegen Team</a></li>
											</ul>
                    </ul>

                    </li>
                           
                </ul>

                <div id="nav-bkg"></div>
                
            </nav>

            <div id="admin-logout">
	            <a href="/admin/logout" id="logout-btn" class="global-btn smooth-hover">LOGOUT</a>
	            <p>Loggedin as <a id="user-in" href="/admin/edit-portal" class="smooth-hover"><?php if(!empty($username)) echo $username; ?></a></p>
	        </div>

           </div>
           <!-- //nav-wrap -->     

      </section>
      <!-- //main-header -->
    </div>
    <!-- //main-header-wrap -->

</header>
