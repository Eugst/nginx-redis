<?php


function GenerateToken($length=20)
{
    $randomBinary = openssl_random_pseudo_bytes(ceil($length/2), $valid);
    //Check if the binary is crypto strong, otherwise generate another token
    $token = $valid ? bin2hex($randomBinary) : GenerateToken($length);

    return $token;
}


session_start();

$timestamp = time();
$token = GenerateToken();
$_SESSION['csrf_tokens'][$token] = $timestamp;


print_r($_SESSION);


echo "!}!\"!{!".date("d-m-Y H:i:s");


echo '</br><button type="button" onclick="location.reload();">Reload page</button>&nbsp;';
echo '<button type="button" onclick="loadDoc()">Reset cache</button>';


?>

<script>
    function loadDoc() {
        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                setTimeout(function(){ location.reload(); }, 1000);
            }
        };
        xhttp.open("GET", "/redis_flush?k=<?= $_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI']; ?>", true);
        xhttp.send();
    }
</script>
