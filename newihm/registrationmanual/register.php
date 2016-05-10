<?php
if (isset($_GET['partner']))
{
	//$_SESSION['partner']=$_GET['partner'];

	setcookie("partner",$_GET['partner']);
}
if (!(isset($_GET['nostats'])))
{
?>
<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-56538817-3', 'auto');
  ga('send', 'pageview');

</script>
<?php
}
// setup autoloading
require_once('vendor/autoload.php');

$config = require('config.php');

$method = $_SERVER['REQUEST_METHOD'];

require_once('templater.php');

$m = templater();

if($method == 'POST') {
    $server = isset($_POST['server'])?$_POST['server']:'demo';

    if($server != 'demo' && $server != 'live')
        $server = 'demo';

    require_once('xmanager.php');

    $xmanager = new XManager($config['servers'][$server]);

    if($xmanager->register($_POST, $server, $config['account'][$server]['leverage'], $config['account'][$server]['deposit'])) {
        header('Location: confirm.php');
        exit();
    } else {
        echo $m->render('layout', array(
            'content' => $m->render('index', array(
                'account_type' => $server,
                'account_type_upper' => strtoupper($server),
                'groups' => $config['groups'][$server],
                'error' => $xmanager->lastError(),
                'fields' => $config['fields'],
                'required' => $config['required'],
                'defaults' => $_POST
            ))
        ));
    }
} else {
    // setup utilities
    $account_type = isset($_GET['server'])?$_GET['server']:'demo';

    if($account_type != 'demo' && $account_type != 'live')
        $account_type = 'demo';
    
    echo $m->render('layout', array(
        'content' => $m->render('index', array(
            'account_type' => $account_type,
            'account_type_upper' => strtoupper($account_type),
            'groups' => $config['groups'][$account_type],
            'fields' => $config['fields'],
            'required' => $config['required'],
            'defaults' => array()
        ))
    ));
}