<?php
    include_once "app.php";
    session_start();
    App::print_head("Inicio de sesión");
?>
    <!-- Crear el formulario con Bootstrap --> 
    <div class="container">
        <div class="row">
            <div class="col-12 col-md-4 offset-md-4">
                <form method="POST" action="login.php">
                    <div class="form-group">
                        <label for="user">Usuario: </label>
                        <input id="user" name="user" type="text" autofocus="autofocus" required="required" class="form-control"/>
                    </div>
                    <div class="form-group">
                        <label for="password">Password: </label>
                        <input id="password" name="password" type="password" autofocus="autofocus" required="required" class="form-control"/>
                    </div>
                    <div class="text-center">
                        <input type="submit" value="Iniciar sesión" class="btn btn-primary"/>
                    </div>
                </form>
            </div>
        </div><!-- row -->
    </div><!-- container-->
<?php
if($_SERVER["REQUEST_METHOD"] == "POST"){
    $user =$_POST["user"];
    $password=$_POST["password"];
    if(empty($user)){
        echo "<p>Debes introducir un nombre de usuario</p>";
    }
    else if (empty($password)) {
        echo "<p>Debes introducir una contraseña</p>";
    }
    else{
        //Realizar la conexión con la base de datos y comprobar si el usuario existe
        $app = new App();
        if(!$app->getDao()->isConnected()){
            // Mostrar el error
            echo "<p>".$app->getDao()->error."</p>";
            echo "<p>No se pudo realizar la conexión a la base de datos</p>";
        }else if($app->getDao()->validateUser($user, $password)){
            // Iniciar sesión
            //echo "<p>Usuario correcto</p>";
            //Guardar la sesión
            $app->save_session($user);
            //Redirección a la página principal del proyecto
            echo "<script language=\"javascript\">window.location.href=\"aula.php\"</script>";
        }else{
            echo "<p>Usuario incorrecto</p>";

        }
                
    }
}
    App::print_footer();
?>
