<?php
include_once "../base.php";

$Bottom->save(['id'=>1,'bottom'=>$_POST['bottom']]);
to("../back.php?do=bottom");
?>