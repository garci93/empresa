<?php

function comprobarValoresLogin(&$args, $pdo, &$errores)
{
    if (!empty($errores) || empty($_POST)) {
        return;
    }

    extract($args);

    if (isset($args['login'])) {
        if ($login === '') {
            $errores['login'] = 'El nombre de usuario es obligatorio.';
        } elseif (mb_strlen($login) > 255) {
            $errores['login'] = 'El nombre de usuario no puede tener más de 255 caracteres.';
        } else {
            // Comprobar si el usuario existe
            $sent = $pdo->prepare('SELECT *
                                     FROM usuarios
                                    WHERE login = :login');
            $sent->execute(['login' => $login]);
            if (($fila = $sent->fetch()) === false) {
                $errores['login'] = 'Ese usuario no existe.';
            }
        }
    }

    if (isset($args['password'])) {
        if ($password === '') {
            $errores['password'] = 'La contraseña es obligatoria.';
        } elseif ($fila !== false) {
            // Comprobar contraseña
            if (!password_verify($password, $fila['password'])) {
                $args['password'] = '';
                $errores['password'] = 'Contraseña incorrecta.';
            }
        }
    }
}

function comprobarValoresRegistrar(&$args, $pdo, &$errores)
{
    if (!empty($errores) || empty($_POST)) {
        return;
    }

    extract($args);

    if (isset($args['login'])) {
        if ($login === '') {
            $errores['login'] = 'El nombre de usuario es obligatorio.';
        } elseif (mb_strlen($login) > 255) {
            $errores['login'] = 'El nombre de usuario no puede tener más de 255 caracteres.';
        } else {
            // Comprobar si el usuario existe
            $sent = $pdo->prepare('SELECT *
                                     FROM usuarios
                                    WHERE login = :login');
            $sent->execute(['login' => $login]);
            if (($fila = $sent->fetch()) !== false) {
                $errores['login'] = 'Ese usuario ya existe.';
            }
        }
    }

    if (isset($args['password'])) {
        if ($password === '') {
            $errores['password'] = 'La contraseña es obligatoria.';
        }
    }

    if (isset($args['password_confirm'])) {
        if ($password_confirm === '') {
            $errores['password_confirm'] = 'La confirmación de contraseña es obligatoria.';
        } elseif ($password !== $password_confirm) {
            $errores['password_confirm'] = 'Las contraseñas no coinciden.';
        }
    }

    if (isset($args['email'])) {
        if ($email !== '' && !filter_var($args['email'], FILTER_VALIDATE_EMAIL)) {
            $errores['email'] = 'La dirección de e-mail no es válida.';
        }
    }
}
