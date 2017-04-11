<?php
require_once(assets("includes/header.php"));
?>
    <!-- Begin page content -->
    <div class="container">
      <div class="page-header">
        <h1>PHP Feed</h1>
      </div>
<?php
$rss = new DOMDocument();
$rss->load('http://news.php.net/group.php?group=php.announce&format=rss');
$feed = array();
foreach($rss->getElementsByTagName('item') as $node){
	$item = array(
		'title' => $node->getElementsByTagName('title')->item(0)->nodeValue,
		'desc' => $node->getElementsByTagName('description')->item(0)->nodeValue,
		'link' => $node->getElementsByTagName('link')->item(0)->nodeValue,
		'date' => $node->getElementsByTagName('pubDate')->item(0)->nodeValue
	);
	array_push($feed, $item);
}

$limit = 5;
for($x=0; $x<$limit; $x++){
	$title = str_replace(' & ', ' &amp; ', $feed[$x]['title']);
	$link = $feed[$x]['link'];
	$description = $feed[$x]['desc'];
	$date = date('l F d, Y', strtotime($feed[$x]['date']));
	echo '<p><strong><a href="' . $link . '" title="' . $title . '" target="_blank">' . $title . '</a></strong><br />';
	echo '<small><em>Posted on ' . $date . '</em></small></p>';
	echo '<p>' . $description . '</p>';
}
?>


</div><!--end container-->
<?php require_once(assets("includes/footer.php")); ?>