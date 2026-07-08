<?php
require_once '../app/config/config.php';

$url = isset($_GET['url']) ? $_GET['url'] : 'login';
$url = rtrim($url, '/');
$url = explode('/', $url);

$controlador = $url[0];

if ($controlador === 'login') {
    require_once '../app/controller/UsuarioController.php';
    $controller = new UsuarioController();

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $controller->procesarLogin();
    } else {
        $controller->index();
    }
}

//Dashboard
else if ($controlador === 'dashboard') {
    require_once '../app/controller/DashboardController.php';
    $controller = new DashboardController();
    $controller->index();
}

//Paciente
else if ($controlador === 'pacientes') {
    require_once '../app/controller/PacienteController.php';
    $controller = new PacienteController();

    $accion = isset($url[1]) ? $url[1] : 'index';

    if ($accion === 'guardar' && $_SERVER['REQUEST_METHOD'] === 'POST') {
        $controller->guardar();
    } else if ($accion === 'actualizar' && $_SERVER['REQUEST_METHOD'] === 'POST') {
        $controller->actualizar();
    } else if ($accion === 'eliminar') {
        $controller->eliminar();
    } else {
        $controller->index();
    }
}

//Citas medicas
else if ($controlador === 'citas') {
    require_once '../app/controller/CitaController.php';
    $controller = new CitaController();
    
    $accion = isset($url[1]) ? $url[1] : 'index';

    if ($accion === 'guardar' && $_SERVER['REQUEST_METHOD'] === 'POST') {
        $controller->guardar();
    } else if ($accion === 'actualizar' && $_SERVER['REQUEST_METHOD'] === 'POST') {
        $controller->actualizar();
    } else if ($accion === 'eliminar') {
        $controller->eliminar();
    } else if ($accion === 'cancelar') {
        $controller->cancelar();
    } else {
        $controller->index();
    }
}

//Historial
else if ($controlador === 'historial') {
    require_once '../app/controller/HistorialController.php';
    $controller = new HistorialController();
    
    $accion = isset($url[1]) ? $url[1] : 'index';

    if ($accion === 'guardar' && $_SERVER['REQUEST_METHOD'] === 'POST') {
        $controller->guardar();
    } else if ($accion === 'actualizar' && $_SERVER['REQUEST_METHOD'] === 'POST') {
        $controller->actualizar();
    } else if ($accion === 'eliminar') {
        $controller->eliminar();
    } else {
        $controller->index();
    }   
}

//Facturacion
else if ($controlador === 'facturacion') {
    require_once '../app/controller/FacturaController.php';
    $controller = new FacturacionController();
    
    $accion = isset($url[1]) ? $url[1] : 'index';

    if ($accion === 'guardar' && $_SERVER['REQUEST_METHOD'] === 'POST') {
        $controller->guardar();
    } else if ($accion === 'anular') {
        $controller->anular();
    } else {
        $controller->index();
    }
}

//Cerrar Sesión
else if ($controlador === 'logout') {
    require_once '../app/controller/UsuarioController.php';
    $controller = new UsuarioController();
    $controller->logout();
} else {
    header('Location: ' . URL_BASE . 'index.php?url=login');
    exit;
}
