<?php

if (!defined('ABSPATH')) {
    exit;
}

class EH_CRM_OAuth {

    protected $oauth;

    function __construct() {
        $this->oauth = array(
            'oauth_uri' => 'https://accounts.google.com/o/oauth2/auth',
            'client_id' => eh_crm_get_settingsmeta(0, "oauth_client_id"),
            'client_secret' => eh_crm_get_settingsmeta(0, "oauth_client_secret"),
            'redirect_uri' => admin_url('admin.php?page=wsdesk_email'),
            'oauth_token_uri' => 'https://accounts.google.com/o/oauth2/token',
        );
    }

    public function get_token_uri($code, $type) {
        $url = $this->oauth['oauth_token_uri'];
        $fields = array(
            'client_id' => $this->oauth['client_id'],
            'client_secret' => $this->oauth['client_secret'],
            'redirect_uri' => $this->oauth['redirect_uri'],
        );
        switch ($type) {
            case 'code':
                $fields['code'] = $code;
                $fields['grant_type'] = 'authorization_code';
                break;
            case 'refresh':
                $fields['refresh_token'] = $code;
                $fields['grant_type'] = 'refresh_token';
        }
        $args = array(
            'method' => 'POST',
            'timeout' => 45,
            'redirection' => 5,
            'httpversion' => '1.0',
            'blocking' => true,
            'headers' => array(),
            'body' => $fields,
            'cookies' => array()
        );
        $response = wp_safe_remote_post($url, $args);
        $result = $response['response'];
        if ($result['code'] == 200 && $result['message'] == 'OK') {
            $json_obj = json_decode($response['body']);
            switch ($type) {
                case 'code':
                    eh_crm_update_settingsmeta(0, "oauth_accesstoken", $json_obj->access_token);
                    eh_crm_update_settingsmeta(0, "oauth_refreshtoken", $json_obj->refresh_token);
                    eh_crm_update_settingsmeta(0, "oauth_activation", "activated");
                    eh_crm_update_settingsmeta(0, "oauth_last_requested", time());
                    break;
                case 'refresh':
                    eh_crm_update_settingsmeta(0, "oauth_accesstoken", $json_obj->access_token);
            }
            
        }
    }

    public function revoke_token()
    {
        $access_token = eh_crm_get_settingsmeta(0, "oauth_accesstoken");
        $url= "https://accounts.google.com/o/oauth2/revoke?token=".$access_token;
        wp_remote_get($url);
        eh_crm_update_settingsmeta(0, "oauth_accesstoken", "");
        eh_crm_update_settingsmeta(0, "oauth_refreshtoken", "");
        eh_crm_update_settingsmeta(0, "oauth_activation", "deactivated");
    }


    public function make_oauth_uri() {
        $uri = $this->oauth['oauth_uri'];
        $uri .= "?client_id=" . $this->oauth['client_id'];
        $uri .= "&redirect_uri=" . $this->oauth['redirect_uri'];
        $uri .= "&scope=https://mail.google.com/+https://www.googleapis.com/auth/gmail.readonly";
        $uri .= "&response_type=code";
        $uri .= "&access_type=offline";
        $uri .= "&approval_prompt=force";
        return $uri;
    }

    public function refresh_accesstoken() {
        $access_token = eh_crm_get_settingsmeta(0, "oauth_accesstoken");
        $url= "https://www.googleapis.com/oauth2/v1/tokeninfo/?access_token=".$access_token;
        $result = wp_remote_get($url);
        if(!is_wp_error($result))
        {
            $response = $result['response'];
            $body = json_decode($result['body']);
            if ($response['code'] == 400 && $body->error == 'invalid_token') {
                $this->get_token_uri(eh_crm_get_settingsmeta(0, "oauth_refreshtoken"), "refresh");
            }
        }
        return true;
    }

}
