<?php
    if (!isset($pagina))
        exit;

    
    $sql = "select * from banner order by rand() limit 1";
    $consulta = $pdo->prepare($sql);
    $consulta->execute();

    $dados = $consulta->fetch(PDO::FETCH_OBJ);
    $imagem = $dados->banner;
?>

<!-- banner promocional -->
<img src="../../admin/fotos/<?=$imagem?>.jpg" class="img-fluid" alt="<?=$imagem?>">
<br>

<h1>Home</h1>

<!-- puxar todos os produtos -->
<?php
    if (empty($_POST["busca"])){
        $sqlProduto = "select p.*, e.maisComprados from produtos p
        inner join especiais e on (e.id = p.id)
        where e.maisComprados = 'S'
        order by p.produto";
        $consultaProduto = $pdo->prepare($sqlProduto);
        $consultaProduto->execute();

    } else {
        $busca = "%".trim($_POST["busca"] ?? NULL)."%";
        $sqlProduto = "select p.*, e.maisComprados from produtos p
        inner join especiais e on (e.id = p.id)
        where e.maisComprados = 'S'
        where p.produto like :busca
        order by p.produto";
        $consultaProduto = $pdo->prepare($sqlProduto);
        $consultaProduto->bindParam(":busca", $busca);
        $consultaProduto->execute();
    }
    
    ?>
    
    <div class="container text-center">
        <div class="row row-cols-3">

    <?php
    //if ()
    While ($dados = $consultaProduto->fetch (PDO::FETCH_OBJ)){
    ?>
    <div class="col">
        <div class="card">
            <img src="../../admin/fotos/<?=$dados->imagem?>m.jpg" class="card-img-top" alt="<?=$dados->produto?>">

            <div class="card-body">
                <h5 class="card-title"><?=$dados->produto?></h5>
                <p class="card-text"><?=$dados->descricao?></p>
                <a href="produto" class="btn btn-primary" value = "<?=$dados->id?>">Detalhes</a>
            </div>
        </div>
        <br>
    </div>
    <?php
    }
    ?>
    </div>
    </div>