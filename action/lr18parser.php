<?php

    $data["10Base5"] = array("bl"=>"11.8", "bp"=>"46.5", "br"=>"169.5", "z"=>"0.0866");
    $data["10Base2"] = array("bl"=>"11.8", "bp"=>"46.5", "br"=>"169.5", "z"=>"0.1026");
    $data["10BaseT"] = array("bl"=>"15.3", "bp"=>"42.0", "br"=>"165.0", "z"=>"0.113");
    $data["10BaseFB"] = array("bl"=>"0.0", "bp"=>"24.0", "br"=>"0.0", "z"=>"0.1");
    $data["10BaseFL"] = array("bl"=>"12.3", "bp"=>"33.5", "br"=>"156.5", "z"=>"0.1");

    $pvv["10Base5"] = array("bl"=>"16", "bp"=>"11");
    $pvv["10Base2"] = array("bl"=>"16", "bp"=>"11");
    $pvv["10BaseFB"] = array("bl"=>"0", "bp"=>"2");
    $pvv["10BaseFL"] = array("bl"=>"10.5", "bp"=>"8");
    $pvv["10BaseT"] = array("bl"=>"10.5", "bp"=>"8");

    $typeSEG = array("S1"=>$_REQUEST['typeS1'], "S2"=>$_REQUEST['typeS2'], "S3"=>$_REQUEST['typeS3'], "S4"=>$_REQUEST['typeS4'], "S5"=>$_REQUEST['typeS5'], "S6"=>$_REQUEST['typeS6']);
    $lengthSEG = array("S1"=>$_REQUEST['l1'], "S2"=>$_REQUEST['l2'], "S3"=>$_REQUEST['l3'], "S4"=>$_REQUEST['l4'], "S5"=>$_REQUEST['l5'], "S6"=>$_REQUEST['l6']);

    $kilk = $_REQUEST['kilkSEG'];

    $res = '<br>';
    
    $Ssum = 0;

    //PDV
    for($i = 1; $i<=$kilk; $i++) {
        
        if ($i == 1) {
            $SEGs["S$i"] = $data[$typeSEG["S$i"]]["bl"]+$lengthSEG["S$i"]*$data[$typeSEG["S$i"]]["z"];
            $res .= "<br>S$i = ".$data[$typeSEG["S$i"]]["bl"]."+".$lengthSEG["S$i"]."*".$data[$typeSEG["S$i"]]["z"]." = ".$SEGs["S$i"];    
        } else if ($i == $kilk) {
                $SEGs["S$i"] = $data[$typeSEG["S$i"]]["br"]+$lengthSEG["S$i"]*$data[$typeSEG["S$i"]]["z"];
                $res .= "<br>S$i = ".$data[$typeSEG["S$i"]]["br"]."+".$lengthSEG["S$i"]."*".$data[$typeSEG["S$i"]]["z"]." = ".$SEGs["S$i"];
            } else {
                $SEGs["S$i"] = $data[$typeSEG["S$i"]]["bp"]+$lengthSEG["S$i"]*$data[$typeSEG["S$i"]]["z"];
                $res .= "<br>S$i = ".$data[$typeSEG["S$i"]]["bp"]."+".$lengthSEG["S$i"]."*".$data[$typeSEG["S$i"]]["z"]." = ".$SEGs["S$i"];
            }
        $Ssum += $SEGs["S$i"];
    }

    $res .= "<br>Ssum =";
    for($i = 1; $i<=$kilk; $i++){
        if($i != $kilk) $res .= $SEGs["S$i"]."+"; 
        else $res .= $SEGs["S$i"];
    }
    $res .= " = $Ssum";

    if ($Ssum <= 575) $res .= "<br> Оскільки $Ssum <= 575, то можна сказати що мережу спроектовано вірно.";
    else $res .= "<br> Оскільки $Ssum > 575, то можна сказати що мережу спроектовано не вірно.";

    //PVV
    $Vsum = 0;
    $res .= "<br><br> Vsum =";
    for($i = 1; $i<$kilk; $i++)
    {
        if ($i == 1) {
            $Vsum += $pvv[$typeSEG["S$i"]]["bl"];
            $res .= $pvv[$typeSEG["S$i"]]["bl"]."+";
        } else {
            $Vsum += $pvv[$typeSEG["S$i"]]["bp"];
            if ($i != $kilk-1) $res .= $pvv[$typeSEG["S$i"]]["bp"]."+";
            else $res .= $pvv[$typeSEG["S$i"]]["bp"];
        }
    }
    $res .= " = $Vsum";

    if ($Vsum <= 49) $res .= "<br> Оскільки $Vsum < 49, то можна сказати що мережу спроектовано вірно.";
    else $res .= "<br> Оскільки $Vsum > 49, то можна сказати що мережу спроектовано не вірно.";

    MessageSend('inf', $res);

?>