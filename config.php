<?php
$host = '';  // localhost
$dbname = '';  // Nome do banco de dados
$username = '';  // Usuário do banco de dados
$password = '';  // Senha do banco de dados

$conn = new mysqli($host, $username, $password, $dbname);


if ($conn->connect_error) {
    die("Falha na conexão" . $conn->connect_error);
}


?>