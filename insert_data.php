<?
##################################################
## Verificando se passaram os campos obrigatorios
##################################################
echo "Iniciando Inserção ";



$required = array('table');

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



echo "Campos obrigatórios inseridos ";

$table=$_POST['table'];


##################################################
## Abrindo o banco de dados
##################################################

$dir = "sqlite:/var/www/es/ulisses/tcc_sqlite/asklimeira.sqlite";
$dbh = new PDO("$dir") or die("Não consegui abrir o banco de dados");
$dbh->exec("SET CHARACTER SET utf8");
$dbh->exec("set names utf8");
$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

##################################################
## Criando o insert
##################################################

$pragma_query = "PRAGMA table_info($table);";
$insert_1     = "INSERT INTO $table (";
$insert_2     = "VALUES (";

foreach ($dbh->query($pragma_query) as $row)
    {
        if (isset($_POST[$row[1]])) {
            $insert_1 = $insert_1 . $row[1] . ",";
            $insert_2 = $insert_2 . '"' . $_POST[$row[1]] . '"' . ",";
        }        
    }

$insert_1 = rtrim($insert_1,',') . ")" ;
$insert_2 = rtrim($insert_2,',') . ");";

$query = $insert_1 . " " .  $insert_2;
## echo $query;
    
$stmt  = $dbh->prepare($query); 
$stmt->execute();
$id = $dbh->lastInsertId(); ## Chave primaria
echo "$id";   
exit();

?>

