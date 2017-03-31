<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$jsonUrl ="metadata.json";
$json = file_get_contents($jsonUrl);
//echo '<pre>';print_r(json_decode($json));echo '</pre>';
$data = json_decode($json, TRUE);
//vprint($data['organisationUnits']);
$orgs = $data['organisationUnits'];
$lvl5Org = array();
foreach($orgs as $org)
{
    if($org['level'] == 5)
        $lvl5Org [] = $org;
}

echo '<pre>';print_r(json_decode($json));echo '</pre>';