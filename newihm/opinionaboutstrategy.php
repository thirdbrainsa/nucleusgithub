<?php

// VARIABLE FOR THE OPINION TO  MANAGE WITH
/*
// the total of trades $total_trades 
// profit,drawdown
 //Winning Percentage : <?php echo $winningperc ?> % <br> 
 /Average winning trade : <?php echo $awt ?> pips <br>
 Average loosing trade : <?php echo $alt ?> pips <br>
  Risk and Reward : <?php echo $RaR ?><br>
  Ratio AWT/ALT : <?php echo $hopeofwin ?>
   Last month gain :<?php echo $profit_lm ?> pips <br>
 Last month drawdown :<?php echo $dd_lm ?> pips<br>
 $profit of the month, $drawdown of the month
//*/
$point=0;

if (($awt>$alt) && ($winningperc>50)) {$point++; $additionnal.="This strategy have an higher average winning trade gain than loosing one. With a good winning percentage of ".$winningperc." %.";} //1
if ($RaR> 2) {$point++;$additionnal.="Risk and Reward is good up to ".$RaR." . It means that you can win ".intval($RaR)." times more than your risk to loose.";} //2
if (($winningperc>75) && ($total_trades>20)) {$point++;$additionnal.="Risk and Reward is good up to ".$RaR." . It means that you can win ".intval($RaR)." times more than your risk to loose.";} //3
if ($profit>0) {$point++;$additionnal.="Note that is doing profit too during this month.";} //4 
if ($profit_lm>0) {$point++;$additionnal.="Last month was good.";} //5
if (($hopeofwin>2) && ($winningperc>50) && ($profit>0) ) {$point++;$additionnal.="Profit is positive with % of winning rate OK and chance of gaining next trade is good.";} //6
if ($drawdown==0) {$point++;$additionnal.="No drawdown during the last period.";} // 7
if (($drawdown==0) && ($profit>0) && ($profit_lm>0)) {$point++;$additionnal.="This strategy have a drawdown null this month with profit this month and last month.";} //8
if ($RaR>4) {$point++;$additionnal.="If we compare this drawdown to the pips gained during the same period, this strategy is really a good choice.";} //9
if ($winningperc>90) {$profit++;$additionnal.="A very high winning percentage means a big chance to make profit in short term period.";} //10;

//echo $point;
$advice="";
if ($point==0) 
{
if (($profit_lm<0) && ($profit<0))
{
$advice=" This strategy is NOT playing good and don't have to be selected";
}

if ( ($profit>0) && ($profit_lm<0))
{
$advice=" Don't select now but watch performances in future";

}
if (( $profit>0) && ($profit_lm>0))
{
$advice=" Performances are not so good but strategy makes some pips during 2 months then..don't select but watch";

}
if (($profit_lm>0) && ($profit<0))
{
$advice =" Last month was OK, but this month seems to be in drawdown...don't take";
}

if ($advice=="")
{

	if ($profit>0) {$advice="Wait before to take..."; }
	if ($profit<0) {$advice="We advice you to not take this strategy";}

}
 }
if ($point==1)
{
if ($profit>0) {$advice="Strategy is not recommended but need to carefully watch the progression in future";}
if (($profit>0) && ($profit_lm>0)) {$advice=" Strategy plays right the last 2 months then could be an option for diversification over currencies";}
if ($profit<0) {$advice="No indication to select this strategy";}

}

if ($point==2)
{

if ($profit>0) {$advice="You can include this strategy inside your portfolio";} else {$advice="Check parameters but this strategy could be an option";}

}

if ($point==3)
{

if ($profit>0) {$advice="A good strategy to pick";} else {$advice="Check parameters but this strategy could be an option";}

}
if ($point==4)
{

if ($profit>0) {$advice="A very good choice...need to be added in your portfolio if money management allow you to do it";} else {$advice="Check parameters but this strategy could be an option";}

}
if ($point==5)
{

if ($profit>0) {$advice="This strategy is performing very good and need really to be taken if you can ";} else {$advice="Check others parameters but this strategy could be an option because a lot of indicators give back good points";}

}
if ($point>5)
{

$advice="You should consider to add this perfect strategy inside your portofolio";
}
$advice.=".".$additionnal;
//echo $point." ".$profit_lm." ".$profit;
?>  