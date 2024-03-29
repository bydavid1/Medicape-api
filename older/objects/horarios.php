<?php
class Horario{

    private $conn;
    private $table_name = "horarios_citas";


    public $Idhorario;
    public $tiempo_cita;
    public $numero_cita;
    public $hora_inicio;
    public $hora_final;
    public $idDoc;
    public $fecha;



    public function __construct($db)
    {
        $this->conn = $db;
    }


    function read()
    {
    // select all query
    $query = "SELECT
                *
            FROM
                " . $this->table_name;

    $stmt = $this->conn->prepare($query);

    $stmt->execute();

    return $stmt;
    }


    function create()
    {

    $query = "INSERT INTO " . $this->table_name . " 
            SET  
            tiempo_cita=:tiempo_cita, 
            numero_cita=:numero_cita, 
            hora_inicio=:hora_inicio, 
            hora_final=:hora_final, 
            idDoc=:idDoc";

    echo $query;

    $stmt = $this->conn->prepare($query);


    $stmt->bindParam(":tiempo_cita", $this->tiempo_cita);
    $stmt->bindParam(":numero_cita", $this->numero_cita);
    $stmt->bindParam(":hora_inicio", $this->hora_inicio);
    $stmt->bindParam(":hora_final", $this->hora_final);
    $stmt->bindParam(":idDoc", $this->idDoc);

    if($stmt->execute())
    {
        return true;
    }

    return false;
    }


    function update()
    {

        $query = "UPDATE
                " . $this->table_name . "
            SET
            tiempo_cita=:tiempo_cita, 
            numero_cita=:numero_cita, 
            hora_inicio=:hora_inicio, 
            hora_final=:hora_final, 
            idDoc=:idDoc
            WHERE
            Idhorario=:Idhorario";


    $stmt = $this->conn->prepare($query);


    $stmt->bindParam(":tiempo_cita", $this->tiempo_cita);
    $stmt->bindParam(":numero_cita", $this->numero_cita);
    $stmt->bindParam(":hora_inicio", $this->hora_inicio);
    $stmt->bindParam(":hora_final", $this->hora_final);
    $stmt->bindParam(":idDoc", $this->idDoc);
    $stmt->bindParam(":Idhorario", $this->Idhorario);  

    if($stmt->execute())
    {
        return true;
    }
    return false;
    }


    function delete()
    {


    $query = "DELETE FROM " . $this->table_name . " WHERE Idhorario = ?";


    $stmt = $this->conn->prepare($query);


    $stmt->bindParam(1, $this->Idhorario);


    if($stmt->execute())
    {
        return true;
    }
    return false;

    }


    function readOne()
    {

        $query = "SELECT
                    *
                FROM
                    " . $this->table_name ." 
                WHERE
                Idhorario = ?";

        $stmt = $this->conn->prepare( $query );

        $stmt->bindParam(1, $this->Idhorario);

        $stmt->execute();

        return $stmt;
        
    }

    function readById()
    {

        $query = "SELECT
            Idhorario, tiempo_cita, numero_cita, hora_inicio, DATE_FORMAT(hora_final, \"%H:%i\") hora_final, idDoc
                FROM
                    " . $this->table_name ." 
                WHERE
                idDoc = ?";

        $stmt = $this->conn->prepare( $query );

        $stmt->bindParam(1, $this->idDoc);

        $stmt->execute();
        
        return $stmt;
        
    }

    function readByDate()
    {

        $query = "SELECT
            Idhorario, tiempo_cita, numero_cita, hora_inicio, DATE_FORMAT(hora_final, \"%H:%i\") hora_final, idDoc
                FROM
                    " . $this->table_name ." 
                WHERE
                fecha = ? AND idDoc = ?";

        $stmt = $this->conn->prepare( $query );

        $stmt->bindParam(1, $this->fecha);
        $stmt->bindParam(2, $this->idDoc);

        $stmt->execute();
        
        return $stmt;
        
    }

}