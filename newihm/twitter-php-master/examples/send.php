<?php

require_once '../src/twitter.class.php';
$consumerKey='arMJbmafmuBgIGjfTsRCniTNL';
$consumerSecret='zt04iH81ayGeIHXmwqNza3GPpTOMv39MZkXhMHWxIWLZfIEQpG';
$accessToken='258480144-gQ49sh6ywAaMfjeEAhrdHqH8LYAJ0xhKWwPIeVjR';
$accessTokenSecret='YLnVvUZS6gHvdFSBNheONPdAqX6TVsoBJ1fAnVjux3h2H';
  
// ENTER HERE YOUR CREDENTIALS (see readme.txt)
$twitter = new Twitter($consumerKey, $consumerSecret, $accessToken, $accessTokenSecret);

try {
	$tweet = $twitter->send($_SEND); // you can add $imagePath as second argument

} catch (TwitterException $e) {
	echo 'Error: ' . $e->getMessage();
}
