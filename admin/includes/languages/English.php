<?php

function lang($st){
    static $lang = [
        // Nav_Bar Links
       "Home_Admin" => 'TOOTH STORE',
       "CATEGORIES" => 'Categories',
       "Dropdown"   => "More Options",
       'ITEMS'      => "items",
       'MEMBERS'    => 'members',
       'STATISTICS' => 'statistics',
       'ORDERS'       => 'Orders',
       ''=>'',
       ''=>'',
       ''=>'',
       ''=>'',
       ''=>'',
       ''=>'',
       ''=>'',
       ''=>'',
       ''=>'',
    ];
    return $lang[$st];
}
