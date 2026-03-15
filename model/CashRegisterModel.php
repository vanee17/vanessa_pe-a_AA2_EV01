<?php

class CashRegisterModel
{

    private $PDO;

    //Constructor para inicializar la conexión a la base de datos
    public function __construct()
    {
        require_once(__DIR__ . '/../config/db.php');
        $pdo = new db();
        $this->PDO = $pdo->connection();
    }

    public function updateCashRegister($id_cliente, $metodo_pago, $usuario, $productos)
    {
        if ($_POST["operation"] == "crear") {
            try {
                // iniciar transacción
                $this->PDO->beginTransaction();
                // generar numero_venta
                $stmt = $this->PDO->query("SELECT IFNULL(MAX(numero_venta),0) + 1 AS numero FROM inventa_system.venta");
                $numero = $stmt->fetch(PDO::FETCH_ASSOC);
                $numero_venta = $numero["numero"];

                // insertar venta
                $statement = $this->PDO->prepare("INSERT INTO inventa_system.venta 
                    (numero_venta, cliente_id, metodo_pago, fecha_venta, vendedor_id) 
                    VALUES (?, ?, ?, NOW(), ?)
                ");

                $statement->execute([
                    $numero_venta,
                    $id_cliente,
                    $metodo_pago,
                    $usuario
                ]);

                // obtener id de la venta
                $id_venta = $this->PDO->lastInsertId();

                // insertar productos de la venta
                foreach ($productos as $producto) {
                    $stmtDetalle = $this->PDO->prepare("INSERT INTO inventa_system.venta_producto
                        (id_venta, id_producto, precio_venta, cantidad)
                        VALUES (?, ?, ?, ?)
                    ");

                    $stmtDetalle->execute([
                        $id_venta,
                        $producto["id_producto"],
                        $producto["total"],
                        $producto["cantidad"]
                    ]);
                }

                // confirmar transacción
                $this->PDO->commit();

                return "Venta registrada correctamente";
            } catch (Exception $e) {

                $this->PDO->rollBack();
                return "Error al registrar la venta: " . $e->getMessage();
            }
        } else {
            return "Operación no reconocida";
        }
    }
}
