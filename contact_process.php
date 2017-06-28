<?php
    // Aqui estoy usando idiorm y paris la documentacion para cada uno la listo acontinuacion
    // http://j4mie.github.io/idiormandparis/
    // http://idiorm.readthedocs.io/en/latest/
    // http://paris.readthedocs.io

    require_once __DIR__ . '/vendor/autoload.php';

    ORM::configure([
        'connection_string' => 'mysql:host=localhost;dbname=motozone_encuesta',
        'username' => 'root', //'username' => 'motozone_encuesta',
        'password' => '' //'password' => 'Webmaster2017#@'
    ]);
    
    /**
    * @property int $id
    * @property string $nombre
    * @property int $opcion
    */
   class Encuestamotor extends Model {
   }

    /**
     * Las siguientes son todas diferentes maneras de hacer los mismo con idiorm/paris
     * $allData = ORM::for_table('encuestamotor')->find_many(); // usando directamente idiorm
     * $allData = Model::factory('Encuestamotor')->find_many(); // usando paris
     */
    //$allData = Encuestamotor::find_array();
    //var_dump($allData);
    
    if(filter_input(INPUT_POST, 'name') && filter_input(INPUT_POST, 'opcion')){
        
        // Start a transaction
        ORM::get_db()->beginTransaction();
        try {
            $opinion = Encuestamotor::create();
            $opinion->nombre = filter_input(INPUT_POST, 'name');
            $opinion->opcion = filter_input(INPUT_POST, 'opcion');

            if( $opinion->save() ){
                //header('Content-Type: application/json');
                echo 'La opinion se ha guardado correctamente con el siguiente id: '.$opinion->id();
                // Commit a transaction
                ORM::get_db()->commit();
            }

        } catch (\PDOException $e) { 
            header('HTTP/1.1 500 Internal Server Booboo');
            header('Content-Type: application/json; charset=UTF-8');
            die( json_encode($e->getMessage()) );
            // Roll back a transaction
            ORM::get_db()->rollBack();
        } catch (Exception $e) {
            header('HTTP/1.1 500 Internal Server Booboo');
            header('Content-Type: application/json; charset=UTF-8');
            die( json_encode($e->getMessage()) );
            // Roll back a transaction
            ORM::get_db()->rollBack();
        }
        
    }else{
        header('HTTP/1.1 500 Internal Server Booboo');
        header('Content-Type: application/json; charset=UTF-8');
        die(json_encode('Ingrese su nombre y una opinion por favor'));
    }
    

