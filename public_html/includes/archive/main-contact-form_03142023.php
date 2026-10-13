<section id="main-contact-form" class="wide-section ask-dna-form no-margin">
 
            <div class="page-inner">

              <form method="post" name="askDnaFrm" id="home-form">

                    <h2>Ask about our DNA</h2>

                    <?php
                        if(isset($error)) {
                           echo '<ul id="error-box">';
                           foreach($error as $item) {
                              echo "<li>$item</li>";
                           }
                           echo '</ul>';
                    } ?>

                    <h4>* Required</h4>

                     <fieldset id="field-one">
                        <label for="First Name" class="visually-hidden">First Name<span>*</span></label>
                        <input type="text" name="first" id="first" class="get-value" placeholder="*First Name" maxlength="50"
                            <?php if(isset($missing)) {
                              echo 'value="'.htmlentities($_POST['first']).'"';
                             } ?> tabindex="1" />

                        <label for="Email Address" class="visually-hidden">Email Address<span>*</span></label>
                        <input type="email" name="email" class="get-value" id="email" placeholder="*Email Address" maxlength="100"
                            <?php if(isset($missing)) {
                              echo 'value="'.htmlentities($_POST['email']).'"';
                             } ?> tabindex="3" />
  
                        <label for="Zip Code" class="visually-hidden">Zip Code<span>*</span></label>
                        <input type="text" name="zip" id="zip" class="get-value" placeholder="*Zip Code" maxlength="50"
                            <?php if(isset($missing)) {
                              echo 'value="'.htmlentities($_POST['zip']).'"';
                             } ?> tabindex="5" />

                        
                    </fieldset>

                    <fieldset>
          <label for="Last Name" class="visually-hidden">Last Name<span>*</span></label>
            <input type="text" name="last" id="last" class="get-value" placeholder="*Last Name" maxlength="50"
                <?php if(isset($missing)) {
                  echo 'value="'.htmlentities($_POST['last']).'"';
                 } ?> tabindex="2" />

            <label for="Company Name" class="visually-hidden">Company Name<span>*</span></label>
            <input type="text" name="organization" id="organization" class="get-value" placeholder="*Company Name" maxlength="150"
                  <?php if(isset($missing)) {
                  echo 'value="'.htmlentities($_POST['organization']).'"';
                 } ?> tabindex="2" />

            <label for="Country" class="visually-hidden">Country<span>*</span></label>
            <input type="text" name="country" id="country" class="get-value" placeholder="*Country" maxlength="50"
                <?php if(isset($missing)) {
                  echo 'value="'.htmlentities($_POST['country']).'"';
                 } ?> tabindex="5" />

                    </fieldset>

                    <fieldset>
                      
                    <label for="Questions / Requests" class="visually-hidden">Questions / Requests</label>
                   <textarea name="questions" id="questions" placeholder="*Questions / Requests" rows="1" cols="1" minlength="10" maxlength="800" aria-required="true" class="get-value" tabindex="6"><?php if(isset($missing)){
                    echo htmlentities($_POST['questions']);
                    }?></textarea>

                    <div id="RecaptchaField1" class="g-recaptcha" data-sitekey="<?php echo $webhelper->invCaptchaPublic; ?>" data-size="invisible" data-callback="formSubmit"></div>

                        <div id="request-checkboxes" class="request-checkboxes">
                          <input type="checkbox" name="newsletters" id="newsletters" value="1" tabindex="7" /><label for="Elegen newsletters">I would like to receive the latest news and updates from Elegen.</label>
                      </div>

                      <input type="submit" name="register" value="Submit" class="btn green-btn smooth-hover" id="register-btn" tabindex="7" />

                      <p>Elegen <a href="/company/privacy-policy">Privacy Policy</a></p>
                    </fieldset>

                </form>
              
            </div>

         </section>