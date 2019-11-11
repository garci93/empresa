<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <title>Departamentos</title>
</head>
<body>
    <div class="container">
        <div class="row mt-3">
            <div class="col-4 offset-4">
                <?php
                require __DIR__ . '/auxiliar.php';

                const PAR = ['num_dep' => ''];

                $errores = [];
                $pdo = new PDO('pgsql:host=localhost;dbname=datos', 'usuario', 'usuario');
                
                try {
                    $args = comprobarParametros(PAR, $errores);    
                    comprobarErrores($errores);
                    comprobarValores($args, $errores);
                } catch (Exception $e) {
                    // No se hace nada
                }
                dibujarFormulario($args, $errores);
                ?>
            </div>
        </div>
        <?php
        // $sent = $pdo->query('SELECT * FROM departamentos');
        $sent = $pdo->prepare('SELECT *
                                 FROM departamentos
                                WHERE num_dep = :num_dep');
        $sent->execute(['num_dep' => $args['num_dep']]);
        ?>
        <div class="row mt-4">
            <div class="col-8 offset-2">
                <table class="table">
                    <thead>
                        <th scope="col">Número</th>
                        <th scope="col">Nombre</th>
                        <th scope="col">Localidad</th>
                    </thead>
                    <tbody>
                        <?php foreach ($sent as $fila): ?>
                            <tr scope="row">
                                <td><?= $fila['num_dep'] ?></td>
                                <td><?= $fila['dnombre'] ?></td>
                                <td><?= $fila['localidad'] ?></td>
                            </tr>
                        <?php endforeach ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</body>
</html>
