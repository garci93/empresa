<?php session_start() ?>
<!DOCTYPE html>
<html lang="es" dir="ltr">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Borrar</title>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    </head>
    <body>
        <?php
        require __DIR__ . '/../comunes/auxiliar.php';
        require __DIR__ . '/auxiliar.php';

        $id = trim($_GET['id']);

        if (es_POST()) {
            if (isset($_POST['id'])) {
                $id = trim($_POST['id']);
                if (!departamentoVacio($pdo, $id)) {
                    alert('El departamento tiene empleados.', 'danger');
                } else {
                    if (isset($_SESSION['token'])) {
                        $token_sesion = $_SESSION['token'];
                        var_dump($token_sesion);
                        if (isset($_POST['_csrf'])) {
                            $token_form = $_POST['_csrf'];
                            var_dump($token_form);
                            unset($_POST['_csrf']);
                            if ($token_sesion !== $token_form) {
                                alert('Ha ocurrido un error interno en el servidor.', 'danger');
                            } else {
                                borrarFila($pdo, 'departamentos', $id);
                            }
                        } else {
                            alert('Ha ocurrido un error interno en el servidor.', 'danger');
                        }
                    }
                }
            }
            header("Location: /index.php");
        } elseif (hayAvisos()) {
            alert();
        }
        
        ?>
        <div class="container">
            <div class="row">
                <h3>¿Seguro que desea borrar la fila?</h3>
                <div class="col-md-4">
                    <form action="index.php" method="post" class="form-inline">
                        <input type="hidden" name="id" value="<?= $id ?>">
                        <input type="submit" value="Sí" class="form-control btn btn-danger">
                        <a href="index.php" class="btn btn-success">No</a>
                    </form>
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