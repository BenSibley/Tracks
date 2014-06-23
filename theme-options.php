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
    <h2 class="nav-tab-wrapper">
        <a href="#" class="nav-tab">General</a>
        <a href="#" class="nav-tab">Support</a>
        <a href="#" class="nav-tab">Premium Layouts</a>
        <a href="#" class="nav-tab">Licenses</a>
    </h2>
    <p>Thanks for downloading Tracks!</p>
    <hr />
    <div>
        <h3>Customize Tracks</h3>
        <p>Add your logo, social media icons, and more with the customizer.</p>
        <p><a class="button-primary" href="customize.php">Use the customizer</a></p>
    </div>
    <div class="support">
        <h3>Support</h3>

        <ol>
            <li><a target="_blank" href="http://www.competethemes.com/documentation/tracks-knowledgebase/?utm_source=WordPress%20Dashboard&utm_medium=User%20Admin&utm_content=Tracks&utm_campaign=Admin%20Support">Visit the knowledgebase</a> for self-help.</li>
            <li><a target="_blank" href="http://wordpress.org/support/theme/tracks">Visit the support forum</a> for community support.</li>
        </ol>
        <p>I (Ben) visit the support forum everyday, so any questions you have will be answered there.</p>
    </div>
</div>
<?php }
