<?php
    include_once "app.php";
    session_start();
    $app = new App();
    $app->validateSession();
    App::print_head("Gestión aula");
    App::print_nav();
    $resultsset = $app->getStudents();
    // 1. Error con la BD
    if(!$resultsset)
        echo "<p>Error al conectar al servidor: ".$app->getDao()->error."</p>";
    // 2. La sentencia es correcta
    else{
        $list = $resultsset->fetchAll();
        // 2.1 Si no hay elementos
        if(count($list) == 0){
            echo "<p>No hay alumnos matriculados</p>";
        }else{
            echo "<table class=\"table table-striped table-dark table-bordered\">";
            echo "<thead class\"\">";
            echo "<tr>";
            for ($i=0; $i < $resultsset->columnCount(); $i++) { 
                $columnMeta = $resultsset->getColumnMeta($i);
                echo "<th scope=\"col\">".strtoupper($columnMeta['name'])."</th>";
            }
            echo "</tr>";
            echo "</thead>";
            echo "<tbody>";
            foreach ($list as $fila) {
                echo "<tr>";
                echo "<td scope=\"row\"> <a href='listabsence.php?idStudent=".$fila['id']."'/>".$fila['id']."</td>".
                "<td scope=\"row\">".$fila['dni']."</td>".
                "<td scope=\"row\">".$fila['name']."</td>".
                "<td scope=\"row\">".$fila['email']."</td>";
                echo "</tr>";
            }
            echo "</tbody>";
            echo "</table>";
        }
    }

    App::print_footer();
?>