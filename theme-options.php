<?php

/* create theme options page */
function ct_tracks_register_theme_page(){
add_theme_page( 'Theme Options', 'Theme Options', 'edit_theme_options', 'tracks-options', 'ct_tracks_options_content');
}
add_action( 'admin_menu', 'ct_tracks_register_theme_page' );

/* callback used to add content to options page */
function ct_tracks_options_content(){ ?>

<div id="tracks-dashboard-wrap" class="wrap">

    <h2>Tracks Dashboard</h2>

    <?php $active_tab = isset( $_GET[ 'tab' ] ) ? $_GET[ 'tab' ] : 'general'; ?>

    <h2 class="nav-tab-wrapper">
        <a href="?page=tracks-options&tab=general" class="nav-tab <?php echo $active_tab == 'general' ? 'nav-tab-active' : ''; ?>">General</a>
        <a href="?page=tracks-options&tab=support" class="nav-tab <?php echo $active_tab == 'support' ? 'nav-tab-active' : ''; ?>">Support</a>
        <a href="?page=tracks-options&tab=premium-layouts" class="nav-tab <?php echo $active_tab == 'premium-layouts' ? 'nav-tab-active' : ''; ?>">Premium Layouts</a>
        <a href="?page=tracks-options&tab=licenses" class="nav-tab <?php echo $active_tab == 'licenses' ? 'nav-tab-active' : ''; ?>">Licenses</a>
    </h2>
    <?php
    if($active_tab == 'general'){ ?>
        <div class="content-general content">
            <p>Thanks for downloading Tracks!</p>
            <h3>Quick-start Guide</h3>
            <p>Here are a few steps to make your site pixel-perfect with Tracks:</p>
            <ul>
                <li>Setup your menus (<a href="nav-menus.php">visit Menus page</a>)</li>
                <li>Add your logo and social icons (<a href="customize.php">visit Theme Customizer</a>)</li>
                <li>Add widgets after your posts and/or pages (<a href="widgets.php">visit Widgets page</a>)</li>
                <li>Review Tracks on wordpress.org (<a href="http://wordpress.org/support/view/theme-reviews/tracks">review now</a>)</li>
            </ul>
            <p>If you want more help getting your site setup, we have <a target="_blank" href="http://www.competethemes.com/documentation/tracks-knowledgebase/">detailed tutorials</a> in our knowledgebase.</p>
        </div>
    <?php }
    elseif($active_tab == 'support'){ ?>
        <div class="content-support content">
            <p>There are a few ways to get support for Tracks: </p>
            <ul>
                <li>Find an answer on the knowledgebase (<a target="_blank" href="http://www.competethemes.com/documentation/tracks-knowledgebase">visit the Tracks Knowledgebase</a>)</li>
                <li>Ask a question on the support forum (<a target="_blank" href="http://wordpress.org/support/theme/tracks">visit support forum</a>)</li>
            </ul>
        </div>
    <?php }
    elseif($active_tab == 'premium-layouts'){ ?>
        <div class="content-premium-layouts content">
            <p>premium layouts</p>
        </div>
    <?php }
    else { ?>
        <div class="content-licenses content">
            <p>You can assign your new layouts in the Theme Customizer in the "Premium Layouts" section after activating your license(s).</p>
        </div>
    <?php } ?>
</div>
<?php }
