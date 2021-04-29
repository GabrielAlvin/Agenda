<?php 

    include("Control/conexao.php");
    $erro = [];
    if(isset($_POST['confirmar'])){
        // Registros dos dados
        if(!isset($_SESSION))
            session_start();
        
        foreach($_POST as $chave=>$valor)
            $_SESSION[$chave] = $mysqli->real_escape_string($valor);
            
        // Validação dos dados
        if(strlen($_SESSION['nome']) == 0)
            $erro[] = "Preencha o nome corretamente.";

        if(strlen($_SESSION['telefone']) != 15)
            $erro[] = "Preencha o telefone corretamente.";

        if(substr_count($_SESSION['email'], '@') != 1)
            $erro[] = "Preencha o e-mail corretamente.";
        
        if(strlen($_SESSION['cpf']) != 14)
            $erro[] = "Preencha o cpf corretamente.";
        // Inserção no Bando de dados
        if(count($erro) == 0){
            $sql_code = "INSERT INTO agenda (
                nome,
                telefone,
                email,
                cpf)
                VALUES(
                   '$_SESSION[nome]',
                   '$_SESSION[telefone]',
                   '$_SESSION[email]',
                   '$_SESSION[cpf]' 
                )";

            $confirma = $mysqli->query($sql_code);

            //var_dump($mysqli->errno);
            switch ($mysqli->errno) {
                case 1062:
                    $erro[] = "CPF ja cadastrado.";
                    break;
                default:
                    $erro[] = "Houve um problema.";
                    break;
            }
            
            if($confirma){
                unset($_SESSION['nome'],
                $_SESSION['telefone'],
                $_SESSION['email'],
                $_SESSION['cpf']);

                echo "<script> location.href='index.php?p=inicial'; </script>";
            }else{
                $erro[] = $confirma;
            }
        }
    }

?>

<div class="container">
    <a href="index.php?p=inicial" class="btn btn-primary btn-sm mt-3 mb-3">< Voltar</a>

    <div class="col-md-6">
        <h1 class="text-center">Cadastrar usuario</h1>
        <?php 
        if(count($erro) > 0){ 
            echo "<div class='erro'>"; 
            foreach($erro as $valor) 
                echo "$valor <br>"; 
            echo "</div>"; 
        }
        ?>
        <form action="index.php?p=cadastrar" method="POST" class="mt-2">
            <label class="form-label mt-2" for="nome">Nome</label>
            <input class="form-control" name="nome" type="text" value="<?php (isset($_SESSION['nome']) ? $_SESSION['nome'] : '') ?>" required>
            <label class="form-label mt-2" for="telefone">Telefone</label>
            <input class="form-control" id="telefone" name="telefone" type="text" value="<?php (isset($_SESSION['telefone']) ? $_SESSION['telefone'] : '') ?> " onkeypress="mask(this, mphone);" onblur="mask(this, mphone);" maxlength="15" required>
            <label class="form-label mt-2" for="email">E-mail</label>
            <input class="form-control" name="email" type="text" value="<?php (isset($_SESSION['email']) ? $_SESSION['email'] : '') ?>" required>
            <label class="form-label mt-2" for="cpf">CPF</label>
            <input class="form-control" id="cpf" name="cpf" type="text" value="<?php (isset($_SESSION['cpf']) ? $_SESSION['cpf'] : '') ?>" onkeydown="javascript: fMasc( this, mCPF );" maxlength="14" required>

            <input class="btn btn-primary mt-4" value="Salvar" name="confirmar" type="submit" >
        </form>
    </div>
</div>

<script>
    function mask(o, f) {
    setTimeout(function() {
        var v = mphone(o.value);
        if (v != o.value) {
        o.value = v;
        }
    }, 1);
    }

    function mphone(v) {
    var r = v.replace(/\D/g, "");
    r = r.replace(/^0/, "");
    if (r.length > 10) {
        r = r.replace(/^(\d\d)(\d{5})(\d{4}).*/, "($1) $2-$3");
    } else if (r.length > 5) {
        r = r.replace(/^(\d\d)(\d{4})(\d{0,4}).*/, "($1) $2-$3");
    } else if (r.length > 2) {
        r = r.replace(/^(\d\d)(\d{0,5})/, "($1) $2");
    } else {
        r = r.replace(/^(\d*)/, "($1");
    }
    return r;
    }

    function fMasc(objeto,mascara) {
    obj=objeto
    masc=mascara
    setTimeout("fMascEx()",1)
    }

    function fMascEx() {
    obj.value=masc(obj.value)
    }

    function mCPF(cpf){
    cpf=cpf.replace(/\D/g,"")
    cpf=cpf.replace(/(\d{3})(\d)/,"$1.$2")
    cpf=cpf.replace(/(\d{3})(\d)/,"$1.$2")
    cpf=cpf.replace(/(\d{3})(\d{1,2})$/,"$1-$2")
    return cpf
    }
</script>