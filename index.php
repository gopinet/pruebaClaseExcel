<?php
    include_once 'conexion.php';
    date_default_timezone_set('America/Bogota');

    $sentencia_select=$con->prepare('SELECT * FROM producto ORDER BY fecha_ing DESC');
    $sentencia_select->execute();
    $resultado=$sentencia_select->fetchAll();

    //Opción Buscar
    if(isset($_POST['btn_buscar'])){
        $buscar_text=$_POST['buscar'];
		$select_buscar=$con->prepare('SELECT * FROM producto WHERE fecha_ven >= :campo AND DATE(fecha_ing) = :campo');

		$select_buscar->execute(array(
			':campo' =>$buscar_text
		));

        $resultado=$select_buscar->fetchAll();

	}

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Inicio</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="contenedor">
        <h2 class="titulo">PRODUCTOS MÉDICOS</h2>
        <div class="barra">
            <form action="" class="formulario" method="post">
                <input type="date" name="buscar" placeholder="YYYY-MM-DD" 
				value="<?php if(isset($buscar_text)) echo $buscar_text; ?>" class="input__text">
                <input type="submit" class="btn" name="btn_buscar" value="Buscar">
                <a href="insert.php" class="btn btn__nuevo">NUEVO</a>
            </form>
        </div>
        <table>
            <tr class="head">
                <td>ID</td>
                <td>Nombre Referencia</td>
                <td>Laboratorio Productor</td>
                <td>Fecha Vencimiento</td>
                <td>Cantidad</td>
                <td>Fecha Ingreso</td>
                <td>Acción</td>
            </tr>
            <?php foreach($resultado as $fila): ?>
                <tr class="body">
                    <td><?php echo $fila['id_ref']; ?></td>
                    <td><?php echo $fila['nombre_ref']; ?></td>
                    <td><?php echo $fila['lab_productor']; ?></td>
                    <td><?php echo $fila['fecha_ven']; ?></td>
                    <td><?php echo $fila['cant_rec']; ?></td>
                    <td><?php echo $fila['fecha_ing']; ?></td>
                    
                    <td>
                        <?php
                            //Comparación fechas para saber si se puede modificar
                            $fechaActual = date('Y-m-d');
                            $fechaVen = $fila['fecha_ven'];

                            if($fechaActual > $fechaVen) {
                                echo '<a href="' . htmlspecialchars("")  . '" class="' . htmlspecialchars("btn__expired") . '" disabled>VENCIDO';
                            } elseif ($fechaActual == $fechaVen || $fechaActual < $fechaVen){
                                echo '<a href="' . htmlspecialchars("update.php?id_ref=") . urlencode($fila['id_ref']) . '" class="' . htmlspecialchars("btn__update") . '">EDITAR';
                            }
                        ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>
    </div>
</body>
</html>