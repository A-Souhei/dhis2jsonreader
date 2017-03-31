<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

function vprint($arr)
{
    echo '<pre>';
    //print_r($arr);
    echo json_encode($arr , JSON_PRETTY_PRINT);
    echo '</pre>';    
}

function search($communefromJSON ,  $communefromCSV)
{
    $result = array();
    foreach($communefromJSON as $c)
    {
        if($c['name'] == $communefromCSV[0])
        {
            $result [] = array_merge($communefromCSV, array($c['id']));
            break;
        }
          
    }
    return $result;   
}

$jsonUrl ="metadata.json";
$json = file_get_contents($jsonUrl);
$data = json_decode($json, TRUE);
//vprint($data['organisationUnits']);
$orgs = $data['organisationUnits'];
$lvl5Org = array();
foreach($orgs as $org)
{
    if($org['level'] == 5)
        $lvl5Org [] = $org;
}

$file = fopen("metadata.csv","r");
$final = array();
//while(! feof($file))
{
    //print_r(fgetcsv($file));echo '<br/>';
    $final [] = search($lvl5Org, $file);
    
}
vprint($lvl5Org);
echo '_______________________________________________________________________';
fgetcsv($file);
vprint($file);
fclose($file);
vprint($final);
