<?php
$title = "Dahboard";
ob_start();
?>


<?php
$content = ob_get_clean();
include("template.php");
?>
