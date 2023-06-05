<!DOCTYPE html>
<html>
<head>
    <title>Archivos</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
</head>
<body>
    <div class="container">
        <h1>Archivos</h1>
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Empleado ID</th>
                    <th>Ruta Acta</th>
                    <th>Ruta CURP</th>
                    <th>Ruta CCB</th>
                    <th>Ruta NSS</th>
                    <th>Ruta INE</th>
                    <th>Ruta Foto</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Datos de la base de datos
                $servername = "localhost";
                $username = "root";
                $password = "";
                $dbname = "asistencias";

                // Crear conexión
                $conn = new mysqli($servername, $username, $password, $dbname);

                // Verificar la conexión
                if ($conn->connect_error) {
                    die("Error en la conexión: " . $conn->connect_error);
                }

                // Obtener los registros de la tabla 'archivos'
                $sql = "SELECT * FROM archivos";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $row['id'] . "</td>";
                        echo "<td>" . $row['empleado_id'] . "</td>";
                        echo "<td><a href='" . $row['ruta_acta'] . "' target='_blank'>" . $row['ruta_acta'] . "</a></td>";
                        echo "<td><a href='" . $row['ruta_curp'] . "' target='_blank'>" . $row['ruta_curp'] . "</a></td>";
                        echo "<td><a href='" . $row['ruta_ccb'] . "' target='_blank'>" . $row['ruta_ccb'] . "</a></td>";
                        echo "<td><a href='" . $row['ruta_nss'] . "' target='_blank'>" . $row['ruta_nss'] . "</a></td>";
                        echo "<td><a href='" . $row['ruta_ine'] . "' target='_blank'>" . $row['ruta_ine'] . "</a></td>";
                        echo "<td><a href='" . $row['ruta_foto'] . "' target='_blank'>" . $row['ruta_foto'] . "</a></td>";
                        echo '<td><button type="button" class="btn btn-primary" data-toggle="modal" data-target="#editModal' . $row['id'] . '">Editar</button></td>';
                        echo "</tr>";

                        // Modal para editar archivos
                        echo '<div class="modal fade" id="editModal' . $row['id'] . '" tabindex="-1" role="dialog" aria-labelledby="editModalLabel' . $row['id'] . '" aria-hidden="true">';
                        echo '<div class="modal-dialog" role="document">';
                        echo '<div class="modal-content">';
                        echo '<div class="modal-header">';
                        echo '<h5 class="modal-title" id="editModalLabel' . $row['id'] . '">Editar Archivos</h5>';
                        echo '<button type="button" class="close" data-dismiss="modal" aria-label="Close">';
                        echo '<span aria-hidden="true">&times;</span>';
                        echo '</button>';
                        echo '</div>';
                        echo '<div class="modal-body">';
                        echo '<form method="POST" action="" enctype="multipart/form-data">';
                        echo '<input type="hidden" name="archivo_id" value="' . $row['id'] . '">';
                        echo '<div class="form-group">';
                        echo '<label>Ruta Acta</label>';
                        echo '<input type="file" name="ruta_acta" class="form-control">';
                        echo '</div>';
                        echo '<div class="form-group">';
                        echo '<label>Ruta CURP</label>';
                        echo '<input type="file" name="ruta_curp" class="form-control">';
                        echo '</div>';
                        echo '<div class="form-group">';
                        echo '<label>Ruta CCB</label>';
                        echo '<input type="file" name="ruta_ccb" class="form-control">';
                        echo '</div>';
                        echo '<div class="form-group">';
                        echo '<label>Ruta NSS</label>';
                        echo '<input type="file" name="ruta_nss" class="form-control">';
                        echo '</div>';
                        echo '<div class="form-group">';
                        echo '<label>Ruta INE</label>';
                        echo '<input type="file" name="ruta_ine" class="form-control">';
                        echo '</div>';
                        echo '<div class="form-group">';
                        echo '<label>Ruta Foto</label>';
                        echo '<input type="file" name="ruta_foto" class="form-control">';
                        echo '</div>';
                        echo '<button type="submit" name="guardar" class="btn btn-primary">Guardar</button>';
                        echo '</form>';
                        echo '</div>';
                        echo '</div>';
                        echo '</div>';
                        echo '</div>';
                    }
                } else {
                    echo "<tr><td colspan='9'>No se encontraron archivos.</td></tr>";
                }

                // Procesar el formulario al guardar
                if (isset($_POST['guardar'])) {
                    $archivo_id = $_POST['archivo_id'];

                    // Comprobar si se seleccionó un archivo para cada campo
                    if (isset($_FILES['ruta_acta']) && $_FILES['ruta_acta']['error'] === UPLOAD_ERR_OK) {
                        $ruta_acta_tmp = $_FILES['ruta_acta']['tmp_name'];
                        $ruta_acta_nombre = $_FILES['ruta_acta']['name'];
                        $ruta_acta_destino = "actas/" . $ruta_acta_nombre;

                        // Mover el archivo a la carpeta de destino
                        move_uploaded_file($ruta_acta_tmp, $ruta_acta_destino);

                        // Actualizar el campo 'ruta_acta' en la base de datos
                        $sql_update_acta = "UPDATE archivos SET ruta_acta = '$ruta_acta_destino' WHERE id = '$archivo_id'";
                        $conn->query($sql_update_acta);
                    }


                    if (isset($_FILES['ruta_curp']) && $_FILES['ruta_curp']['error'] === UPLOAD_ERR_OK) {
                        $ruta_curp_tmp = $_FILES['ruta_curp']['tmp_name'];
                        $ruta_curp_nombre = $_FILES['ruta_curp']['name'];
                        $ruta_curp_destino = "curps/" . $ruta_curp_nombre;
                    
                        // Mover el archivo a la carpeta de destino
                        move_uploaded_file($ruta_curp_tmp, $ruta_curp_destino);
                    
                        // Actualizar el campo 'ruta_curp' en la base de datos
                        $sql_update_curp = "UPDATE archivos SET ruta_curp = '$ruta_curp_destino' WHERE id = '$archivo_id'";
                        $conn->query($sql_update_curp);
                    }
                    
                    if (isset($_FILES['ruta_ccb']) && $_FILES['ruta_ccb']['error'] === UPLOAD_ERR_OK) {
                        $ruta_ccb_tmp = $_FILES['ruta_ccb']['tmp_name'];
                        $ruta_ccb_nombre = $_FILES['ruta_ccb']['name'];
                        $ruta_ccb_destino = "ccb/" . $ruta_ccb_nombre;
                    
                        // Mover el archivo a la carpeta de destino
                        move_uploaded_file($ruta_ccb_tmp, $ruta_ccb_destino);
                    
                        // Actualizar el campo 'ruta_curp' en la base de datos
                        $sql_update_curp = "UPDATE archivos SET ruta_ccb = '$ruta_ccb_destino' WHERE id = '$archivo_id'";
                        $conn->query($sql_update_curp);
                    }
                    

                    if (isset($_FILES['ruta_nss']) && $_FILES['ruta_nss']['error'] === UPLOAD_ERR_OK) {
                        $ruta_nss_tmp = $_FILES['ruta_nss']['tmp_name'];
                        $ruta_nss_nombre = $_FILES['ruta_nss']['name'];
                        $ruta_nss_destino = "nss/" . $ruta_nss_nombre;
                    
                        // Mover el archivo a la carpeta de destino
                        move_uploaded_file($ruta_nss_tmp, $ruta_nss_destino);
                    
                        // Actualizar el campo 'ruta_curp' en la base de datos
                        $sql_update_curp = "UPDATE archivos SET ruta_nss = '$ruta_nss_destino' WHERE id = '$archivo_id'";
                        $conn->query($sql_update_curp);
                    }
                    

                    if (isset($_FILES['ruta_ine']) && $_FILES['ruta_ine']['error'] === UPLOAD_ERR_OK) {
                        $ruta_ine_tmp = $_FILES['ruta_ine']['tmp_name'];
                        $ruta_ine_nombre = $_FILES['ruta_ine']['name'];
                        $ruta_ine_destino = "ine/" . $ruta_ine_nombre;
                    
                        // Mover el archivo a la carpeta de destino
                        move_uploaded_file($ruta_ine_tmp, $ruta_ine_destino);
                    
                        // Actualizar el campo 'ruta_curp' en la base de datos
                        $sql_update_curp = "UPDATE archivos SET ruta_ine = '$ruta_ine_destino' WHERE id = '$archivo_id'";
                        $conn->query($sql_update_curp);
                    }

                    if (isset($_FILES['ruta_foto']) && $_FILES['ruta_foto']['error'] === UPLOAD_ERR_OK) {
                        $ruta_foto_tmp = $_FILES['ruta_foto']['tmp_name'];
                        $ruta_foto_nombre = $_FILES['ruta_foto']['name'];
                        $ruta_foto_destino = "foto/" . $ruta_foto_nombre;
                    
                        // Mover el archivo a la carpeta de destino
                        move_uploaded_file($ruta_foto_tmp, $ruta_foto_destino);
                    
                        // Actualizar el campo 'ruta_curp' en la base de datos
                        $sql_update_curp = "UPDATE archivos SET ruta_foto = '$ruta_foto_destino' WHERE id = '$archivo_id'";
                        $conn->query($sql_update_curp);
                    }

                    

                    // Repite el proceso para los otros campos de archivo (ruta_curp, ruta_ccb, etc.)

                    // Redireccionar a la página actual
                    echo '<script>window.location.href = window.location.href;</script>';
                }

                // Cerrar la conexión a la base de datos
                $conn->close();
                ?>
            </tbody>
        </table>
    </div>
</body>
</html>
