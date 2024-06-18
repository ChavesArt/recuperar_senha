<?php
require_once "conexao.php";
$email = $_POST['email'];
$conexao = conectar();
$sql = "SELECT *FROM   usuario  WHERE  email ='$email'";
$resultado = mysqli_query($conexao,$sql);
if($resultado === false){
    echo"Erro ao executar o comando SQL"
    . mysqli_errno($conexao) . ": "
    . mysqli_error($conexao);
}
?>