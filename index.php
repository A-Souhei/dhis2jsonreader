<?php
error_reporting(0);
?>
<h3>Donnees en entrees</h3>
<h4>
metadata.json (import json) <br/>
metadata.csv (csv)
</h4>
<form action="index.php" method="post">
    <input type="file" name="json"/>Telecharger JSON<br/>
    <input type="file" name="csv"/>Telecharger CSV<br/>
    <button type="submit" name="launch">Lancer</button>
</form>

<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
if(!isset($_POST['launch']))
    die();
function vprint($arr)
{
    echo '<pre>';
    //print_r($arr);
    print_r($arr);
    echo '</pre>';    
}

function search($communefromJSON ,  $communefromCSV)
{
    $result = array();
    foreach($communefromJSON as $c)
    {
        if(trim($c['name']) == trim($communefromCSV[0]))
        {
            $result  = array($c['id']);
            break;
        }
          
    }
    return $result;   
}

$jsonUrl =$_POST['json'];
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

$fileurl = $_POST['csv'];
$file = fopen($fileurl ,"r");
$final = array();
$passfail = array();
while(! feof($file))
{
    $_fl = fgetcsv($file);
    $t = search($lvl5Org, $_fl);
    if($t == NULL)    
        $final [] = implode(';',$_fl);
    else
        $final [] = implode(';',array_merge($_fl,$t));
    
    //else
        //$passfail[] = implode(';',$_fl);
        
}
fclose($file);


//vprint($passfail);


$file = fopen("modifiee.csv","w");

foreach ($final as $line)
{
    fputcsv($file,explode(';',$line));
}

fclose($file);
echo '<a href="modifiee.csv">Telecharger le resultat</a>';
vprint($final);
echo '<hr/>';