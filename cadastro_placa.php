<?php
    
session_start();
if (!isset($_SESSION['online']) || $_SESSION['online'] !== true) {
    header('Location: index.php');
    exit;
}
require_once('header.php');
require_once('dados_banco.php');

$aluno = $_POST['aluno'];
$placa = $_POST['placa'];

// Verificar se os campos estão preenchidos
if (empty($aluno) || empty($placa)) {
    echo "Os campos aluno e placa não podem estar vazios. <a href='cadastro.php'>Voltar</a>";
} else {
    // Conectar ao banco de dados e inserir os dados na tabela 'veiculos'
    try {
        $dsn = "mysql:host=$servername;dbname=$dbname";
        $conn = new PDO($dsn, 'root', '');
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        // Preparar a consulta de inserção
        $sql = "INSERT INTO veiculos (aluno, placa) VALUES (:aluno, :placa)";
        $stmt = $conn->prepare($sql);
        
        // Executar a consulta de inserção
        $stmt->bindParam(':aluno', $aluno);
        $stmt->bindParam(':placa', $placa);
        
        if ($stmt->execute()) {
            echo "Aluno: <b>$aluno</b> cadastrado com sucesso.";
        } else {
            echo "Erro ao cadastrar o aluno: " . $stmt->errorInfo()[2];
        }
    } catch (PDOException $e) {
        echo "Erro na conexão com o banco de dados: " . $e->getMessage();
    }
    
    // Fechar a conexão com o banco de dados
    $conn = null;
}
?>
 
<!DOCTYPE html>
<html lang="pt_BR">
<head>
    <meta charset="UTF-8">
    <title>Portaria Fatec</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
    <style type="text/css">
        body{ font: 14px sans-serif; text-align: center; }
    </style>
</head>
<body>
    <div class="page-header">
        <h1>
            <?php echo $_SESSION["username"]; ?>
            <br>
        </h1>
    </div>
    <p>
    Aluno: <b>
        <?php echo $aluno; ?>
    </b>cadastrado com sucesso.
    <br><br>
        <a href="principal.php" class="btn btn-primary">Voltar</a>
    <br><br>
    </p>
</body>
</html>