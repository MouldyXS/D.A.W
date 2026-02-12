<?php

class Usuario {
    public $id;
    public $nombre;
    public $email;
    public $telefono;
    public $created_at;
    public $updated_at;


    public function __construct($nombre = '', $email = '', $telefono = '', $id = null) {
        $this->id = $id;
        $this->nombre = $nombre;
        $this->email = $email;
        $this->telefono = $telefono;
    }


    public function toArray() {
        return [
            'id' => $this->id,
            'nombre' => $this->nombre,
            'email' => $this->email,
            'telefono' => $this->telefono,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at
        ];
    }
}
?>
