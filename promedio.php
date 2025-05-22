<?php
require_once("vendor/econea/nusoap/src/nusoap.php");

$namespace = "http://localhost/webservice/promedio.php";
$server = new nusoap_server();
$server->configureWSDL("PromedioService", $namespace);
$server->wsdl->schemaTargetNamespace = $namespace;

// ComplexType para la respuesta
$server->wsdl->addComplexType(
    'ResultadoPromedio',
    'complexType',
    'struct',
    'all',
    '',
    [
        'nombre' => ['name' => 'nombre', 'type' => 'xsd:string'],
        'promedio' => ['name' => 'promedio', 'type' => 'xsd:float'],
        'observacion' => ['name' => 'observacion', 'type' => 'xsd:string'],
    ]
);

// Registro de la funcion
$server->register(
    'calcularPromedio',
    [
        'nombre' => 'xsd:string',
        'lab1' => 'xsd:float',
        'lab2' => 'xsd:float',
        'parcial' => 'xsd:float',
    ],
    ['return' => 'tns:ResultadoPromedio'],
    $namespace,
    false,
    'rpc',
    'encoded',
    'Calcula el promedio del alumno y devuelve observación'
);

// Funcion del servicio
function calcularPromedio($nombre, $lab1, $lab2, $parcial)
{
    $promedio = ($lab1 * 0.25) + ($lab2 * 0.25) + ($parcial * 0.50);
    $observacion = $promedio >= 6 ? "Aprobado" : "Reprobado";

    return [
        'nombre' => $nombre,
        'promedio' => round($promedio, 2),
        'observacion' => $observacion,
    ];
}

$HTTP_RAW_POST_DATA = file_get_contents("php://input");
$server->service($HTTP_RAW_POST_DATA);
?>
