<?php

setcookie('aceptar', '1', time() + 3600 * 24 * 365, '/');
header('Location: /index.php');
