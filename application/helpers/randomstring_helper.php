<?php

/**
*randomPassword function
* @return random password
* @author tushar.patil
**/
if ( ! function_exists('randomstring'))
{
function randomstring() {
    
    $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
    return substr(str_shuffle($chars),0,6);
}
}
?>