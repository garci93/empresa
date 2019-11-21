<?php

const PAR = [
    'num_emp' => [
        'def' => '',
        'tipo' => TIPO_ENTERO,
        'etiqueta' => 'Número',
    ],
    'nombre' => [
        'def' => '',
        'tipo' => TIPO_CADENA,
        'etiqueta' => 'Nombre',
    ],
    'salario' => [
        'def' => '',
        'tipo' => TIPO_ENTERO,
        'etiqueta' => 'Salario',
        'nofiltrar' => true,
    ],
    'departamento_id' => [
        'def' => '',
        'tipo' => TIPO_ENTERO,
        'etiqueta' => 'Departamento',
        'relacion' => [
            'tabla' => 'departamentos',
            'ajena' => 'id',
            'visualizar' => 'dnombre',
        ],
    ],
];

function comprobarValoresIndex($args, &$errores)
{
    if (!empty($errores)) {
        return;
    }

    extract($args);

    if (isset($args['num_emp']) && $num_emp !== '') {
        if (!ctype_digit($num_emp)) {
            $errores['num_emp'] = 'El número de empleado debe ser un número entero positivo.';
        } elseif (mb_strlen($num_emp) > 4) {
            $errores['num_emp'] = 'El número no puede tener más de cuatro dígitos.';
        }
    }

    if (isset($args['nombre']) && $nombre !== '') {
        if (mb_strlen($nombre) > 255) {
            $errores['nombre'] = 'El nombre del empleado no puede tener más de 255 caracteres.';
        }
    }

    // if (isset($args['salario']) && $salario !== '') {
    //     if (mb_strlen($salario) > 255) {
    //         $errores['salario'] = 'La localidad no puede tener más de 255 caracteres.';
    //     }
    // }
}

function comprobarValores(&$args, $id, $pdo, &$errores)
{
    if (!empty($errores) || empty($_POST)) {
        return;
    }

    extract($args);

    if (isset($args['num_emp'])) {
        if ($num_emp === '') {
            $errores['num_emp'] = 'El número de empleado es obligatorio.';
        } elseif (!ctype_digit($num_emp)) {
            $errores['num_emp'] = 'El número de empleado debe ser un número entero positivo.';
        } elseif (mb_strlen($num_emp) > 4) {
            $errores['num_emp'] = 'El número no puede tener más de cuatro dígitos.';
        } else {
            if ($id === null) {
                $sent = $pdo->prepare('SELECT COUNT(*)
                                         FROM empleados
                                        WHERE num_emp = :num_emp');
                $sent->execute(['num_emp' => $num_emp]);
            } else {
                $sent = $pdo->prepare('SELECT COUNT(*)
                                         FROM empleados
                                        WHERE num_emp = :num_emp
                                          AND id != :id');
                $sent->execute(['num_emp' => $num_emp, 'id' => $id]);
            }
            if ($sent->fetchColumn() > 0) {
                $errores['num_emp'] = 'Ese número de empleado ya existe.';
            }
        }
    }

    if (isset($args['nombre'])) {
        if ($nombre === '') {
            $errores['nombre'] = 'El nombre del empleado es obligatorio.';
        } elseif (mb_strlen($nombre) > 255) {
            $errores['nombre'] = 'El nombre del empleado no puede tener más de 255 caracteres.';
        }
    }

    if (isset($args['salario'])) {
        if ($salario !== '') {
            if (!is_numeric($salario)) {
                $errores['salario'] = 'El salario debe ser un número.';
            } elseif (abs($salario) >= 10000) {
                $errores['salario'] = 'El salario debe estar comprendido entre -9999.99 y 9999.99.';
            }
        } else {
            $args['salario'] = null;
        }
    }

    if (isset($args['departamento_id'])) {
        if ($departamento_id === '') {
            $errores['departamento_id'] = 'El departamento es obligatorio.';
        } elseif (!ctype_digit($departamento_id)) {
            $errores['departamento_id'] = 'El departamento no tiene el formato correcto.';
        } else {
            $sent = $pdo->prepare('SELECT COUNT(*)
                                     FROM departamentos
                                    WHERE id = :id');
            $sent->execute(['id' => $departamento_id]);
            if ($sent->fetchColumn() === 0) {
                $errores['departamento_id'] = 'El departamento no existe.';
            }
        }
    }
}
