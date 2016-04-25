<?php
/**
 * Created by PhpStorm.
 * User: leandr_g
 * Date: 18/04/2016
 * Time: 22:35
 */

include "config.php";

if (isset($_POST['token_vict']) && isset($_POST['token']))
{
    $token = $_POST['token'];
    $requete = $db_trak->prepare('SELECT * FROM session WHERE `token` = :token');
    $requete->bindParam(':token', $token, PDO::PARAM_STR);
    $requete->execute();
    $reponse = $requete->fetch();
    if ($requete->rowCount() != 0)
    {
        $token = $_POST['token_vict'];
        $requete = $db_trak->prepare('SELECT * FROM victime WHERE `token` = :token');
        $requete->bindParam(':token', $token, PDO::PARAM_STR);
        $requete->execute();
        if ($requete->rowCount() != 0)
        {
            $requete = $db_trak->prepare('UPDATE victime SET `traitement` = "2" WHERE `token` = :token');
            $requete->bindParam(':token', $token, PDO::PARAM_STR);
            $requete->execute();
            $arr = array('status' => 42, 'msg' => "Fichier classe !");
        }
        else
        {
            $arr = array('status' => 203, 'msg' => "Mauvais token victime !");
        }
    }
    else
    {
        $arr = array('status' => 202, 'msg' => "Mauvais token utilisateur !");
    }
}
else
{
    $arr = array('status' => 404, 'msg' => "Il manque des parametres !");
}
echo json_encode($arr);