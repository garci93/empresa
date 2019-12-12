<?php

trait Mayusculizable
{
    public function mayusculas($cadena)
    {
        return mb_strtoupper($cadena);
    }
}

class Hola
{
    use Mayusculizable;

    const PI = 3.1416;

    public static $numInstancias = 0;

    public $nombre = 'Ricardo';

    private $_telefono = '956956956';

    public function __construct($nombre = null)
    {
        if ($nombre !== null) {
            $this->nombre = $nombre;
        }
        self::$numInstancias++;
    }

    public function getTelefono()
    {
        return $this->_telefono;
    }

    public function setTelefono($telefono)
    {
        $this->_telefono = $telefono;
    }

    public function saludar()
    {
        echo "¡Hola " . $this->mayusculas($this->nombre) . "!\n";
        echo "Tu teléfono es " . $this->_telefono . "\n";
        echo "El valor de PI es " . self::PI . "\n";
    }

    public static function padre()
    {
        echo "Soy el padre\n";
    }

    public static function estatico()
    {
        static::padre();
    }
}

class Encantado extends Hola
{
    private $_apellido;

    public static function padre()
    {
        echo "Soy el hijo\n";
    }

    public function __construct($nombre = null, $apellido = null)
    {
        parent::__construct($nombre);
        $this->setApellido($apellido);
        self::$numInstancias += 10;
    }

    public function getApellido()
    {
        return $this->_apellido;
    }

    public function setApellido($apellido)
    {
        $this->_apellido = $apellido;
    }

    public function saludar()
    {
        self::saludar();
        echo $this->mayusculas("Encantado\n");
    }
}

class Cliente
{
    use Mayusculizable;

    public $dni;

    public function mostrarDatos()
    {
        echo $this->mayusculas($this->dni);
    }
}
