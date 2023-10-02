<?php

// Get subdomain
function getSubdomain()
{
    $host = $_SERVER['HTTP_HOST'];
    $sub = explode('.', $host)[0]; //sub
    return $sub;
}

// Generate password
function generatePassword()
{
    $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%&*";
    $password = substr(str_shuffle( $chars ), 0, 12);
    return $password;
}

// Get protocol
function getProtocol()
{
   // $protocol = 'https://';
    $protocol = 'http://';
    return $protocol;
}

// Get domain
function getDomain()
{
    $domain = 'infotips.org';
    //$domain = 'we-management.test';
    return $domain;
}

// Adjust array key
function arrayKeyAdjust(array $array)
{
    $newArray = [];
    foreach($array as $key => $value) $newArray[intval($key)] = $value;
    return $newArray;
}

// Check page children
function haveChildren($id)
{
    $page = App\Models\Page::find($id);
    if(count($page->children) > 0) return true;
    return false;
}

// Check page parent
function haveParent($id)
{
    $page = App\Models\Page::find($id);
    if($page->parents) return true;
    return false;
}

// Get page children compared with order
function getChildren($id)
{
    $page = App\Models\Page::find($id);
    $children = $page->children->pluck('title', 'id')->toArray();
    return $children;
}


