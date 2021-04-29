<?php 

    include("Control/conexao.php");
    $sql_code = "SELECT * FROM agenda";

    $sql_query = $mysqli->query($sql_code) or die($mysqli->error);
    $linha = $sql_query->fetch_assoc();

?>

<div class="container mt-3">
<a href="index.php?p=cadastrar" class="btn btn-primary btn-sm">Cadastrar ></a>

<table class="table table-hover table-sm mt-4">
    <thead> 
        <tr class="text-center">
            <th scope="col">Nome</th>
            <th scope="col">Telefone</th>
            <th scope="col">E-mail</th>
            <th scope="col">CPF</th>
            <th scope="col">Ação</th>
        </tr>
    </thead>
    <?php do{ ?>
    <tbody>
        <tr class="text-center">
            <td><?php echo @$linha['nome'] ?></td>
            <td><?php echo @$linha['telefone'] ?></td>
            <td><?php echo @$linha['email'] ?></td>
            <td><?php echo @$linha['cpf'] ?></td>
            <td>
                <a href="index.php?p=editar&usuario=<?php echo $linha['id']; ?>" class="btn btn-outline-primary btn-sm">Editar</a>
                <a href="javascript: if(confirm('Tem certeza que deseja deletar o usuário <?php echo $linha['nome']; ?>?'))
                location.href='index.php?p=deletar&usuario=<?php echo $linha['id']; ?>';" class="btn btn-outline-danger btn-sm">Excluir</a>
            </td>
        </tr>
    <?php } while($linha = $sql_query->fetch_assoc()); ?>
</table>
</div>