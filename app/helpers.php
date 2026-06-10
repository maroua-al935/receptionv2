<?php

function to_normal_date($olddate)
{
    if ($olddate == null) {
        return "N/d";
    }else{

    }
    $timestamp=strtotime($olddate);
    return date("d/m/Y à H:i",$timestamp);
}

?>