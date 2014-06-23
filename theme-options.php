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
        <div class="general-content">
            <p>Thanks for downloading Tracks!</p>
            <h3>Quick-start Guide</h3>
            <p>Here are a few steps to make your site pixel-perfect with Tracks:</p>
            <ul>
                <li>Visit the menus page to setup your menus (<a href="customize.php">visit now</a>)</li>
                <li>Visit the theme customizer to add your logo, social icons, and more (<a href="customize.php">visit now</a>)</li>
                <li>Visit the widgets page to add widgets after your posts and/or pages (<a href="customize.php">visit now</a>)</li>
                <li>Review Tracks on wordpress.org (<a href="customize.php">review now</a>)</li>
            </ul>
            <p>If you want more help getting your site setup, we have <a target="_blank" href="http://www.competethemes.com/documentation/tracks-knowledgebase/">detailed tutorials</a> in our knowledgebase.</p>

        </div>
    <?php }
    elseif($active_tab == 'support'){ ?>
        <div class="support">
        <h3>Support</h3>
        <ol>
            <li><a target="_blank" href="http://www.competethemes.com/documentation/tracks-knowledgebase/?utm_source=WordPress%20Dashboard&utm_medium=User%20Admin&utm_content=Tracks&utm_campaign=Admin%20Support">Visit the knowledgebase</a> for self-help.</li>
            <li><a target="_blank" href="http://wordpress.org/support/theme/tracks">Visit the support forum</a> for community support.</li>
        </ol>
        <p>I (Ben) visit the support forum everyday, so any questions you have will be answered there.</p>
    </div>
    <?php } ?>


</div>
<?php }
