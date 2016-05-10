<?php
include ("config.php");
include ("connect_db.php");
include("librairies/manage.php");
$message=0;
### WHO IS DOING GREAT.
$SQL7="SELECT id,instrument, strategy,profit,count,drawdown,tbx_score from ranking_week where tbx_score>5 and strategy<>'' order by RAND()";
$QQ=mysql_query($SQL7);echo mysql_error();
$message="";
list ($ID2,$instrument2,$strategy2,$profit2,$count2,$dd2,$tbx_score2)=mysql_fetch_array($QQ);
if ($strategy2!="")
{
$message.="<b><a href='http://www.thirdbrainfx.com/search/node/".$strategy2."'>".ucfirst($strategy2)."</a></b> ".msg_random("is doing great",$_MSG_MATRIX). " with ".$count2. " trades made for a total of ".$profit2." pips gained on <b><a href='http://www.thirdbrainfx.com/search/node/".$instrument2."'>".$instrument2."</a></b> ".msg_random("during the last 24 hours",$_MSG_MATRIX).".<br>";
}


$SQL7="SELECT id,instrument, strategy,profit,count,drawdown,tbx_score from ranking_month where tbx_score>5 and strategy<>'' and instrument!='".$instrument2."' order by RAND()";
$QQ=mysql_query($SQL7);echo mysql_error();
list ($ID2,$instrument2,$strategy2,$profit2,$count2,$dd2,$tbx_score2)=mysql_fetch_array($QQ);
if ($dd2==0) {$add1=" a 100% winning trade";} else {$add1=" a Risk and Return around ".abs(number_format(($profit2/$dd2),2));}

if (trim($strategy2)!="")
{
$message.="For this month, <b><a href='http://www.thirdbrainfx.com/search/node/".$strategy2."'>".$strategy2."</a></b> ".msg_random("is doing great",$_MSG_MATRIX). " with ".$count2. " trades made for a total of ".$profit2." pips gained on <b><a href='http://www.thirdbrainfx.com/search/node/".$instrument2."'>".$instrument2."</a></b> for a drawdown around ".$dd2. " pips then  ".$add1.".<br>";
}

$message=str_replace("with with","with",$message);

$SQL7="SELECT id,instrument, strategy,profit,count,drawdown,tbx_score from ranking where tbx_score>7 and strategy!='".$strategy2."' order by RAND()";
$QQ=mysql_query($SQL7);echo mysql_error();
list ($ID2,$instrument2,$strategy2,$profit2,$count2,$dd2,$tbx_score2)=mysql_fetch_array($QQ);
if ($dd2==0) {$add1=" a 100% winning trade !";} else {$add1=" a Risk and Return around ".abs(number_format(($profit2/$dd2),2)).".The RaR (risk and return) say that you can win ".abs(number_format(($profit2/$dd2),2)). " time more than you risk to loose using this strategy.";}

$message.="Since inception, <b><a href='http://www.thirdbrainfx.com/search/node/".$strategy2."'>".Ucfirst($strategy2)."</a></b> ".msg_random("is doing great",$_MSG_MATRIX). " with ".$count2. " trades made for a total of ".$profit2." pips gained on <b><a href='http://www.thirdbrainfx.com/search/node/".$instrument2. "'>".$instrument2."</a></b> for a drawdown around ".$dd2. " pips then  ".$add1.".";

$message.="<br>You can monitor our <a href='http://www.thirdbrainfx.com'>free forex live signals</a> here.<br>This <a href='http://signal.thirdbrainfx.com' alt='free forex signal' title='free forex signal'> free forex signal</a> can be synchronized with a trading account created with us under <b> xstation </b> or with <a href='https://www.thirdbrainfx.com/step2-mirrortrader-premium-registration.php'>FXCM or FXDD's account *</a>. To link our signal to FXDD or FXCM is 79 USD by month<br>Check our <a href='http://www.thirdbrainfx.com/products'> Forex services to trade better</a>";

$message.="<br> <b> Traders </b> who are using our <b>automated forex strategies</b> have 6 times more chances to win than traders who trade alone using classic broker's advices. You can check our <a href='http://www.thirdbrainfx.com/performances-statistics-about-our-client-thirdbrainfx-premium-zone/895248639'>live forex account statistics</a> with the client we already have.";

$message=addslashes(str_replace("with with","with",$message));
$t1=explode("pips",$message);
$title=$t1[0]." pips";
$title=strip_tags($title);
echo $message;

include("end_db.php");
$time=time();
include ("connect_db_drupal.php");

$body=$message;

$SQL="insert into node_revision values('','','1','','','".$time."','1','','','' )";
$r=mysql_query($SQL,$mysql);
echo mysql_error();
$id_nx=mysql_insert_id();



$SQL="insert into node values ('','".$id_nx."','blog','und','".$title."','1','1','".$time."','".$time."','0','1','0','0','0')";
echo "<li>".$SQL;
$r=mysql_query($SQL,$mysql);
echo mysql_error();
$id_nn=mysql_insert_id();

echo "<li>".$id_nn;
$SQL="insert into field_data_body values ('node','blog','0','".$id_nn."','".$id_nx."','und','0','".$body."','','full_html')";
echo"<li>".$SQL;
$r=mysql_query($SQL,$mysql);
echo mysql_error();
$id_n=mysql_insert_id();

$SQL="insert into node_access values ('".$id_nn."','0','all','1','0','0')";
echo"<li>".$SQL;
$r=mysql_query($SQL,$mysql);
echo mysql_error();
$SQL="update node_revision set nid='".$id_nn."', title='".$title."' where vid='".$id_nx."'";
echo "<li>".$SQL;
mysql_query($SQL);
echo mysql_error();

$SQL="truncate cache";
mysql_query($SQL);

include("end_db.php");


// RSSS
/*
<
<?xml version="1.0" encoding="utf-8" ?><rss version="2.0" xml:base="http://www.thirdbrainfx.com/education-home" xmlns:dc="http://purl.org/dc/elements/1.1/" xmlns:fb="http://www.facebook.com/2008/fbml" xmlns:content="http://purl.org/rss/1.0/modules/content/" xmlns:foaf="http://xmlns.com/foaf/0.1/" xmlns:og="http://ogp.me/ns#" xmlns:rdfs="http://www.w3.org/2000/01/rdf-schema#" xmlns:sioc="http://rdfs.org/sioc/ns#" xmlns:sioct="http://rdfs.org/sioc/types#" xmlns:skos="http://www.w3.org/2004/02/skos/core#" xmlns:xsd="http://www.w3.org/2001/XMLSchema#">
  <channel>
    <title>Learn Forex</title>
    <link>http://www.thirdbrainfx.com/education-home</link>
    <description></description>
    <language>en</language>
          <item>
    <title>Riskchecker  is doing great  with 10 trades made for a total of 49  pips</title>
    <link>http://www.thirdbrainfx.com/node/1002</link>
    <description>&lt;div class=&quot;field field-name-body field-type-text-with-summary field-label-hidden&quot;&gt;&lt;div class=&quot;field-items&quot;&gt;&lt;div class=&quot;field-item even&quot; property=&quot;content:encoded&quot;&gt;&lt;p&gt;&lt;b&gt;&lt;a href=&quot;http://www.thirdbrainfx.com/search/node/riskchecker&quot;&gt;Riskchecker&lt;/a&gt;&lt;/b&gt;  is doing great  with 10 trades made for a total of 49 pips gained on &lt;b&gt;&lt;a href=&quot;http://www.thirdbrainfx.com/search/node/EURAUD&quot;&gt;EURAUD&lt;/a&gt;&lt;/b&gt; today.&lt;br /&gt;For this month, &lt;b&gt;&lt;a href=&quot;http://www.thirdbrainfx.com/search/node/mahonfx&quot;&gt;mahonfx&lt;/a&gt;&lt;/b&gt;  is the good strategy with 46 trades made for a total of 299 pips gained on &lt;b&gt;&lt;a href=&quot;http://www.thirdbrainfx.com/search/node/NZDJPY&quot;&gt;NZDJPY&lt;/a&gt;&lt;/b&gt; for a drawdown around -39 pips then   a Risk and Return around 7.67.&lt;/p&gt;&lt;/div&gt;&lt;/div&gt;&lt;/div&gt;</description>
     <pubDate>Fri, 05 Feb 2016 13:00:01 +0000</pubDate>
 <dc:creator>thirdbrainfx</dc:creator>
 <guid isPermaLink="false">1002 at http://www.thirdbrainfx.com</guid>
  </item>
   </channel>
</rss> 
*/
?>