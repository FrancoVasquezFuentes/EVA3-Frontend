<?php
include_once '../version1.php';

if ($_version == 'Backend') {
    if ($_mantenedor == 'historia') {
        switch ($_metodo) {
            case 'GET':
                if ($_header == $_token_get) {
                    include_once 'controller.php';
                    include_once '../conexion.php';
                    $control = new Controlador();
                    $lista = $control->getAll();
                    http_response_code(200);
                    echo json_encode(["data" => $lista]);  // Se mostrará todo
                } else {
                    http_response_code(401);
                    echo json_encode(["Error" => "No tiene autorización GET"]);
                }
                break;
            case 'POST':
                if ($_header == $_token_post) {
                    include_once 'controller.php';
                    include_once '../conexion.php';
                    $control = new Controlador();
                    $body = json_decode(file_get_contents("php://input"));
                    /*{
                        "tipo": "Ejemplo de tipo",           EJEMPLO DE LO QUE SE TIENE QUE PONER EN EL BODY RAW DE POSTMAN  
                        "texto": "Ejemplo de texto",
                        "imagenes": [1, 2, 3]  // IDs de imágenes relacionadas (opcional)
                    }*/                  
                    $respuesta  = $control->postNuevo($body);
                    if ($respuesta) {
                        http_response_code(201);
                        echo json_encode(["data" => $respuesta]);
                    } else {
                        http_response_code(409);
                        echo json_encode(["Error" => "Error al crear la historia"]);
                    }
                } else {
                    http_response_code(401);
                    echo json_encode(["Error" => "No tiene autorización POST"]);
                }
                break;
            case 'PATCH':
                if ($_header == $_token_patch) {
                    include_once 'controller.php';
                    include_once '../conexion.php';
                    $control = new Controlador();
                    if ($existeId && $existeAccion) {
                        if ($valorAccion == 'apagar') {
                            $respuesta = $control->patchEncenderApagar($valorId, 'false');
                            // echo "patch... $valorId - $valorAccion";
                            http_response_code(200);
                            echo json_encode(['data' => $respuesta]);
                        } else if ($valorAccion == 'encender') {
                            $respuesta = $control->patchEncenderApagar($valorId, 'true');
                            http_response_code(200);
                            echo json_encode(['data' => $respuesta]);
                        } else {
                            echo 'error con acciones';
                        }
                    } else {
                        echo 'faltan parametros';
                    }
                } else {
                    http_response_code(401);
                    echo json_encode(['error' => 'no tiene autorizacion patch']);
                }
                break;
            case 'PUT':
                if ($_header == $_token_put) {
                    include_once 'controller.php';
                    include_once '../conexion.php';
                    $body = json_decode(file_get_contents("php://input", true));
                    // var_dump($body);
                    $control = new Controlador();
                    if (strlen($body->texto) > 0) {
                        $respuesta = $control->putTextoById($body->texto, $body->id);
                    }
                    if (strlen($body->tipo) > 0) {
                        $respuesta = $control->putTipoById($body->tipo, $body->id);
                    }
                    http_response_code(200);
                    echo json_encode(['data' => $respuesta]);
                } else {
                    http_response_code(401);
                    echo json_encode(['error' => 'no tiene autorizacion put']);
                }
                break;
            case 'DELETE':
                if ($_header == $_token_delete) {
                    include_once 'controller.php';
                    include_once '../conexion.php';
                    $control = new Controlador();
                    $respuesta = $control->deleteById($valorId);
                    http_response_code(200);
                    echo json_encode(['data' => $respuesta]);
                } else {
                    http_response_code(401);
                    echo json_encode(['error' => 'no tiene autorizacion delete']);
                }
                break;
            default:
                http_response_code(405);
                echo json_encode(["Error" => "Método no permitido"]);
            break;
        }
    }
}
?>