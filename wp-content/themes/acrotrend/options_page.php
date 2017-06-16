<?php

function theme_settings_page(){

    ?>
    <div class="wrap">
        <h1>Acrotrend settings</h1>
        <p>Solution by Wanicreative(Deividas Ambrazevicius)</p>
        <form method="post" action="options.php">
            <?php
            settings_fields("section");
            do_settings_sections("theme-options");
            submit_button();
            ?>
        </form>
    </div>
<?php
}

function add_theme_menu_item()
{
    add_menu_page("Acrotrend settings", "Acrotrend settings", "manage_options", "theme-panel", "theme_settings_page", null, 99);
}

add_action("admin_menu", "add_theme_menu_item");


function display_twitter_element()
{
    ?>
    <input type="text" name="twitter_url" id="twitter_url" value="<?php echo get_option('twitter_url'); ?>" />
<?php
}

function display_indian_email_element()
{
    ?>
    <input type="text" name="indian_email" id="indian_email" value="<?php echo get_option('indian_email'); ?>" />
<?php
}
function display_uk_email_element()
{
    ?>
    <input type="text" name="uk_email" id="uk_email" value="<?php echo get_option('uk_email'); ?>" />
<?php
}

function logo_display()
{
    ?>
    <input type="file" name="logo" />
    <?php echo get_option('logo'); ?>
<?php
}

function display_facebook_element()
{
    ?>
    <input type="text" name="facebook_url" id="facebook_url" value="<?php echo get_option('facebook_url'); ?>" />
<?php
}

function display_linkedin_element()
{
    ?>
    <input type="text" name="linkedin_url" id="linkedin_url" value="<?php echo get_option('linkedin_url'); ?>" />
<?php
}

function display_youtube_element()
{
    ?>
    <input type="text" name="youtube_url" id="youtube_url" value="<?php echo get_option('youtube_url'); ?>" />
<?php
}

function display_phone_element()
{
    ?>
    <input type="text" name="phone_url" id="phone_url" value="<?php echo get_option('phone_url'); ?>" />
<?php
}

function display_email_element()
{
    ?>
    <input type="text" name="email_url" id="email_url" value="<?php echo get_option('email_url'); ?>" />
<?php
}

function display_address_element()
{
    ?>
    <input type="text" name="address_url" id="address_url" value="<?php echo get_option('address_url'); ?>" />
<?php
}





function display_theme_panel_fields()
{
    add_settings_section("section", "All Settings", null, "theme-options");

    add_settings_field("twitter_url", "Twitter Profile Url", "display_twitter_element", "theme-options", "section");
    add_settings_field("facebook_url", "Facebook Profile Url", "display_facebook_element", "theme-options", "section");
    add_settings_field("linkedin_url", "Linkedin Profile Url", "display_linkedin_element", "theme-options", "section");
    add_settings_field("youtube_url", "Youtube Profile Url", "display_youtube_element", "theme-options", "section");

    add_settings_field("indian_email", "Indian recruitment team email:", "display_indian_email_element", "theme-options", "section");
    add_settings_field("uk_email", "UK recruitment team email:", "display_uk_email_element", "theme-options", "section");


    add_settings_field("phone_url", "Phone number", "display_phone_element", "theme-options", "section");
    add_settings_field("email_url", "Email address", "display_email_element", "theme-options", "section");
    add_settings_field("address_url", "Ofice address", "display_address_element", "theme-options", "section");


    register_setting("section", "twitter_url");
    register_setting("section", "facebook_url");
    register_setting("section", "linkedin_url");
    register_setting("section", "youtube_url");

    register_setting("section", "indian_email");
    register_setting("section", "uk_email");

    register_setting("section", "phone_url");
    register_setting("section", "email_url");
    register_setting("section", "address_url");


}

add_action("admin_init", "display_theme_panel_fields");