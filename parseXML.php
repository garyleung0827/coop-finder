
<!DOCTYPE html>
<html>
<body>

<?php

// Include movieDAO file
require_once('./dao/coopDAO.php');

libxml_use_internal_errors(true);
ini_set('user_agent','Mozilla/4.0 (compatible; MSIE 6.0)');
$url = 'https://ca.indeed.com/rss?q=co-op&l=Ottawa%2C+ON';

$xml = file_get_contents($url);
$rss = simplexml_load_string($xml);



if ($rss === false) {
    echo "Failed loading XML: ";
    foreach(libxml_get_errors() as $error) {
        echo "<br>", $error->message;
    }
} else {
    $coopDAO = new coopDAO();
    $coops = $coopDAO->getCoops();
    foreach($coops as $coop){
        $titles[] = $coop->getTitle();
    }

    foreach($rss->channel->item as $item){
        $title = $item->title;
        $link = $item->link;
        $source = $item->source;
        $pubDate = $item->pubDate;

        if(!in_array($title,$titles)){
        $coop = new Coop(0, $title, $link, $source, $pubDate);
        $addResult = $coopDAO->addCoop($coop);
        }
    }
}
?>

</body>
</html>