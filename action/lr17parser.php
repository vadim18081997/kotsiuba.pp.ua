<?php

    $prea = 8;
    $adr = 12;
    $info = 2;
    $ksum = 4;
    $ldan = $_REQUEST['ldan'];
    $speed = $_REQUEST['speed'];
    $result = '<br>';
//MaxVidstan
    $lframe = $prea+$adr+$info+$ldan+$ksum;
    $result.="lframe = $prea + $adr + $info + $ldan + $ksum = $lframe";

    $lframe_bit = $lframe*8;
    $result.="<br>lframe_bit = $lframe * 8 = $lframe_bit";

    $timepack = $lframe_bit*0.1;
    $result.="<br>timepack = $lframe_bit * 0.1 = $timepack";

    $vid = $timepack*0.000001*$speed;
    $result.="<br>vid = $timepack * 0.000001 * $speed = $vid";

    $maxvid = $vid/2.0;
    $result.="<br>maxvid = $vid/2.0 = $maxvid";

//Propuskna zdatnist
    $timeslid = $timepack+9.6;
    $result.="<br><br> timeslid = $timepack+9.6 = $timeslid";

    $prod  = 1.0/($timeslid*0.000001); //$prod = round($prod, 2);
    $result.="<br>prod = 1.0 / ($timeslid * 0.000001) = $prod";

    $korpzd = ($prod*$ldan*8.0/1024)/1024;
    $result.="<br>korpzd = ($prod * $ldan * 8.0 / 1024) / 1024 = $korpzd";

    $result.="<br>Максимальна відстань: $maxvid м <br>Пропускна здатність: $korpzd Мбіт/c";

    MessageSend('inf', $result);

?>