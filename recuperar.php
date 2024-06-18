<?php
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

require_once 'PHPMailer/src/PHPMailer.php';
require_once 'PHPMailer/src/SMTP.php';
require_once 'PHPMailer/src/exeption.php';
$mail = new PHPMailer(true);
try{

}catch(Exception $e){
    echo"Não foi possível enviar o email.
    Mailer Error:{$email -> ErrorInfo}";
}