<?php

require_once __DIR__ . '/vendor/autoload.php';
ORM::configure([
    'connection_string' => 'mysql:host=localhost;dbname=motozone_encuesta',
    'username' => 'motozone_encuesta', //'username' => 'motozone_encuesta',
    'password' => 'Webmaster2017#@' //'password' => 'Webmaster2017#@'
]);

/**
 * @property int $id
 * @property string $nombre
 * @property int $opcion
 */
class Encuestamotor extends Model {
    
}

// Start a transaction
ORM::get_db()->beginTransaction();
try {
    header('Content-Type: application/json; charset=UTF-8');
    $allVotes = Encuestamotor::raw_query(''
            . 'SELECT em.opcion, COUNT(em.opcion) as votos '
            . 'FROM encuestamotor em '
            . 'GROUP BY em.opcion '
    )->find_many();
    
    // el array map funciona parecido al _.map de underscore
    $newData = array_map(function ($val){
        return (int)$val->votos;
    }, $allVotes);
    

    echo json_encode([
        'graph'    => $newData,
        'votantes' => [
            1 => Encuestamotor::where('opcion', 1)->find_array(),
            2 => Encuestamotor::where('opcion', 2)->find_array(),
            3 => Encuestamotor::where('opcion', 3)->find_array(),
            4 => Encuestamotor::where('opcion', 4)->find_array()
        ]
    ]);
    
} catch (\PDOException $e) {
    header('HTTP/1.1 500 Internal Server Booboo');
    header('Content-Type: application/json; charset=UTF-8');
    die(json_encode($e->getMessage()));
    // Roll back a transaction
    ORM::get_db()->rollBack();
} catch (Exception $e) {
    header('HTTP/1.1 500 Internal Server Booboo');
    header('Content-Type: application/json; charset=UTF-8');
    die(json_encode($e->getMessage()));
    // Roll back a transaction
    ORM::get_db()->rollBack();
}
