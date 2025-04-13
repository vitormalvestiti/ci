<?php
/**
 * @property CI_DB_mysqli_driver $db
 */
class Test_db extends CI_Controller {
    public function index() {
        $this->load->database();
        if ($this->db->conn_id) {
            echo "cConectado";
        } else {
            echo "Falha";
        }
    }
}
