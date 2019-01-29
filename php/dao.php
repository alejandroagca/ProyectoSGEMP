<?php 
//Clase que va a gestionar la conexión a la base de datos
define ("DATABASE", "aula");
define ("DSN", "mysql:host=localhost;dbname=".DATABASE);
define ("USER", "root");
define ("PASSWORD", "root");
//Definir tablas
define ("TABLE_USER", "user");
define ("COLUMN_USER_NAME", "user");
define ("COLUMN_USER_PASSWORD", "password");

define ("TABLE_STUDENT", "student");

define ("TABLE_ABSENCE", "adsence");
define ("COLUMN_ID_STUDENT", "id_student");

class Dao{
    private $conn;
    public $error;
    function __construct(){
        try {
            $this->conn = new PDO(DSN, USER, PASSWORD);
        } catch (PDOException $e) {
            //Gestionamos el error a la conexión a la base datos
            $this->error = "Error en la conexión: ".$e->getMessage();
        }
    }
    function isConnected(){
        return isset($this->conn);
    }
    // Función que comprueba si existe el usuario en la tabla user
    function validateUser($user, $password){
        $sql = "SELECT * FROM ".TABLE_USER." WHERE ".COLUMN_USER_NAME."='".$user."' AND ".COLUMN_USER_PASSWORD."=sha1('".$password."')";
        echo $sql;
        // Ejecutar la sentencia en el objeto PDO
        $statement = $this->conn->query($sql);
        $flag = false;
        if($statement->rowCount()==1){
            $flag = true;
        }
        return $flag;
    }

    function getStudents(){
        try{
            $sql = "SELECT * FROM ".TABLE_STUDENT;
            $resultset = $this->conn->query($sql);
            return $resultset;
        }
        catch(PDOException $e){
            $this->error=$e->getMessage();
        }
    }

    function getAbsences(){
        try{
            $sql = "SELECT * FROM ".TABLE_ABSENCE;
            $resultset = $this->conn->query($sql);
            return $resultset;
        }catch(PDOException $e){
            $this->error=$e->getMessage();
        }
    }

    function getAbsencesFrom($idStudent){
        try{
            $sql = "SELECT * FROM ".TABLE_ABSENCE." WHERE ".COLUMN_ID_STUDENT. " = :idStudent";
            //$resultset = $this->conn->query($sql);
            $resultset = $this->conn->prepare($sql);
            $resultset->bindParam(':idStudent', $idStudent);
            //$resultset->execute(array(':idStudent' =>$idStudent));
            $resultset->execute();
            return $resultset;
        }catch(PDOException $e){
            $this->error=$e->getMessage();
        }
    }
}
?>