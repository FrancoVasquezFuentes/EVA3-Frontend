<?php

class Controlador{
    private $lista;

    public function __construct()
    {
        $this->lista = [];
    }

    public function getAll()
    {
        $con = new Conexion();
        $sql = "SELECT id, nombre, texto, texto_adicional, activo FROM info_contacto;";
        $rs = mysqli_query($con->getConnection(), $sql);
        if ($rs) {
            while ($tupla = mysqli_fetch_assoc($rs)) {
                $tupla['activo'] = $tupla['activo'] == 1 ? true : false;
                array_push($this->lista, $tupla);
            }
            mysqli_free_result($rs);
        }
        $con->closeConnection();
        return $this->lista;
    }

    public function postNuevo($_nuevoObjeto)
    {
        $con = new Conexion();
        
        $id = count($this->getAll()) + 1;
        $sql = "INSERT INTO info_contacto (id, nombre, texto, texto_adicional, activo) VALUES ($id, '$_nuevoObjeto->nombre', '$_nuevoObjeto->texto', '$_nuevoObjeto->texto_adicional', true)";
        
        $rs = [];
        try {
            $rs = mysqli_query($con->getConnection(), $sql);
        } catch (\Throwable $th) {
            $rs = null;
        }
        
        $con->closeConnection();
        
        if ($rs) {
            return true;
        }
        return null;
    }

    public function patchEncenderApagar($_id, $_accion)
    {
        $con = new Conexion();
        $activo = $_accion === 'encender' ? 1 : 0;
        $sql = "UPDATE info_contacto SET activo = $_accion WHERE id = $_id;";
        
        $rs = [];
        try {
            $rs = mysqli_query($con->getConnection(), $sql);
        } catch (\Throwable $th) {
            $rs = null;
        }
        
        $con->closeConnection();
        
        if ($rs) {
            return true;
        }
        return null;
    }

    public function putNombreById($_nuevo, $_id)
    {
        $con = new Conexion();
        $sql = "UPDATE info_contacto SET nombre = '$_nuevo' WHERE id = $_id;";
        $rs = false;
        try {
            $rs = mysqli_query($con->getConnection(), $sql);
        } catch (\Throwable $th) {
            $rs = false;
        }
        $con->closeConnection();
        if ($rs) {
            return true;
        }
        return null;
    }

    public function putIconoById($_nuevo, $_id)
    {
        $con = new Conexion();
        $sql = "UPDATE info_contacto SET icono = '$_nuevo' WHERE id = $_id;";
        $rs = false;
        try {
            $rs = mysqli_query($con->getConnection(), $sql);
        } catch (\Throwable $th) {
            $rs = false;
        }
        $con->closeConnection();
        if ($rs) {
            return true;
        }
        return null;
    }

    public function putTextoById($_nuevo, $_id)
    {
        $con = new Conexion();
        $sql = "UPDATE info_contacto SET texto = '$_nuevo' WHERE id = $_id;";
        // echo $sql;
        $rs = false;
        try {
            $rs = mysqli_query($con->getConnection(), $sql);
        } catch (\Throwable $th) {
            $rs = false;
        }
        $con->closeConnection();
        if ($rs) {
            return true;
        }
        return null;
    }

    public function putTextoAdicionalById($_nuevo, $_id)
    {
        $con = new Conexion();
        $sql = "UPDATE info_contacto SET texto_adicional = '$_nuevo' WHERE id = $_id;";
        $rs = false;
        try {
            $rs = mysqli_query($con->getConnection(), $sql);
        } catch (\Throwable $th) {
            $rs = false;
        }
        $con->closeConnection();
        if ($rs) {
            return true;
        }
        return null;
    }

    public function deleteById($_id)
    {
        $con = new Conexion();
        $sql = "DELETE FROM info_contacto WHERE id = $_id;";
        
        $rs = [];
        try {
            $rs = mysqli_query($con->getConnection(), $sql);
        } catch (\Throwable $th) {
            $rs = null;
        }
        
        $con->closeConnection();
       
        if ($rs) {
            return true;
        }
        return null;
    }
}
?>