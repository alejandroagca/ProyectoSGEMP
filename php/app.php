<?php
    include "dao.php";
    class App{
        private $dao;
        function __construct(){
            $this->dao=new Dao();
        }
        /**
         * Función que imprime la cabecera del sitio web
         */
        static function print_head($title="Página SGEMP"){
            echo "<!DOCTYPE html>
            <html lang=\"es\">  
            <head>    
            <title>$title</title>    
            <meta charset=\"UTF-8\">
            <meta name=\"title\" content=\"$title\">
            <meta name=\"description\" content=\"Descripción de la WEB\">  
            <link rel=\"stylesheet\" href=\"../css/bootstrap.css\">
            </head>
            <body>    
            <header>
            <div class=\"text-center\">
            <h1>$title</h1>      
            </div>
            </header>";
        }
        /**
         * Función que imprime el menú del sitio WEB
         */
        static function print_nav(){
            echo "<nav class=\"navbar navbar-expand-lg navbar-dark bg-primary\">
            <div class=\"collapse navbar-collapse\" id=\"navbarSupportedContent\" >
                <ul class=\"navbar-nav\">
                <li class=\"nav-item active\">
                    <a class=\"nav-link\" href=\"liststudents.php\">Listado alumnos<span class=\"sr-only\">(current)</span></a>
                </li>
                <li class=\"nav-item active\">
                    <a class=\"nav-link\" href=\"listabsence.php\">Listado ausencias<span class=\"sr-only\">(current)</span></a>
                </li>
                <li class=\"nav-item active\">
                    <a class=\"nav-link\" href=\"#\">Alta ausencia <span class=\"sr-only\">(current)</span></a>
                </li>
                <li class=\"nav-item active\">
                    <a class=\"nav-link\" href=\"#\">Eliminar ausencia<span class=\"sr-only\">(current)</span></a>
                </li>
                <li class=\"nav-item active\">
                    <a class=\"nav-link\" href=\"logout.php\">Logout<span class=\"sr-only\">(current)</span></a>
                </li>
                </ul>
            </div>
        </nav>";
        }

        /**
         * Función que imprime el pie de página del sitio WEB
         */
        static function print_footer(){
            echo "<div class=\"fixed-bottom text-center\">
            <footer>
                    <h4>Alejandro Aguilar</h4>
                    </footer>
                    </div>
                </body>
            </html>";
        }

        // Función que devuelove la única conexión a la BD
        function getDao(){
            return $this->dao;
        }

        // Función que guarda el nombre de usuario en la variable
        // $_SESSION cuando el usuario ha iniciado sesión en login.php
        function save_session($user){
            $_SESSION["user"]= $user;
        }

        /**
         * Este método inicia sesión y comprueba si está logueado
         */
        function validateSession(){
            if(!$this->isLogged())
                $this->showLogin();
        }

        function invalidateSession(){
            session_start();
            if($this->isLogged())
                unset($_SESSION['user']);
            session_destroy();
            $this->showLogin();
        }

        /**
         * Función que comprueba si existe el usuario
         */
        function isLogged(){
            return isset($_SESSION['user']);
        }

        /**
         * Función que redirige a Login
         */
        function showLogin(){
            header('Location: login.php'); // Solo se puede realizar si no se ha realizado ningun print ni echo.
            // Manda una cabecera
        }

        /**
         *  Función que devuelve todos los estudiantes dados de alta
         */
        function getStudents(){
            return $this->dao->getStudents();
        }

        function getAbsences(){
            return $this->dao->getAbsences();
        }

        function getAbsencesFrom($idStudent){
            return $this->dao->getAbsencesFrom($idStudent);
        }
    }
?>
