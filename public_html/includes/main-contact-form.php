<section id="main-contact-form" class="wide-section ask-dna-form no-margin">
 
            <div class="page-inner">

              <form method="post" name="askDnaFrm" id="home-form" role="form">
                <input type="hidden" name="refpage"  value="<?php echo $PageName; ?>" />

                 <div id="form-note">

                    <h2>Ask about ENFINIA<sup class="fa fa-trademark"></sup> High-Accuracy, Long DNA</h2>

                      <h4>* Required</h4>

                 </div>

                     <fieldset id="field-one">
                        <label for="First Name" class="visually-hidden">First Name<span>*</span></label>
                        <input type="text" name="first" id="first" class="get-value" placeholder="*First Name" pattern="[A-Za-z]{1,50}" title="Only letters are allowed." aria-required="true" maxlength="50" tabindex="1" />

                        <label for="Email Address" class="visually-hidden">Email Address<span>*</span></label>
                        <input type="email" name="email" class="get-value" id="email" placeholder="*Email Address" aria-required="true" maxlength="100" tabindex="3" />
  
                        <label for="Zip Code" class="visually-hidden">Zip Code<span>*</span></label>
                        <input type="text" name="zip" id="zip" class="get-value" placeholder="*Zip Code" pattern="[a-zA-Z0-9\-\s]+" title="Only valid zip codes are allowed." aria-required="true" maxlength="15" tabindex="5" />

                        <label for="Phone" class="visually-hidden">Phone<span>*</span></label>
                        <input type="text" name="phone" id="phone" placeholder="Phone" maxlength="50" pattern="[0-9\(\)\-\s]+" title="Only valid phone numbers allowed." tabindex="7" />

                        
                    </fieldset>

                    <fieldset>
                      <label for="Last Name" class="visually-hidden">Last Name<span>*</span></label>
                        <input type="text" name="last" id="last" class="get-value" placeholder="*Last Name" pattern="[A-Za-z]{1,50}" title="Only letters are allowed." aria-required="true" maxlength="50" tabindex="2" />

                        <label for="Company Name" class="visually-hidden">Company Name<span>*</span></label>
                        <input type="text" name="organization" id="organization" class="get-value" placeholder="*Company Name" pattern="[a-zA-Z0-9\-\.\s]+" title="No special characters allowed." maxlength="150" tabindex="4" />

                        <label for="Country" class="visually-hidden">Country<span>*</span></label>
                        <input type="text" name="country" id="country" class="get-value" placeholder="*Country" pattern="[A-Za-z]{1,50}" title="Only letters are allowed." maxlength="50" tabindex="6" />

                    </fieldset>

                    <fieldset>
                      
                    <label for="Questions / Requests" class="visually-hidden">Questions / Requests</label>
                   <textarea name="questions" id="questions" placeholder="*Questions / Requests" rows="1" cols="1" minlength="10" maxlength="800" aria-required="true" class="get-value" tabindex="7"></textarea>

                    <!--<div id="RecaptchaField1" class="g-recaptcha" data-sitekey="<?php echo $webhelper->invCaptchaPublic; ?>" data-size="invisible" data-callback="formSubmit"></div>-->

                        <div id="request-checkboxes" class="request-checkboxes">
                          <input type="checkbox" name="newsletters" id="newsletters" value="1" tabindex="7" /><label for="Elegen newsletters">I would like to receive the latest news and updates from Elegen.</label>
                      </div>

                      <input type="submit" name="register" value="Submit" class="btn green-btn smooth-hover" id="register-btn" tabindex="7" />

                      <p>Elegen <a href="/company/privacy-policy">Privacy Policy</a></p>
                    </fieldset>

                </form>
              
            </div>

         </section>