<?php

require_once '../app/models/Factura.php';
require_once '../app/models/Paciente.php';
require_once '../app/models/Servicio.php'; 

class FacturacionController {
    
    public function index() {
        session_start();
        if (!isset($_SESSION['usuario_id'])) {
            header('Location: ' . URL_BASE . 'index.php?url=login');
            exit;
        }

        $facturas = Factura::listarTodas();
        $estadisticas = Factura::obtenerEstadisticas();
        $pacientes = Paciente::listarTodos();
        $servicios = Servicio::listarActivos(); 
        
        $num = count($facturas) + 1;
        $proximo_comprobante = 'COMP-' . str_pad($num, 3, "0", STR_PAD_LEFT);

        require_once '../app/views/facturacion.php';
    }

    public function guardar() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            
            // Arreglo unificado
            $datosFactura = [
                'paciente_id'        => $_POST['paciente_id'],
                'numero_comprobante' => $_POST['numero_comprobante'],
                'fecha_emision'      => $_POST['fecha_emision'],
                'forma_pago'         => $_POST['forma_pago'],
                'subtotal'           => $_POST['subtotal_oculto'],
                'iva'                => $_POST['iva_oculto'],
                'total'              => $_POST['total_oculto'],
                'estado'             => 'Pagada' 
            ];

            $detalles = [];
            $servicios_ids = $_POST['item_servicio_id'] ?? [];
            $descripciones = $_POST['item_descripcion'] ?? [];
            $precios = $_POST['item_precio'] ?? [];
            
            for ($i = 0; $i < count($descripciones); $i++) {
                if (!empty($descripciones[$i]) && isset($precios[$i]) && is_numeric($precios[$i])) {
                    $detalles[] = [
                        'servicio_id' => !empty($servicios_ids[$i]) ? $servicios_ids[$i] : null,
                        'descripcion' => $descripciones[$i],
                        'cantidad'    => 1,
                        'precio'      => $precios[$i]
                    ];
                }
            }

            Factura::registrar($datosFactura, $detalles);
        }
        header('Location: ' . URL_BASE . 'index.php?url=facturacion');
        exit;
    }

    public function anular() {
        $id = $_GET['id'] ?? null;
        if ($id) {
            Factura::anular($id);
        }
        header('Location: ' . URL_BASE . 'index.php?url=facturacion');
        exit;
    }
}