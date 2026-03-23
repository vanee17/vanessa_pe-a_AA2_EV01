<?php
// Endpoints REST simples para CRUD de usuarios (consumir desde Postman)
header('Content-Type: application/json; charset=utf-8');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, Authorization');

// Manejar preflight
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit;
}

// Leer JSON body helper
function getJsonBody() {
    $input = file_get_contents('php://input');
    $data = json_decode($input, true);
    if (json_last_error() === JSON_ERROR_NONE) return $data;
    return $_POST;
}

$method = $_SERVER['REQUEST_METHOD'];
$id = isset($_GET['id']) ? intval($_GET['id']) : null;

try {
    // GET: lista o un usuario -> usar UserController
    if ($method === 'GET') {
        if ($id) {
            // preparar POST para viewEditUser
            $_POST = array();
            $_POST['id_user'] = $id;
            $_GET['f'] = 'viewedituser';
            require_once(__DIR__ . '/UserController.php');
            exit;
        }
        // lista todos (drawUsers devolverá JSON)
        $_POST = array();
        $_GET['f'] = 'drawusers';
        require_once(__DIR__ . '/UserController.php');
        exit;
    }

    // POST: crear (usa updateusers con operation=create)
    if ($method === 'POST') {
        $data = getJsonBody();
        // si viene como JSON, poblar $_POST
        if (is_array($data) && !empty($data)) {
            foreach ($data as $k => $v) $_POST[$k] = $v;
        }
        if (empty($_POST['operation'])) $_POST['operation'] = 'create';
        $_GET['f'] = 'updateusers';
        require_once(__DIR__ . '/UserController.php');
        exit;
    }

    // PUT: actualizar
    if ($method === 'PUT') {
        $data = getJsonBody();
        if (is_array($data)) {
            foreach ($data as $k => $v) $_POST[$k] = $v;
        }
        if ($id) $_POST['id_user'] = $id;
        $_POST['operation'] = 'update';
        $_GET['f'] = 'updateusers';
        require_once(__DIR__ . '/UserController.php');
        exit;
    }

    // DELETE: eliminar
    if ($method === 'DELETE') {
        $data = getJsonBody();
        if (isset($data['id_user'])) $_POST['id_user'] = $data['id_user'];
        elseif ($id) $_POST['id_user'] = $id;
        $_GET['f'] = 'deleteuser';
        require_once(__DIR__ . '/UserController.php');
        exit;
    }

    http_response_code(405);
    echo json_encode(['error' => 'Método no permitido']);

} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['error' => $e->getMessage()]);
}

?>
