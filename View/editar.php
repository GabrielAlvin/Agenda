<?php 

    include("Control/conexao.php");
    $erro = [];
    if(!isset($_GET['usuario']))
        echo "<script> alert('Codigo invalido'); locantion.href='index.php?p=inicial'; </script>";
    else{

    $usu_codigo = intval($_GET['usuario']);

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
            $sql_code = "UPDATE agenda SET
                nome = '$_SESSION[nome]',
                telefone = '$_SESSION[telefone]',
                email = '$_SESSION[email]',
                cpf =  '$_SESSION[cpf]' 
                WHERE id = '$usu_codigo'";

            $confirma = $mysqli->query($sql_code) or die($mysqli->error);

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
    }else{
        $sql_code = "SELECT * FROM agenda WHERE id = '$usu_codigo'";
        $sql_query = $mysqli->query($sql_code) or die($mysqli->error);
        $linha = $sql_query->fetch_assoc();

        if(!isset($_SESSION))
            session_start();

        $_SESSION['nome'] = $linha['nome'];
        $_SESSION['telefone'] = $linha['telefone'];
        $_SESSION['email'] = $linha['email'];
        $_SESSION['cpf'] = $linha['cpf'];
    }

?>

<div class="container">
    <a href="index.php?p=inicial" class="btn btn-primary btn-sm mt-3 mb-3">< Voltar</a>

    <div class="col-md-6">
        <h1 class="text-center">Editar usuario</h1>
        <?php 
        if(count($erro) > 0){ 
            echo "<div class='erro'>"; 
            foreach($erro as $valor) 
                echo "$valor <br>"; 

            echo "</div>"; 
        }
        ?>

        <form action="index.php?p=editar&usuario=<?php echo $usu_codigo ?>" method="POST" class="mt-2">
            <label class="form-label mt-2" for="nome">Nome</label>
            <input class="form-control" name="nome" type="text" value="<?php echo $_SESSION['nome']?>" required>
            <label class="form-label mt-2" for="telefone">Telefone</label>
            <input class="form-control" id="telefone" name="telefone" type="text" value="<?php echo $_SESSION['telefone']?>" onkeypress="mask(this, mphone);" onblur="mask(this, mphone);" maxlength="15" required>
            <label class="form-label mt-2" for="email">E-mail</label>
            <input class="form-control" name="email" type="text" value="<?php echo $_SESSION['email']?>" required>
            <label class="form-label mt-2" for="cpf">CPF</label>
            <input class="form-control" name="cpf" type="text" value="<?php echo $_SESSION['cpf']?>" onkeydown="javascript: fMasc( this, mCPF );" maxlength="14" required>

            <input class="btn btn-primary mt-4" value="Editar" name="confirmar" type="submit" >
        </form>
        <?php } ?>
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

    function ValidaCPF(){	
	var cpf=document.getElementById("cpf").value; 
	var cpfValido = /^(([0-9]{3}.[0-9]{3}.[0-9]{3}-[0-9]{2})|([0-9]{11}))$/;	 
	if (cpfValido.test(cpf) == true)	{ 
	console.log("CPF Válido");	
	} else	{	 
	console.log("CPF Inválido");	
	}
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