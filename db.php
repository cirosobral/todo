<?php

// Classe local do sistema (DB) herda da classe de acesso a dados do PHP (PDO)
class DB extends PDO
{
  public function __construct()
  {
    // Carrega as informações do arquivo de configurações
    $conf = parse_ini_file('./conf/db.ini');

    // Configurações para acesso ao banco de dados
    $host = $conf['host'];
    $user = $conf['user'];
    $pass = $conf['pass'];
    $name = $conf['name'];

    // Define os parâmetros para acessar o banco de dados com base nas configurações
    $dsn = "mysql:host=$host;dbname=$name;charset=utf8";

    // Chama o construtor da classe pai
    parent::__construct($dsn, $user, $pass);
    $this->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  }
}
