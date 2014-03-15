<?php
class ContactoDAO {

    private $table_name;

    public function __construct(){
        global $wpdb;
        $this->table_name = $wpdb->prefix . 'contacto';
    }

    public function getTableName(){ 
        return $this->table_name;
    }

    public function getAll(){
        global $wpdb;
        //echo "SELECT * FROM $this->table_name $where ORDER BY r_total DESC $limite;";
        return $wpdb->get_results("SELECT * FROM $this->table_name WHERE borrado = 0");
    }

    public function getTotalPages($ppp=10){
        global $wpdb;
        $res     = $wpdb->get_results("SELECT COUNT(id) AS Total FROM $this->table_name WHERE borrado = 0  ");

        // var_dump($res[0]->Total);

        $paginas = ceil((int)$res[0]->Total / $ppp);
        return $paginas;
    }

    public function existe($email){
        global $wpdb;
        $obj = $wpdb->get_var("SELECT COUNT(*) FROM $this->table_name WHERE email = '$email'");
        if(intval($obj)):
            return TRUE;
        else:
            return FALSE;
        endif;
    }

    public function borrar($id, $valor = 1){
        global $wpdb;
        return $wpdb->query($wpdb->prepare("UPDATE $this->table_name SET borrado = %s WHERE id = '%d'", $valor, $id) );
    }

    public function insertar($datos = array()){
		global $wpdb;
		$wpdb->show_errors();
        if (empty($datos)):
            return null;
        endif;
        $datos['fechacreacion'] = current_time('mysql');
		$datos['borrado'] = 0;
		//var_dump($datos);
		//echo $this->table_name;
        $filas = $wpdb->insert($this->table_name, $datos);
		//$wpdb->print_error();
        return $filas;
    }

}

?>