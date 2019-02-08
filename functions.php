<?php
    /*
    Plugin Name: Flywheel Local WP Email to HTML (For testing locally)
    Plugin URI: www.itsconsultinginc.ca
    Description: Creates a folder in the sites root Public folder called /local-mail-test/. Any emails sent from the site will be saved as HTML files in there with a timestamp. 
    Author: Martin Kaiser
    Version: 1.0
    Author URI: www.itsconsultinginc.ca
    */



function filter_local_mail( $args ) {
    // Modify the options here
    $custom_mail = array(
        'to'          => $args['to'],
        'subject'     => $args['subject'],
        'message'     => $args['message'],
        'headers'     => $args['headers'],
        'attachments' => $args['attachments'],
    );

    if (!file_exists('local-mail-test')) {
    	mkdir('local-mail-test', 0777, true);
	}
    $myfile = fopen("local-mail-test/email_".mb_ereg_replace("([^\w\s\d\-_~,;\[\]\(\).])", '', $custom_mail['subject'])."_".date('m-d-Y_h-i-s').".html", "w");
    $html = '<!doctype html>';
    $html .= '<html lang="en">';
	    $html .= '<head>';
	    $html .= '</head>';	
    	$html .= '<body>';
    		$html .= '<p><b>Subject:</b> '.$custom_mail['subject'].'</p>';	
    		$html .= '<p><b>To:</b> '.$custom_mail['to'].'</p>';
    		$html .= '<p><b>Message:</b> '.$custom_mail['message'].'</p>';
    		$html .= '<p><b>Headers:</b> '.$custom_mail['headers'].'</p>';
    	$html .= '</body>';	
    $html .= '</html>';		
    fwrite($myfile, $html);
    // Return the value to the original function to send the email
    return $custom_mail;
}
add_filter( 'wp_mail', 'filter_local_mail' );

?>