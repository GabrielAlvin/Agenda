<?php 

    include("Control/conexao.php");

    $usu_codigo = intval($_GET['usuario']);

    $sql_code= "DELETE FROM agenda WHERE id = '$usu_codigo'";
    $sql_query = $mysqli->query($sql_code) or die($mysqli-error);

    if($sql_query)
        echo "
        <script>
            alert('O usuario foi deletado com sucesso.');
            location.href='index.php?p=inicial';
        </script>";
    else
        echo "
        <script>
            alert('Não foi possivel deletar o usuario');
            location.href='index.php?p=inicial';
        </script>
        ";
?>

