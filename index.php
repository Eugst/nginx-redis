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
<?php

echo "!}!\"!{!".date("d-m-Y H:i:s");


echo '</br><button type="button" onclick="location.reload();">Reload page</button>&nbsp;';
echo '<button type="button" onclick="loadDoc()">Reset cache</button>';
