 <!DOCTYPE html>
<html>
 <head>
 <meta charset="UTF-8">
 <title> Forex professional signals with ThirdBrainFx since 2010</title>
<meta name="description" content="ThirdBrainFx has been operating since 2010 and is a software application designed to buy and sell foreign currencies automatically.This software is made up of multiple programmes called strategies, each of which is independent of the others, and which are essentially based on mathematical algorithms.">
<meta name="keywords" content="mirror trading, social trading, trading, forex, automated forex strategies, forex strategies, forex account, broker">
<meta name="author" content="ThirdBrain SA">

 <?php

 $message="<a href='https://www.thirdbrainfx.com/login-demo-dashboard.php' class='large green button'><i class=\'fa fa-unlock\'></i> CONNECT TRADING ACCOUNT</a> <a href='https://www.thirdbrainfx.com/portfolio-management.php' class='large green button'><i class=\'fa fa-bar-chart\'></i> PERFORMANCES</a> <a href='https://www.thirdbrainfx.com/registration/register.php' class='large green button'><i class=\'fa fa-desktop\'></i> OPEN DEMO</a><a href='http://www.thirdbrainfx.com/products' class='large green button' target=_blank><i class=\'fa fa-share-square-o\'></i> HOW TO COPY THE TRADES ? </a>"; 
 $timex=time()+microtime();
 $token=md5($timex);
 
?>
<link rel="stylesheet" href="https://www.thirdbrainfx.com/css/pure.css">
<link rel="stylesheet" href="https://www.thirdbrainfx.com/css/signal.css">
<link type="text/css" rel="stylesheet" href="https://www.thirdbrainfx.com/css/box.css">
 <link type="text/css" rel="stylesheet" href="https://www.thirdbrainfx.com/css/table.css">
 <link rel="stylesheet" href="https://www.thirdbrainfx.com/font/css/font-awesome.min.css">
 <script src="https://www.thirdbrainfx.com/js/jquery.js"></script>
<script type="text/javascript" src="https://www.thirdbrainfx.com/js/manage.js?time=<?php echo time() ?>"></script>
</head>
<body>
 <table width=960 border=0 cellpadding=0 cellspacing=0>
<tr>
<td colspan=2>
<div id='boxglobalinfo'>
</div>
</td>
</tr>
 <tr>
  <td valign=top witdh=480 halign=left>
<div id='activesignal'>
<?php if (!(isset($_GET['onlyClose']))) {
echo "<img src='img/ajax-loader.gif'>";
}?>
<?php if (!(isset($_GET['onlyClose']))) { ?>
<script>
setInterval(function(){ startRefresh('<?php echo $token;?>'); } , 1000);
</script>
<?php 

} ?>
</div>
</td>
<td valign=top witdh=480 halign=left>
<div id='historysignal'>
<?php if (!(isset($_GET['onlyActive']))) {
echo "<img src='img/ajax-loader.gif'>";
}?>
<script>
<?php if (!(isset($_GET['onlyActive']))) { ?>
setInterval(function(){ startRefreshHistory('<?php echo $token;?>'); } , 1000);
<?php
 } 
?>
</script>
</div>
</td></tr>
<?php
if (isset($_SESSION['password']))
{
?>
<tr>
<td colspan=2>

<div id='boxglobalinfo'>
</div>
</td>
</tr>
<?php
}
?>
<tr>
<td colspan=2>
<div id='balance'></div>
</td>
</tr>

<?php
if (!(isset($_SESSION['password'])))
{
?>
<tr>
	<td colspan=2>
	<form role="form" method="post" class="pure-form pure-form-aligned" action="https://www.thirdbrainfx.com/registration/register.php">
	<table width=100%>
	<caption> Open a demo account </caption>
	<tr>
	<td><input type="text" name="name" placeholder="Name"></td>
	<td><input type="text" name="email" placeholder="E-mail">
	<input type="hidden" name="group" value="ThirdbrainFXDepthGroupDemoUsd">
	<input type="hidden" name="phone" value="">
	<input type="hidden" name="server" value="demo">
	<input type="hidden" name="surname" value="index">
	</td>
	<td><select name="country">
                <option value="AFGHANISTAN">AFGHANISTAN</option>
                <option value="ALAND ISLANDS">ALAND ISLANDS</option>
                <option value="ALBANIA">ALBANIA</option>
                <option value="ALGERIA">ALGERIA</option>
                <option value="AMERICAN SAMOA">AMERICAN SAMOA</option>
                <option value="ANDORRA">ANDORRA</option>
                <option value="ANGOLA">ANGOLA</option>
                <option value="ANGUILLA">ANGUILLA</option>
                <option value="ANTARCTICA">ANTARCTICA</option>
                <option value="ANTIGUA AND BARBUDA">ANTIGUA AND BARBUDA</option>
                <option value="ARGENTINA">ARGENTINA</option>
                <option value="ARMENIA">ARMENIA</option>
                <option value="ARUBA">ARUBA</option>
                <option value="AUSTRALIA">AUSTRALIA</option>
                <option value="AUSTRIA">AUSTRIA</option>
                <option value="AZERBAIJAN">AZERBAIJAN</option>
                <option value="BAHAMAS">BAHAMAS</option>
                <option value="BAHRAIN">BAHRAIN</option>
                <option value="BANGLADESH">BANGLADESH</option>
                <option value="BARBADOS">BARBADOS</option>
                <option value="BELARUS">BELARUS</option>
                <option value="BELGIUM">BELGIUM</option>
                <option value="BELIZE">BELIZE</option>
                <option value="BENIN">BENIN</option>
                <option value="BERMUDA">BERMUDA</option>
                <option value="BHUTAN">BHUTAN</option>
                <option value="BOLIVIA, PLURINATIONAL STATE OF">BOLIVIA, PLURINATIONAL STATE OF</option>
                <option value="BONAIRE, SINT EUSTATIUS AND SABA">BONAIRE, SINT EUSTATIUS AND SABA</option>
                <option value="BOSNIA AND HERZEGOVINA">BOSNIA AND HERZEGOVINA</option>
                <option value="BOTSWANA">BOTSWANA</option>
                <option value="BOUVET ISLAND">BOUVET ISLAND</option>
                <option value="BRAZIL">BRAZIL</option>
                <option value="BRITISH INDIAN OCEAN TERRITORY">BRITISH INDIAN OCEAN TERRITORY</option>
                <option value="BRUNEI DARUSSALAM">BRUNEI DARUSSALAM</option>
                <option value="BULGARIA">BULGARIA</option>
                <option value="BURKINA FASO">BURKINA FASO</option>
                <option value="BURUNDI">BURUNDI</option>
                <option value="CAMBODIA">CAMBODIA</option>
                <option value="CAMEROON">CAMEROON</option>
                <option value="CANADA">CANADA</option>
                <option value="CAPE VERDE">CAPE VERDE</option>
                <option value="CAYMAN ISLANDS">CAYMAN ISLANDS</option>
                <option value="CENTRAL AFRICAN REPUBLIC">CENTRAL AFRICAN REPUBLIC</option>
                <option value="CHAD">CHAD</option>
                <option value="CHILE">CHILE</option>
                <option value="CHINA">CHINA</option>
                <option value="CHRISTMAS ISLAND">CHRISTMAS ISLAND</option>
                <option value="COCOS (KEELING) ISLANDS">COCOS (KEELING) ISLANDS</option>
                <option value="COLOMBIA">COLOMBIA</option>
                <option value="COMOROS">COMOROS</option>
                <option value="CONGO">CONGO</option>
                <option value="CONGO, THE DEMOCRATIC REPUBLIC OF THE">CONGO, THE DEMOCRATIC REPUBLIC OF THE</option>
                <option value="COOK ISLANDS">COOK ISLANDS</option>
                <option value="COSTA RICA">COSTA RICA</option>
                <option value="COTE D'IVOIRE">COTE D'IVOIRE</option>
                <option value="CROATIA">CROATIA</option>
                <option value="CUBA">CUBA</option>
                <option value="CURACAO">CURACAO</option>
                <option value="CYPRUS">CYPRUS</option>
                <option value="CZECH REPUBLIC">CZECH REPUBLIC</option>
                <option value="DENMARK">DENMARK</option>
                <option value="DJIBOUTI">DJIBOUTI</option>
                <option value="DOMINICA">DOMINICA</option>
                <option value="DOMINICAN REPUBLIC">DOMINICAN REPUBLIC</option>
                <option value="ECUADOR">ECUADOR</option>
                <option value="EGYPT">EGYPT</option>
                <option value="EL SALVADOR">EL SALVADOR</option>
                <option value="EQUATORIAL GUINEA">EQUATORIAL GUINEA</option>
                <option value="ERITREA">ERITREA</option>
                <option value="ESTONIA">ESTONIA</option>
                <option value="ETHIOPIA">ETHIOPIA</option>
                <option value="FALKLAND ISLANDS (MALVINAS)">FALKLAND ISLANDS (MALVINAS)</option>
                <option value="FAROE ISLANDS">FAROE ISLANDS</option>
                <option value="FIJI">FIJI</option>
                <option value="FINLAND">FINLAND</option>
                <option value="FRANCE">FRANCE</option>
                <option value="FRENCH GUIANA">FRENCH GUIANA</option>
                <option value="FRENCH POLYNESIA">FRENCH POLYNESIA</option>
                <option value="FRENCH SOUTHERN TERRITORIES">FRENCH SOUTHERN TERRITORIES</option>
                <option value="GABON">GABON</option>
                <option value="GAMBIA">GAMBIA</option>
                <option value="GEORGIA">GEORGIA</option>
                <option value="GERMANY">GERMANY</option>
                <option value="GHANA">GHANA</option>
                <option value="GIBRALTAR">GIBRALTAR</option>
                <option value="GREECE">GREECE</option>
                <option value="GREENLAND">GREENLAND</option>
                <option value="GRENADA">GRENADA</option>
                <option value="GUADELOUPE">GUADELOUPE</option>
                <option value="GUAM">GUAM</option>
                <option value="GUATEMALA">GUATEMALA</option>
                <option value="GUERNSEY">GUERNSEY</option>
                <option value="GUINEA">GUINEA</option>
                <option value="GUINEA-BISSAU">GUINEA-BISSAU</option>
                <option value="GUYANA">GUYANA</option>
                <option value="HAITI">HAITI</option>
                <option value="HEARD ISLAND AND MCDONALD ISLANDS">HEARD ISLAND AND MCDONALD ISLANDS</option>
                <option value="HOLY SEE (VATICAN CITY STATE)">HOLY SEE (VATICAN CITY STATE)</option>
                <option value="HONDURAS">HONDURAS</option>
                <option value="HONG KONG">HONG KONG</option>
                <option value="HUNGARY">HUNGARY</option>
                <option value="ICELAND">ICELAND</option>
                <option value="INDIA">INDIA</option>
                <option value="INDONESIA">INDONESIA</option>
                <option value="IRAN, ISLAMIC REPUBLIC OF">IRAN, ISLAMIC REPUBLIC OF</option>
                <option value="IRAQ">IRAQ</option>
                <option value="IRELAND">IRELAND</option>
                <option value="ISLE OF MAN">ISLE OF MAN</option>
                <option value="ISRAEL">ISRAEL</option>
                <option value="ITALY">ITALY</option>
                <option value="JAMAICA">JAMAICA</option>
                <option value="JAPAN">JAPAN</option>
                <option value="JERSEY">JERSEY</option>
                <option value="JORDAN">JORDAN</option>
                <option value="KAZAKHSTAN">KAZAKHSTAN</option>
                <option value="KENYA">KENYA</option>                                <option value="KIRIBATI">KIRIBATI</option>
                <option value="KOREA, DEMOCRATIC PEOPLE'S REPUBLIC OF">KOREA, DEMOCRATIC PEOPLE'S REPUBLIC OF</option>
                <option value="KOREA, REPUBLIC OF">KOREA, REPUBLIC OF</option>
                <option value="KUWAIT">KUWAIT</option>
                <option value="KYRGYZSTAN">KYRGYZSTAN</option>
                <option value="LAO PEOPLE'S DEMOCRATIC REPUBLIC">LAO PEOPLE'S DEMOCRATIC REPUBLIC</option>
                <option value="LATVIA">LATVIA</option>
                <option value="LEBANON">LEBANON</option>
                <option value="LESOTHO">LESOTHO</option>
                <option value="LIBERIA">LIBERIA</option>
                <option value="LIBYA">LIBYA</option>
                <option value="LIECHTENSTEIN">LIECHTENSTEIN</option>
                <option value="LITHUANIA">LITHUANIA</option>
                <option value="LUXEMBOURG">LUXEMBOURG</option>
                <option value="MACAO">MACAO</option>
                <option value="MACEDONIA, THE FORMER YUGOSLAV REPUBLIC OF">MACEDONIA, THE FORMER YUGOSLAV REPUBLIC OF</option>
                <option value="MADAGASCAR">MADAGASCAR</option>
                <option value="MALAWI">MALAWI</option>
                <option value="MALAYSIA">MALAYSIA</option>
                <option value="MALDIVES">MALDIVES</option>
                <option value="MALI">MALI</option>
                <option value="MALTA">MALTA</option>
                <option value="MARSHALL ISLANDS">MARSHALL ISLANDS</option>
                <option value="MARTINIQUE">MARTINIQUE</option>
                <option value="MAURITANIA">MAURITANIA</option>
                <option value="MAURITIUS">MAURITIUS</option>
                <option value="MAYOTTE">MAYOTTE</option>
                <option value="MEXICO">MEXICO</option>
                <option value="MICRONESIA, FEDERATED STATES OF">MICRONESIA, FEDERATED STATES OF</option>
                <option value="MOLDOVA, REPUBLIC OF">MOLDOVA, REPUBLIC OF</option>
                <option value="MONACO">MONACO</option>
                <option value="MONGOLIA">MONGOLIA</option>
                <option value="MONTENEGRO">MONTENEGRO</option>
                <option value="MONTSERRAT">MONTSERRAT</option>
                <option value="MOROCCO">MOROCCO</option>
                <option value="MOZAMBIQUE">MOZAMBIQUE</option>
                <option value="MYANMAR">MYANMAR</option>
                <option value="NAMIBIA">NAMIBIA</option>
                <option value="NAURU">NAURU</option>
                <option value="NEPAL">NEPAL</option>
                <option value="NETHERLANDS">NETHERLANDS</option>
                <option value="NEW CALEDONIA">NEW CALEDONIA</option>
                <option value="NEW ZEALAND">NEW ZEALAND</option>
                <option value="NICARAGUA">NICARAGUA</option>
                <option value="NIGER">NIGER</option>
                <option value="NIGERIA">NIGERIA</option>
                <option value="NIUE">NIUE</option>
                <option value="NORFOLK ISLAND">NORFOLK ISLAND</option>
                <option value="NORTHERN MARIANA ISLANDS">NORTHERN MARIANA ISLANDS</option>
                <option value="NORWAY">NORWAY</option>
                <option value="OMAN">OMAN</option>
                <option value="PAKISTAN">PAKISTAN</option>
                <option value="PALAU">PALAU</option>
                <option value="PALESTINIAN TERRITORY, OCCUPIED">PALESTINIAN TERRITORY, OCCUPIED</option>
                <option value="PANAMA">PANAMA</option>
                <option value="PAPUA NEW GUINEA">PAPUA NEW GUINEA</option>
                <option value="PARAGUAY">PARAGUAY</option>
                <option value="PERU">PERU</option>
                <option value="PHILIPPINES">PHILIPPINES</option>
                <option value="PITCAIRN">PITCAIRN</option>
                <option value="POLAND">POLAND</option>
                <option value="PORTUGAL">PORTUGAL</option>
                <option value="PUERTO RICO">PUERTO RICO</option>
                <option value="QATAR">QATAR</option>
                <option value="REUNION">REUNION</option>
                <option value="ROMANIA">ROMANIA</option>
                <option value="RUSSIAN FEDERATION">RUSSIAN FEDERATION</option>
                <option value="RWANDA">RWANDA</option>
                <option value="SAINT BARTHELEMY">SAINT BARTHELEMY</option>
                <option value="SAINT HELENA, ASCENSION AND TRISTAN DA CUNHA">SAINT HELENA, ASCENSION AND TRISTAN DA CUNHA</option>
                <option value="SAINT KITTS AND NEVIS">SAINT KITTS AND NEVIS</option>
                <option value="SAINT LUCIA">SAINT LUCIA</option>
                <option value="SAINT MARTIN (FRENCH PART)">SAINT MARTIN (FRENCH PART)</option>
                <option value="SAINT PIERRE AND MIQUELON">SAINT PIERRE AND MIQUELON</option>
                <option value="SAINT VINCENT AND THE GRENADINES">SAINT VINCENT AND THE GRENADINES</option>
                <option value="SAMOA">SAMOA</option>
                <option value="SAN MARINO">SAN MARINO</option>
                <option value="SAO TOME AND PRINCIPE">SAO TOME AND PRINCIPE</option>
                <option value="SAUDI ARABIA">SAUDI ARABIA</option>
                <option value="SENEGAL">SENEGAL</option>
                <option value="SERBIA">SERBIA</option>
                <option value="SEYCHELLES">SEYCHELLES</option>
                <option value="SIERRA LEONE">SIERRA LEONE</option>
                <option value="SINGAPORE">SINGAPORE</option>
                <option value="SINT MAARTEN (DUTCH PART)">SINT MAARTEN (DUTCH PART)</option>
                <option value="SLOVAKIA">SLOVAKIA</option>
                <option value="SLOVENIA">SLOVENIA</option>
                <option value="SOLOMON ISLANDS">SOLOMON ISLANDS</option>
                <option value="SOMALIA">SOMALIA</option>
                <option value="SOUTH AFRICA">SOUTH AFRICA</option>
                <option value="SOUTH GEORGIA AND THE SOUTH SANDWICH ISLANDS">SOUTH GEORGIA AND THE SOUTH SANDWICH ISLANDS</option>
                <option value="SOUTH SUDAN">SOUTH SUDAN</option>
                <option value="SPAIN">SPAIN</option>
                <option value="SRI LANKA">SRI LANKA</option>
                <option value="SUDAN">SUDAN</option>
                <option value="SURINAME">SURINAME</option>
                <option value="SVALBARD AND JAN MAYEN">SVALBARD AND JAN MAYEN</option>
                <option value="SWAZILAND">SWAZILAND</option>
                <option value="SWEDEN">SWEDEN</option>
                <option value="SWITZERLAND">SWITZERLAND</option>
                <option value="SYRIAN ARAB REPUBLIC">SYRIAN ARAB REPUBLIC</option>
                <option value="TAIWAN, PROVINCE OF CHINA">TAIWAN, PROVINCE OF CHINA</option>
                <option value="TAJIKISTAN">TAJIKISTAN</option>
                <option value="TANZANIA, UNITED REPUBLIC OF">TANZANIA, UNITED REPUBLIC OF</option>
                <option value="THAILAND">THAILAND</option>
                <option value="TIMOR-LESTE">TIMOR-LESTE</option>
                <option value="TOGO">TOGO</option>
                <option value="TOKELAU">TOKELAU</option>
                <option value="TONGA">TONGA</option>
                <option value="TRINIDAD AND TOBAGO">TRINIDAD AND TOBAGO</option>
                <option value="TUNISIA">TUNISIA</option>
                <option value="TURKEY">TURKEY</option>
                <option value="TURKMENISTAN">TURKMENISTAN</option>
                <option value="TURKS AND CAICOS ISLANDS">TURKS AND CAICOS ISLANDS</option>
                <option value="TUVALU">TUVALU</option>
                <option value="UGANDA">UGANDA</option>
                <option value="UKRAINE">UKRAINE</option>
                <option value="UNITED ARAB EMIRATES">UNITED ARAB EMIRATES</option>
                <option value="UNITED KINGDOM">UNITED KINGDOM</option>
                <option value="UNITED STATES" selected="&quot;selected&quot;">UNITED STATES</option>
                <option value="UNITED STATES MINOR OUTLYING ISLANDS">UNITED STATES MINOR OUTLYING ISLANDS</option>
                <option value="URUGUAY">URUGUAY</option>
                <option value="UZBEKISTAN">UZBEKISTAN</option>
                <option value="VANUATU">VANUATU</option>
                <option value="VENEZUELA, BOLIVARIAN REPUBLIC OF">VENEZUELA, BOLIVARIAN REPUBLIC OF</option>
                <option value="VIET NAM">VIET NAM</option>
                <option value="VIRGIN ISLANDS, BRITISH">VIRGIN ISLANDS, BRITISH</option>
                <option value="VIRGIN ISLANDS, U.S.">VIRGIN ISLANDS, U.S.</option>
                <option value="WALLIS AND FUTUNA">WALLIS AND FUTUNA</option>
                <option value="WESTERN SAHARA">WESTERN SAHARA</option>
                <option value="YEMEN">YEMEN</option>
                <option value="ZAMBIA">ZAMBIA</option>
                <option value="ZIMBABWE">ZIMBABWE</option>
            </select></td>
	    <td>
	            <input class="class green button" type="submit" name="submit" value="Register">
	    </td>
	    </tr>
	</table>
</form>
	</td>
</tr>
<?php
}
?>
<tr>
<td colspan=2>
<div id='datainfo'>
</div>
</td>
</tr>
<tr>
<td colspan=2 align=center>
<a href='http://www.thirdbrainfx.com/about-us' class='large green button'> WHO IS THIRDBRAIN SA ? </a>  <a href='http://www.thirdbrainfx.com/products' class='large green button'> ALL FOREX PRODUCTS & SERVICES</a> <a href='http://www.thirdbrainfx.com/deposit' class='large green button'> GO LIVE ! </a></center>
</td>
</tr>
<tr>
<td colspan=2>
<img src='thirdbrainfx.gif'><br>
Tel : +41 22 534 90 24<br>
Skype : support.thirdbrainsa<br>
Email us: <a href="mailto:support@thirdbrain.ch">support@thirdbrain.ch</a>
</center>
<br>
<div align=left>
<ul class="social-bookmarks">
<li class="youtube last">
<a href="https://www.youtube.com/user/thirdbrainfx">Youtube</a>
</li>
<li class="facebook first">
<a href="http://www.facebook.com/thirdbrainfx">Facebook</a>
</li>
<li class="twitter">
<a href="http://twitter.com/thirdbrainfx">Twitter</a>
</li>
<li class="linkedin">
<a href="http://www.linkedin.com/company/2807982">Linkedin</a>
</li>
</ul>
</td>
</tr>

</table>
<script>
setInterval(function(){ balanceRefresh('<?php echo $token;?>'); } , 1000);
</script>
<script>
document.getElementById('boxglobalinfo').innerHTML="<?php echo $message ?>";
</script>
<?
if (!(isset($_GET['include'])))
{
include("tracking.php");
}
?>
</body>
</html>