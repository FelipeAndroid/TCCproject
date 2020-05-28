<?

##################################################
## Verificando se passaram os campos obrigatorios
##################################################

$required = array('CodUsuario', 'Senha');

$error = false;
foreach($required as $field) {
    if (empty($_POST[$field])) {
        $error = true;
    }
}
if ($error) {
    echo "Você não me deu todos os campos obrigatórios";
    exit();
}

$login=$_POST['CodUsuario'];
$senha=$_POST['Senha'];


##################################################
## Abrindo o banco de dados
##################################################
$dir = "sqlite:/var/www/es/ulisses/tcc_sqlite/asklimeira.sqlite";
$dbh = new PDO("$dir") or die("Não consegui abrir o banco de dados");
$dbh->exec("SET CHARACTER SET utf8");
$dbh->exec("set names utf8");
$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

##################################################

$login=isset($_POST["CodUsuario"]) ? addslashes(trim($_POST["CodUsuario"])):FALSE;
$senha=$_POST["Senha"];
if(!$login||!$senha){
    $valor = 0;
    echo json_encode($valor);
    exit();
}

$sql = "SELECT * FROM `Usuario` WHERE CodUsuario = '$_POST[CodUsuario]'";
$resultado = $dbh->query($sql);
$row       = $resultado->fetch(PDO::FETCH_ASSOC);

if($login==$row["CodUsuario"]&&$senha==$row["Senha"]){
    $valor = 1;
    echo json_encode($valor);
}



else{
    $valor = 0;
    echo json_encode($valor);

}

?>