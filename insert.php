<?php
    include_once 'conexion.php';

    if(isset($_POST['guardar'])) {
        $id_ref=$_POST['id_ref'];
        $nombre_ref=$_POST['nombre_ref'];
        $lab_productor=$_POST['lab_productor'];
        $fecha_ven=$_POST['fecha_ven'];
        $cant_rec=$_POST['cant_rec'];

        if(!empty($id_ref) && !empty($nombre_ref) && !empty($lab_productor) && !empty($fecha_ven) && !empty($cant_rec) ){

            $sentencia_select=$con->prepare('SELECT id_ref FROM producto WHERE DATE(fecha_ing) = DATE(CURRENT_TIMESTAMP)');
            $sentencia_select->execute();
            $resultado=$sentencia_select->fetchAll();
            $esta = False;
            foreach ($resultado as $fila) {
                if ($fila['id_ref'] == $id_ref) {
                    $esta = True;
                    break;
                }
            }
            
            if(!$esta) {
                $consulta_insert=$con->prepare('INSERT INTO producto(id_ref, nombre_ref, lab_productor, fecha_ven, cant_rec) 
                                            VALUES (:id_ref,:nombre_ref,:lab_productor,:fecha_ven,:cant_rec)');
                $consulta_insert->execute(array(
                    'id_ref' =>$id_ref,
                    ':nombre_ref' =>$nombre_ref,
                    ':lab_productor' =>$lab_productor,
                    ':fecha_ven' =>$fecha_ven,
                    ':cant_rec' =>$cant_rec
                ));
                header('Location: index.php');
            } else {
                echo "<script> alert('No se puede agregar la misma referencia en el mismo día'); </script>";
            }

        } else {
            echo "<script> alert('Los campos están vacios'); </script>";
        }
    }

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Nuevo Producto</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="contenedor">
        <h2 class="titulo">PRODUCTOS MÉDICOS - INSERTAR</h2>
        <div>
            <form action="" method="post">
                <div class="form-group">
                    <input type="text" name="id_ref" placeholder="ID Referencia" class="input__text">
                    <input type="text" name="nombre_ref" placeholder="Nombre Referencia" class="input__text">
                </div>
                <div class="form-group">
                    <input type="text" name="lab_productor" placeholder="Laborotorio Productor" class="input__text">
                    <input type="date" name="fecha_ven" placeholder="Fecha Vencimiento" class="input__text">
                </div>
                <div class="form-group">
                    <input type="number" name="cant_rec" placeholder="Cantidad Recibida" class="input__text">
                </div>
                <div class="btn__group">
                    <a href="index.php" class="btn btn__danger">CANCELAR</a>
                    <input type="submit" name="guardar" value="GUARDAR" class="btn btn__primary">
                </div>
            </form>
        </div>
    </div>
</body>
</html>