<?php
function wpf_user_support(){
    global $current_user;
    /*$from = $current_user->user_email;
    $username = $current_user->user_login;*/
    $from = $_POST['wpf_support_email'];
    $username = $_POST['wpf_support_name'];
    $license_valid = get_option('wpf_license');
    if($license_valid=='valid'){
        $license = get_option('wpf_license_key');
    }
    else{
        $license = 'No license';
    }

    $site_url = get_site_url();
    $to = 'support@wpfeedback.co';
    $subject = "WP Feedback Support - ".stripslashes(html_entity_decode($_POST['wpf_support_subject'], ENT_QUOTES, 'UTF-8'));
    $headers[] = 'Content-Type: text/html; charset=UTF-8';
    $headers[] = 'From: '.$username.' <'.$from.'>';
    $headers[] = 'Bcc: sumit.iihglobal@gmail.com';
    $headers[] = 'Bcc: himanshu@iihglobal.com';

    $body = '<table>
                <tr>
                    <td>
                        <b>Message</b>
                    </td>
                </tr>
                <tr>
                    <td style="display:block;white-space:pre-line">
                        '.stripslashes(html_entity_decode($_POST['wpf_support_message'], ENT_QUOTES, 'UTF-8')).'
                    </td>
                </tr>
                <tr>
                    <td>
                        <b>Website</b>
                    </td>
                </tr>
                <tr>
                    <td>
                        '.$site_url.'
                    </td>
                </tr>
                <tr>
                    <td>
                        <b>Username</b>
                    </td>
                </tr>
                <tr>
                    <td>
                        '.$username.'
                    </td>
                </tr>
                <tr>
                    <td>
                        <b>Email</b>
                    </td>
                    
                </tr>
                <tr>
                    <td>
                        '.$from.'
                    </td>
                </tr>
                <tr>
                    <td>
                        <b>License</b>
                    </td>
                </tr>
                <tr>
                    <td>
                        '.$license.'
                    </td>
                </tr>
                <tr>
                    <td>
                        <b>Insert Site Health Info</b>
                    </td>
                </tr>
                <tr>
                    <td>
                        <code style="display:block;white-space:pre-wrap">'.$_POST['wpf_support_site_health_info'].'</code>
                    </td>
                </tr>
            </table>';

    if(wp_mail($to, $subject, $body, $headers)){
        echo 1;
    }
    else{
        echo 0;
    }
    exit;
}
add_action('wp_ajax_wpf_user_support', 'wpf_user_support');

function wpf_register_auto_reports_cron($type){
    $wpf_site_url = site_url();
    $wpf_license = get_option('wpf_license');
    $wpf_license_key = get_option('wpf_license_key');
    $gmt_offset = get_option('gmt_offset');
    $timezone_string = get_option('timezone_string');

    $wpf_cron_register_url = 'https://wpfeedback.co/wpf_register_auto_reports_cron.php';
    $wpf_curl_data = array(
        'daily' => $type['daily'],
        'weekly' => $type['weekly'],
        'wpf_site_url' => $wpf_site_url,
        'wpf_license' => $wpf_license,
        'wpf_license_key' => $wpf_license_key,
        'gmt_offset' => $gmt_offset,
        'timezone_string' => $timezone_string
    );

    $curl = curl_init();
    curl_setopt_array($curl, array(
        CURLOPT_URL => $wpf_cron_register_url,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_SSL_VERIFYHOST => 0,
        CURLOPT_SSL_VERIFYPEER => 0,
        CURLOPT_CUSTOMREQUEST => "POST",
        CURLOPT_POSTFIELDS => $wpf_curl_data,
        CURLOPT_HTTPHEADER => array(
            "Content-type: multipart/form-data"
        ),
    ));

    $response = curl_exec($curl);
    $err = curl_error($curl);
    curl_close($curl);

    if ($err) {
        return "cURL Error #:" . $err;
    } else {
        return $response;
    }
}