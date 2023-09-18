<?php
$host = "localhost"; 
$usuario = "root"; 
$senha = ""; 
$banco = "u446731902_admin"; 

// Cria uma conexão com o banco de dados
$mysqli = new mysqli($host, $usuario, $senha, $banco);

// Verifica se houve algum erro na conexão
if ($mysqli->connect_error) {
    die("Erro na conexão: " . $mysqli->connect_error);
} else {
    echo "Conexão bem-sucedida!";
}

$query = "SELECT COUNT(id_lancamento), id_usuario FROM lancamentos WHERE data_vencimento=CURDATE() AND id_status in(2,3)";
$resultado = $mysqli->query($query);

// Verifica se a consulta foi bem-sucedida
if ($resultado === false) {
    echo "Erro na consulta: " . $mysqli->error;
}else{
    while ($row = mysqli_fetch_assoc($resultado)) {
        $count = $row['COUNT(id_lancamento)'];
        $idUsuario = $row['id_usuario'];
        if($count>0 && $idUsuario!=''){
            $query_insert = "INSERT INTO alertas (id_usuario, tipo, qut, created_at) 
                        VALUES ('$idUsuario', 1, $count, current_timestamp());";
            $insert = $mysqli->query($query_insert);
        }
    } 
}



$query = "SELECT COUNT(id), id_usuario FROM agendas WHERE data=CURDATE()";
$resultado = $mysqli->query($query);

// Verifica se a consulta foi bem-sucedida
if ($resultado === false) {
    echo "Erro na consulta: " . $mysqli->error;
}else{
    while ($row = mysqli_fetch_assoc($resultado)) {
        $count = $row['COUNT(id)'];
        $idUsuario = $row['id_usuario'];
        if($count>0 && $idUsuario!=''){
            $query_insert = "INSERT INTO alertas (id_usuario, tipo, qut, created_at) 
                        VALUES ('$idUsuario', 2, $count, current_timestamp());";
            $insert = $mysqli->query($query_insert);
        }
    }
}


$query = "SELECT COUNT(id), id_usuario FROM projetos WHERE data=CURDATE()";
$resultado = $mysqli->query($query);

// Verifica se a consulta foi bem-sucedida
if ($resultado === false) {
    echo "Erro na consulta: " . $mysqli->error;
}else{
    while ($row = mysqli_fetch_assoc($resultado)) {
        $count = $row['COUNT(id)'];
        $idUsuario = $row['id_usuario'];
        if($count>0 && $idUsuario!=''){
            $query_insert = "INSERT INTO alertas (id_usuario, tipo, qut, created_at) 
                        VALUES ('$idUsuario', 3, $count, current_timestamp());";
            $insert = $mysqli->query($query_insert);
        }
    }
}


$mysqli->close();

?>