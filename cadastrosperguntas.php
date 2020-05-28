<?php

##################################################
## Verificando se passaram os campos obrigatorios
##################################################

$required = array('Titulo','Conteudo','CodCategoria','CodUsuario','Senha');

$error = false;
foreach($required as $field) {
    if (empty($_POST[$field])) {
        echo "$field <br>";
        $error = true;
    }
}
if ($error) {
    echo "Você não me deu todos os campos obrigatórios";
    exit();
}

$titulo=$_POST["Titulo"];
$conteudo=$_POST["Conteudo"];
$categoria=$_POST["CodCategoria"];
$login=$_POST["CodUsuario"];
$senha=$_POST["Senha"];


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

$pragma_query = "PRAGMA table_info(Thread);";
//echo $pragma_query;
$insert_1     = "INSERT INTO Thread (";
$insert_2     = "VALUES (";

foreach ($dbh->query($pragma_query) as $row)
    {
        if (!empty($_POST[$row[1]])) {
            $insert_1 = $insert_1 . $row[1] . ",";
            $insert_2 = $insert_2 . '"' . $_POST[$row[1]] . '"' . ",";
        }        
    }

$insert_1 = rtrim($insert_1,',') . ")" ;
$insert_2 = rtrim($insert_2,',') . ");";

$query = $insert_1 . " " .  $insert_2;

echo $query;
    
$stmt  = $dbh->prepare($query); 
$stmt->execute();
$thread_id = $dbh->lastInsertId();

print "Inseriu na Thread $thread_id";

####################################################################################################

$pragma_query2 = "PRAGMA table_info(Post);";
//echo $pragma_query;
$insert_11     = "INSERT INTO Post (";
$insert_22     = "VALUES (";

foreach ($dbh->query($pragma_query2) as $row)
    {
        if (!empty($_POST[$row[1]])) {
            $insert_11 = $insert_11 . $row[1] . ",";
            $insert_22 = $insert_22 . '"' . $_POST[$row[1]] . '"' . ",";
        }        
    }

$insert_11 = $insert_11 . "CodThread" .  ")" ;
$insert_22 = $insert_22 . "$thread_id" . ");";

$query2 = $insert_11 . " " .  $insert_22;

echo $query2;
    
$stmt  = $dbh->prepare($query2); 
$stmt->execute();
$post_id = $dbh->lastInsertId();
print "Inseriu no Post";

##################################################

$update_sql = "Update Thread set Post_Inicial = $post_id where CodThread = $thread_id;";
$stmt  = $dbh->prepare($update_sql); 
$stmt->execute();
?>