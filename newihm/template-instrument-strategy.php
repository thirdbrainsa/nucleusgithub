<div id="<?php echo $instrument ?>" onClick="displayInfo('<?php echo $instrument ?>')"><b><?php echo $instrument ?></b><i><div id="history_<?php echo $instrument ?>"></i></div> 
<div id="info_<?php echo $instrument ?>"> <?php include ('template-inside-each-strategy.php') ?></div></div><br>
<script>
document.getElementById('info_<?php echo $instrument ?>').style.visibility='hidden'; 
document.getElementById('info_<?php echo $instrument ?>').style.position='absolute'; 
</script>