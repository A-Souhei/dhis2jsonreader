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
    print_r($arr);
    echo '</pre>';    
}

function search($communefromJSON ,  $communefromCSV)
{
    $result = '';
    foreach($communefromJSON as $c)
    {
        if($c['name'] == $communefromCSV[0])
        {
            $result  = implode(';',array_merge($communefromCSV, array($c['id'])));
            break;
        }
          
    }
    return $result;   
}

$jsonUrl ="metadata.json";
$json = file_get_contents($jsonUrl);
echo '<pre>';print_r(json_decode($json));echo '</pre>';
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
$passfail = array();
while(! feof($file))
{
    $_fl = fgetcsv($file);
    $t = search($lvl5Org, $_fl);
    if($t != NULL)
    {
        $final [] = $t;
        //vprint($t);
    }
    else
        $passfail[] = implode(';',$_fl);
        
}
fclose($file);

vprint($final);
echo '<hr/>';
vprint($passfail);

