<?php require_once('Connections/connSQL.php'); ?>
<?php
    session_start();

    echo ini_get('session.save_path');
    echo '<br>';
    echo ini_get('session.name');
    echo '<br>';
    echo '<a href="../erp/public">erp</a>';
    echo "<pre>";
    print_r($_SESSION);
    echo "</pre>";
?>