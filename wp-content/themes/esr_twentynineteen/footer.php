<footer>

    <section class="container-fluid bg-primary py-6" id="newsletter">

        <div class="narrow">

            <form class="sib_signup_form" method="post">

                <div class="sib_loader" style="display:none;">
                    <i class="fas fa-spinner fa-spin"></i>
                </div>
                
                <input type="hidden" name="sib_form_action" value="subscribe_form_submit">
                <input type="hidden" name="sib_form_id" value="1">
                <input type="hidden" name="sib_form_alert_notice" value="">
                <div class="sib_signup_box_inside_1">

                    <h2 class="h3 text-center text-white mb-4">Join Our Newsletter</h2>

                    <div class="input-group">

                        <input type="email" class="form-control form-control-lg border-white rounded-0 sib-email-area" name="email" placeholder="Add your email" required="required">

                        <div class="input-group-btn">
                            <button type="submit" class="btn btn-lg btn-secondary text-primary rounded-0">
                                <span class="fas fa-plus"></span>
                            </button>
                        </div>
                    </div>

                </div>
                <!-- .sib_signup_box_inside_1 -->

            </form>

        </div>
        <!-- .narrow -->

    </section>

    <?php include('include/all-links.php');?>

<div class="container-fluid bg-white fs-md py-3" id="end">

    <ul class="link-list horizontal justify-content-center mb-2">
        <li><a class="text-body" href="/smyke" title="Smyke"><strong>Smyke</strong></a></li>
        <li><a class="text-body" href="/carbonita" title="Carbonita"><strong>Carbonita</strong></a></li>
    </ul>

    <ul class="link-list horizontal justify-content-center mb-2" id="social-media">
        <li><a href="https://www.instagram.com/esrevenge/" target="blank" title="Instagram"><img class="rounded-circle" src="<?php echo get_template_directory_uri(); ?>/images/btn-instagram.svg" alt="Instagram"></a></li>
        <li><a href="https://twitter.com/E_S_Revenge?lang=en" target="blank" title="Twitter"><img class="rounded-circle" src="<?php echo get_template_directory_uri(); ?>/images/btn-twitter.svg" alt="Twitter"></a></li>
        <li><a href="https://www.facebook.com/EndangeredSpeciesRevenge" target="blank" title="Facebook"><img class="rounded-circle" src="<?php echo get_template_directory_uri(); ?>/images/btn-facebook.svg" alt="Facebook"></a></li>
        <li><a href="https://www.youtube.com/channel/UCJWxTWqtD3w0839QsDDC8UQ" target="blank" title="Youtube"><img class="rounded-circle" src="<?php echo get_template_directory_uri(); ?>/images/btn-youtube.svg" alt="YouTube"></a></li>
        <li><a href="https://www.linkedin.com/company/endangered-species-revenge-" target="blank" title="LinkedIn"><img class="rounded-circle" src="<?php echo get_template_directory_uri(); ?>/images/btn-linkedin.svg" alt="inkedIn"></a></li>
    </ul>

    <div id="legal" class="text-center fs-medium">
        <p class="mb-0">&copy; 2018 Endangered Species Revenge</p>
        <p><a class="text-black text-underline" href="/privacy-policy">Privacy Policy</a></p>
        <p><em> <a class="text-muted no-link-style" href="https://avidanodigital.com/" target="_blank">Website by <span
                        class="text-underline">Avidano Digital</span></a></em></p>
    </div>

</div>



</footer>

<?php wp_footer(); ?>

</body>

</html>