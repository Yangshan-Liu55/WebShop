<?php
session_start();
// Ta bort sessionen
session_destroy();

echo '<script>window.location="index.php"</script>';
?>