<?php
if ( ! defined( 'ABSPATH' ) ) {
  exit; // Exit if accessed directly
}

$recipients=array();

if(isset($mailer->notification['recipients']))
  $recipients=$mailer->notification['recipients'];

$ticket=$mailer->ticket;

global $wpdb;
//get ticket creator companies
$sql="select * from {$wpdb->prefix}wpsp_company_users where userid='".$ticket->created_by."'";
$companies=$wpdb->get_results($sql);
$users=array();

foreach ($companies as $key => $value) {
  //get company users
  $sql="select * from {$wpdb->prefix}wpsp_company_users where cid='".$value->cid."'";
  $company=$wpdb->get_results($sql);

  foreach ($company as $comp) {

    if(in_array('compsupervisor', $recipients) && $comp->supervisor){

      $user=get_user_by('id', $comp->userid);
      $users[]=$user->user_email;

    }else if(in_array('compmembers', $recipients)){

      $user=get_user_by('id', $comp->userid);
      $users[]=$user->user_email;
    }

  }
}

$emails=array_unique(array_merge($emails,$users));
