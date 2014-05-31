<?php 
try

{
      $bdd = new PDO('mysql:host=localhost;dbname=gsb_ppe2et4; charset=utf8', 'root', '');
}
catch(Exception $e)
{
        die('Erreur : '.$e->getMessage());
}

?>