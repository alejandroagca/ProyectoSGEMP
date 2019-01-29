<?php
    include_once "app.php";
    session_start();
    $app = new App();
    $app->validateSession();
    App::print_head("Gestión aula");
    App::print_nav();
    if(!isset($_GET['idStudent'])){
    $resultsset = $app->getDao()->getAbsences();
    }else{
        $resultsset=$app->getDao()->getAbsencesFrom($_GET['idStudent']);
    }
    
    if(!$resultsset)
        echo "<p>Error al conectar al servidor: ".$app->getDao()->error."</p>";
    else{
        $list = $resultsset->fetchAll();
        if(count($list) == 0){
            echo "<p>No hay ausencias</p>";
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
                    echo "<td scope=\"row\">".$fila['id_student']."</td>".
                    "<td scope=\"row\">".$fila['id_subject']."</td>".
                    "<td scope=\"row\">".$fila['date']."</td>".
                    "<td scope=\"row\">".$fila['justified']."</td>".
                    "<td scope=\"row\">".$fila['description']."</td>";
                    echo "</tr>";
            }
            
            echo "</tbody>";
            echo "</table>";
        }
    }
    App::print_footer();
?>