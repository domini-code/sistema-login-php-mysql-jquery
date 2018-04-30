<?php
require_once "../inc/config.php";

if($_SERVER['REQUEST_METHOD'] == 'POST'){
    header("Content-Type: application/json");
    $array_devolver=[];
    $email = strtolower($_POST['email']);
    $password = $_POST['password'];

    // comprobar si el user existe 
    $buscar_user = $con->prepare("SELECT * FROM usuarios WHERE email = '$email' LIMIT 1");
    $buscar_user->bindParam(':email', $email, PDO::PARAM_STR);
    $buscar_user->execute();

    if($buscar_user->rowCount() == 1){
        // Existe
        $user = $buscar_user->fetch(PDO::FETCH_ASSOC);
        $user_id = (int) $user['user_id'];
        $hash = (string) $user['password'];
        if(password_verify($password,$hash)){
            $_SESSION['user_id']=$user_id;
            $array_devolver['redirect'] ='http://192.168.64.2/webs/login_system/admin.php';
        }else{
            $array_devolver['error']="Los datos no son validos.";
        }

    }else{
      $array_devolver['error']="No tienes cuenta. <a href='http://192.168.64.2/webs/login_system/registro.php'>Nuevo cuenta</a>";
    }

    echo json_encode($array_devolver);

}else{
    exit("Fuera de aquí");
}


?>