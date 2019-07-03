<?php
if (!defined('ABSPATH')) {
    exit;
}
class EH_CRM_Export
{ 
    function export_data($fileName,$assocDataArray)
    {
        ob_clean();
        $user = getenv("username");
        $user = $user."\Downloads";
        $path = "\Users\ ".$user;
        $path = str_replace(' ', '', $path);
        $browser= php_uname();
        if(stripos(PHP_OS, "Darwin") === 0)
        {
            $user = $user."/Downloads";
            $path = "/Users/".$user;
        }
        elseif(stripos(PHP_OS, "Linux") === 0)
        {
            $user = $user."/Downloads";
            $path = "/home/".$user;
        }
        $fields_custom = array();
        $fileName = time().".".$fileName;
        $file_name = $path . '/' . $fileName;
        header('Content-Type: text/csv');
        header('Content-Disposition: attachment;filename=' . $fileName);
        if(isset($assocDataArray['0']))
        {
            ob_end_clean();
            $fp = fopen($file_name, 'w');
            $fields_present = array('Ticket Id','Requester Email','Subject','Ticket Content','Status','Ticket Created','Ticket Updated','Satisfaction Rating');
            $avail_fields = eh_crm_get_settings(array("type" => "field"), array("slug", "title"));
            $selected_fields = eh_crm_get_settingsmeta(0, 'selected_fields');
            for($j=3;$j<count($selected_fields);$j++)
            {
                for($i=3;$i<count($avail_fields);$i++)
                {
                    if($selected_fields[$j]==$avail_fields[$i]['slug'])
                    {
                        array_push($fields_custom,$avail_fields[$i]['title']);
                    }
                }
            }
            if(count($fields_custom))
            {
                $fields_present = array_merge($fields_present,$fields_custom);
                $fields_present = array($fields_present);
            }
            else
            {
                $fields_present = array($fields_present);
            }
            foreach($fields_present as $fields)
            {
                fputcsv($fp,$fields);
            }
            foreach($assocDataArray as $values)
            {
                fputcsv($fp,$values);
            }
            fclose($fp);
            exit();
        }
    }
}