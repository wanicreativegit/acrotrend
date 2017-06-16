<div class="get-in-touch">
    <div class="row">
        <div class="col-md-8 orange-bg subscribe" data-match-height="getintouch">
            <div class="wrapper">
                <h2>Subscribe to Our Newsletter</h2>
                <hr/>
                <?php echo do_shortcode('[mc4wp_form id="946"]'); ?>
            </div>
        </div>
        <div class="col-md-4 blue-bg" data-match-height="getintouch">

                <div class="contacts">

                    <?php
                    foreach (get_contacts() as $name => $soc) {

                        $href = '';
                        if($name == 'phone'){
                            $href = 'tel:'.$soc;
                        }
                        if($name == 'email'){
                            $href = 'mailto:'.$soc;
                        }
                        if($name == 'address'){
                            $href = 'http://maps.google.com/?q='.$soc;
                            $target = 'target="_blank"';
                        }

                        echo '<div class="row">';
                        echo '<div class="col-md-3 col-xs-3 ' . $name . '"></div>';
                        echo '<div class="col-md-9 col-xs-9 text "><a href="'.$href.'" '.$target.'>' . $soc . '</a></div>';
                        echo '</div>';

                    }
                    ?>

                </div>
        </div>
    </div>
    <div class="bg-img"></div>
</div>


<footer>
    <div class="wrapper">
        <div class="row">
            <div class="col-md-4">
                <div class="logo magic-click" data-url="<?php echo get_home_url(); ?>" >
                </div>
            </div>
            <div class="col-md-4 menu-bg">
                <?php
                wp_nav_menu(array('menu' => 'footer-menu'));
                ?>
            </div>
            <div class="col-md-4">
                <div class="socials">
                    <?php
                    foreach (get_socials() as $name => $soc) {
                        echo '<div data-url="' . $soc . '" data-type="_blank" class="magic-click ' . $name . '"></div>';
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
</footer>

<?php wp_footer(); ?>

<script>
    (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
        (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
        m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
    })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

    ga('create', 'UA-48176820-1', 'auto');
    ga('send', 'pageview');

</script>

<?php include_once('social-codes.php'); ?>

</body>
</html>
