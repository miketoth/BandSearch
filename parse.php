<?php
error_reporting(E_ALL);
ini_set('display_errors',1);

require_once("artist.php");
require_once("band.php");

// echoes a list of names from bands and artists
function display($list){
    if(empty($list)){
        return;
    }
    foreach($list as $li){
        echo $li->getName();
        echo "<br />";
    }
    echo "----------------------------------------";
    echo "<br />";
}

// turn a list of names into an array of artist objects
function makeArtists($list){
    $artistList = array();
    foreach($list as $li){
        $a= new Artist($li);
        $artistList[] = $a;
    }
    return $artistList;
}

// turn a list of names into ann array of band objects
function makeBands($list){
    $bandList = array();
    foreach($list as $li){
            $b = new Band($li);
            $bandList[] = $b;
    }
    return $bandList;
}

function doCURL($wikiURL){
    $ch = curl_init($wikiURL);

    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

    $result = curl_exec($ch);
    curl_close($ch);
    return $result;

}

function getRowList($identifier, $dom){
    $rows = $dom->getElementsByTagName('tr');
    $artistList = array();

    // getting all of the artists I need to make sure dups aren't put in.
    foreach($rows as $row){
        if(strstr($row->nodeValue, $identifier )){
            $artist = substr($row->nodeValue,strlen($identifier), strlen($row->nodeValue));
            $artistList = explode(",", $artist);
        }
    }

    // bad fix for cases without list of associated acts (false positives)
    // Needs a better solution
    if(sizeof($artistList) >1){
        return $artistList;
    }

    $failList = array("failed");
    return $failList;
}

$wikiURL = "http://en.wikipedia.org/wiki/";
$rootArtist = $_POST['artist'];

if(isset($_POST['artist'])){
    // prep for wikipedia
    // capitalize first and last name --> LATER
    $newWikiURL = $wikiURL . str_replace(" ", "_", $_POST['artist']);
}
$dom = new DOMDocument();

$result = doCURL($newWikiURL);
$dom->loadHTML($result);
$artistList = makeArtists(getRowList("Associated acts", $dom));

// now on to bands
for($i=0;$i<sizeof($artistList);$i++){
    $result = doCURL($wikiURL . str_replace(" ", "_", trim($artistList[$i]->getName())));
    $dom->loadHTML($result);

    // for each artist add associated bands
    $artistList[$i]->setBands(makeBands(getRowList("Associated acts",$dom)));
}

// foreach artist foreach band that artist is in: grab all of the members
// MEH I'll just do that later

// create JSON objects
$rootArtistList = array('name' => $rootArtist,
                        'tree' => "root",
                    );
$jsonList[] = $rootArtistList;
$artistBandList =""; // saving a lot of ugly error messages
foreach($artistList as $artist){
    foreach($artist->getBands() as $artistBand){
        // band name is not 'failed' place holder or already in the string put
        // it into the string
        if($artistBand->getName() != "failed" && strpos($artistBandList, $artistBand->getName()) === false){
            if(empty($artistBandList))
                $artistBandList = trim($artistBand->getName());
            else
                $artistBandList = trim($artistBand->getName()) . ", ". $artistBandList;
        }
    }
    if(!empty($artistBandList)){
    $jsonList[] = array('name'=> trim($artist->getName()),
                        'bands' => $artistBandList,
                        'tree' => "Branch level 1",
                    );
    }
    else{
        // do nothing
    }
}
echo json_encode($jsonList);

?>
