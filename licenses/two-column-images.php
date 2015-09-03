<?php

// This is the URL our updater / license checker pings. This should be the URL of the site with EDD installed
if( ! defined( 'CT_TRACKS_STORE_URL' ) ) {
    define( 'CT_TRACKS_STORE_URL', 'https://www.competethemes.com' );
}

// The name of your product. This should match the download name in EDD exactly
define( 'CT_TRACKS_TWO_COLUMN_IMAGES', 'Tracks Two-Column Images Layout' );


/**
 * Full-width layout licensing
 */

/***********************************************
 * Gets rid of the local license status option
 * when adding a new one
 ***********************************************/

function ct_tracks_two_column_images_sanitize_license( $new ) {
    $old = get_option( 'ct_tracks_two_column_images_license_key' );
    if( $old && $old != $new ) {
        delete_option( 'ct_tracks_two_column_images_license_key_status' ); // new license has been entered, so must reactivate
    }
    return $new;
}

/***********************************************
 * Illustrates how to activate a license key.
 ***********************************************/

function ct_tracks_two_column_images_activate_license() {

    if( isset( $_POST['ct_tracks_two_column_images_license_activate'] ) ) {
        if( ! check_admin_referer( 'ct_tracks_two_column_images_nonce', 'ct_tracks_two_column_images_nonce' ) )
            return; // get out if we didn't click the Activate button

        $license = trim( get_option( 'ct_tracks_two_column_images_license_key' ) );

        $api_params = array(
            'edd_action' => 'activate_license',
            'license' => $license,
            'item_name' => urlencode( CT_TRACKS_TWO_COLUMN_IMAGES )
        );

        $response = wp_remote_get( add_query_arg( $api_params, CT_TRACKS_STORE_URL ), array( 'timeout' => 15, 'body' => $api_params, 'sslverify' => false ) );

        if ( is_wp_error( $response ) ) {

            $response = wp_remote_post( add_query_arg( $api_params, CT_TRACKS_STORE_URL ), array( 'timeout' => 15, 'body' => $api_params, 'sslverify' => false ) );

            if ( is_wp_error( $response ) ) {
                return false;
            }
        }

        $license_data = json_decode( wp_remote_retrieve_body( $response ) );

        // $license_data->license will be either "active" or "inactive"

        update_option( 'ct_tracks_two_column_images_license_key_status', $license_data->license );

    }
}
add_action('admin_init', 'ct_tracks_two_column_images_activate_license');

/***********************************************
 * Illustrates how to deactivate a license key.
 * This will descrease the site count
 ***********************************************/

function ct_tracks_two_column_images_deactivate_license() {

    // listen for our activate button to be clicked
    if( isset( $_POST['ct_tracks_two_column_images_license_deactivate'] ) ) {

        // run a quick security check
        if( ! check_admin_referer( 'ct_tracks_two_column_images_nonce', 'ct_tracks_two_column_images_nonce' ) )
            return; // get out if we didn't click the Activate button

        // retrieve the license from the database
        $license = trim( get_option( 'ct_tracks_two_column_images_license_key' ) );

        // data to send in our API request
        $api_params = array(
            'edd_action'=> 'deactivate_license',
            'license' 	=> $license,
            'item_name' => urlencode( CT_TRACKS_TWO_COLUMN_IMAGES ),
            'url'       => home_url()
        );

        // Call the custom API.
        $response = wp_remote_get( add_query_arg( $api_params, CT_TRACKS_STORE_URL ), array( 'timeout' => 15, 'sslverify' => false ) );

        // make sure the response came back okay
        if ( is_wp_error( $response ) )
            return false;

        // decode the license data
        $license_data = json_decode( wp_remote_retrieve_body( $response ) );

        // $license_data->license will be either "deactivated" or "failed"
        if( $license_data->license == 'deactivated' )
            delete_option( 'ct_tracks_two_column_images_license_key_status' );

    }
}
add_action('admin_init', 'ct_tracks_two_column_images_deactivate_license');



/***********************************************
 * Illustrates how to check if a license is valid
 ***********************************************/

function ct_tracks_two_column_images_check_license() {

    global $wp_version;

    $license = trim( get_option( 'ct_tracks_two_column_images_license_key' ) );

    $api_params = array(
        'edd_action' => 'check_license',
        'license' => $license,
        'item_name' => urlencode( CT_TRACKS_TWO_COLUMN_IMAGES ),
        'url'       => home_url()
    );

    $response = wp_remote_get( add_query_arg( $api_params, CT_TRACKS_STORE_URL ), array( 'timeout' => 15, 'sslverify' => false ) );

    if ( is_wp_error( $response ) )
        return false;

    $license_data = json_decode( wp_remote_retrieve_body( $response ) );

    if( $license_data->license == 'valid' ) {
        return 'valid';
        // this license is still valid
    } else {
        return 'invalid';
        // this license is no longer valid
    }
}