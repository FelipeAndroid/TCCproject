<?
##################################################
## Verificando se passaram os campos obrigatorios
##################################################

## $required = array('table');

## $error = false;
## foreach($required as $field) {
##     if (empty($_POST[$field])) {
##         $error = true;
##     }
## }
## if ($error) {
##     echo "Você não me deu todos os campos obrigatórios";
##     exit();
## }

## $table=$_POST['table'];


##################################################
## Abrindo o banco de dados
##################################################
$dir = "sqlite:/var/www/es/ulisses/tcc_sqlite/asklimeira.sqlite";
$dbh = new PDO("$dir") or die("Não consegui abrir o banco de dados");
$dbh->exec("SET CHARACTER SET utf8");
$dbh->exec("set names utf8");
$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


##################################################
## Preparando a consulta SQL
##################################################


##     $query =  "SELECT * FROM Post;";
$query = "Select * from Post,Thread where Post.CodThread = Thread.CodThread and Thread.Post_Inicial = Post.CodPost;";

##################################################
## Realizando a consulta e devolvendo ao usuário
##################################################

// echo $query;
$stmt=$dbh->query($query);
echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));


//$sql3 = "SELECT * FROM `post`";
//$items =array();

//$query= mysqli_query($con, $sql3);

//while ($row = mysqli_fetch_array($query,MYSQLI_ASSOC)){
	//echo "o";
	//array_push($items, array('Titulo' => $row['Titulo'], 'Conteudo'=> $row['Conteudo']));
	//$row_array['Titulo'] = $row['Titulo'];
	//$row_array['Conteudo']= $row['Conteudo'];
	//array_push($items, $row_array);

//}

//echo json_encode($items);

//echo "outra coisa";

exit();
?>
