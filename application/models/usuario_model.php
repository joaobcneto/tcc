<?php

class Usuario_model extends CI_Model {

    function adicionar($dados) {
		return $this->db->insert('usuario', $dados);
    }
    
    function buscaTodos() {

        $this->db->select('nome, email');
        $this->db->from('usuario');
        $query = $this->db->get();
        return $query->result();
    }

    function buscaPorEmail($email) {

        $this->db->select('*');
        $this->db->from('usuario');
        $this->db->where('email = ' . "'" . $email . "'");
        $this->db->limit(1);

        $query = $this->db->get();

        if ($query->num_rows() == 1) {
            return $query->result();
        } else {
            return false;
        }
    }
}
