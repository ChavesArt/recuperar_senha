<?php

include("config.php");

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require_once "conexao.php";
$email = $_POST['email'];
$conexao = conectar();
$sql = "SELECT *FROM   usuario  WHERE  email ='$email'";

$resultado = executarSql($conexao, $sql);

$usuario = mysqli_fetch_assoc($resultado);
if ($usuario == null) {
    echo "Email não cadastrado! Faça o cadastro e em seguida o login.";
    die();
}
//gerar um tokien único 
$token = bin2hex(random_bytes(50));

require_once 'PHPMailer-master/src/PHPMailer.php';
require_once 'PHPMailer-master/src/SMTP.php';
require_once 'PHPMailer-master/src/exception.php';
$mail = new PHPMailer(true);
try {
    // configurações
    $mail->CharSet = 'UTF-8';
    $mail->Encoding = 'base64';
    $mail->setLanguage('br');
    $mail->SMTPDebug = SMTP::DEBUG_SERVER;
    $mail->isSMTP();
    $mail->Host = 'SMTP.gmail.com';
    $mail->SMTPAuth = true;
    $mail->Username = $config['email'];
    $mail->Password = $config['senha_email'];
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port = 587;
    $mail->SMTPOptions = array(
        'ssl' => array(
            'verify_peer' => false,
            'verify_peer_name' => false,
            'allow_self_signed' => true
        )
    );

    //recipents
    $mail->setFrom($config['email'], 'arthur.2022311833@aluno.iffar.edu.br');
    $mail->AddAddress($usuario['email'], $usuario['nome']);
    $mail->AddReplyto($config['email'], 'arthur');

    //content
    $mail->isHTML(true);
    $mail->Subject = "Recuperação de Senha do sistema";
    $mail->Body = 'olá<br>
    Você solicitou a recuperação da sua conta no snosso sistema.
    Para issomclique no link abaixo para realizar a troca de senha:<br>
    <a href="' . $_SERVER['SERVER_NAME'] . '/recuperar_senha/nova-senha.php?email =' . $usuario['email'] .
        '&token = ' . $token . '">Clique aqui para recuperar o acesso à sua conta!</a><br>
    <br>
    Atenciosamente
    Equipe do sistema.';
    $mail->send();
    echo "Email enviado com sucess!<br>Confira o seu email";
    //gravar as informações no banco
    date_default_timezone_set('America/Sao_Paulo');
    $data = new DateTime('now');
    $agora = $data ->format('Y-m-d H:i:s');

    $sql2 = "INSERT INTO recuperar_senha(email,token,data_criacao,usado)values ('" . $usuario['email'] . "','$token','$agora' , 0)";
    executarSql($conexao,$sql12);
} catch (Exception $e) {
    echo "Não foi possível enviar o email.
    Mailer Error:{$mail->ErrorInfo}";
}
