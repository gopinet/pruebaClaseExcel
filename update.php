<?php

date_default_timezone_set('America/Bogota');

    include_once 'conexion.php';

    if(isset($_GET['id_ref'])){
        $id_ref= $_GET['id_ref'];

        $buscar_id=$con->prepare('SELECT * FROM producto WHERE id_ref=:id_ref');
        $buscar_id->execute(array(
            ':id_ref'=>$id_ref
        ));
        $resultado=$buscar_id->fetch();
        //Comparación fechas para saber si se puede modificar
        $fechaActual = date('Y-m-d');
        $fechaVen = $resultado['fecha_ven'];

        if($fechaActual > $fechaVen) {
            header('Location: index.php');
        } elseif ($fechaActual == $fechaVen && $fechaActual < $fechaVen){
        }

    }else {
        header('Location: index.php');
    }

    if(isset($_POST['guardar'])){
        $fecha_ven=$_POST['fecha_ven'];
        $cant_rec=$_POST['cant_rec'];
        $id_ref= $_GET['id_ref'];

        if(!empty($fecha_ven) && !empty($cant_rec) ){
            $consulta_update=$con->prepare('UPDATE producto 
                                            SET fecha_ven=:fecha_ven, cant_rec=:cant_rec 
                                            WHERE id_ref=:id_ref');
            $consulta_update->execute(array(
                ':id_ref' =>$id_ref,
                ':fecha_ven' =>$fecha_ven,
                ':cant_rec' =>$cant_rec
            ));
            header('Location: index.php');

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
    <title>Editar</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="contenedor">
        <h2 class="titulo">PRODUCTOS MÉDICOS - EDITAR</h2>
        <div>
            <form action="" method="post">
                <div class="form-group">
                    <input type="text" name="nombre_ref" value="<?php if($resultado) echo $resultado['nombre_ref']; ?>" class="input__text" disabled>
                    <input type="text" name="lab_productor" value="<?php if($resultado) echo $resultado['lab_productor']; ?>" class="input__text" disabled>
                </div>
                <div class="form-group">
                    <input type="date" name="fecha_ven" value="<?php if($resultado) echo $resultado['fecha_ven']; ?>" class="input__text">
                    <input type="number" name="cant_rec" value="<?php if($resultado) echo $resultado['cant_rec']; ?>" class="input__text">
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