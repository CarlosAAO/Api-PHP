<?php
    // Require composer autoloader
    require __DIR__ . '/vendor/autoload.php';
    require 'rb.php';
    // Create Router instance
    R::setup( 'mysql:host=localhost;dbname=aplicacion', 'root', '' );
    
    $router = new \Bramus\Router\Router();

    $router->options('.*', function(){
        header('Access-Control-Allow-Origin: *');
        header("Access-Control-Allow-Methods:GET, POST, PUT, DELETE, OPTIONS");
        header("Access-Control-Allow-Headers:Content-Type,Authorization,X-Requested-with");
        exit();
    });
    // Define routes
    // ...
    // This route handling function will only be executed when visiting http(s)://www.example.org/about
    $router->get('/', function() {
        $alumnos=R::find('alumnos');
        header('Access-Control-Allow-Origin: *');
        header("Content-Type: application/json");
        echo json_encode(R::exportAll($alumnos));
    });
    // Run it!

    $router->post('/', function(){
        $data = json_decode(file_get_contents('php://input'), true);    
  
        $alumno = R::dispense('alumnos');
        $alumno->nombres=$data['nombres'];
        $alumno->apellidos=$data['apellidos']; 
        $id= R::store($alumno);
        header('Access-Control-Allow-Origin: *');
        header("Content-Type: application/json");
        print_r($data);    
    });

    $router->delete( '/{id}',function( $id ) {
        $alumno = R::trash('alumnos',$id);
        header('Access-Control-Allow-Origin: *');
        header("Content-Type: application/json");
        print_r($alumno);
    });

    $router->run();

?>