<?php

class ModelSaleZipcode extends Model {

    public function getZipcodes($data = array()) {
        $sql = "SELECT * FROM " . DB_PREFIX . "zipcodes WHERE id != 0";

        $where_str = '';

        if (isset($data['filter_zipcode']) && trim($data['filter_zipcode']) != '') {
            $where_str .= " AND  zipcode LIKE '%" . $data['filter_zipcode'] . "%'";
        }
        if (isset($data['filter_status']) && trim($data['filter_status']) != '') {
            if (strtolower($data['filter_status']) == "enabled") {
                $where_str .= " AND status = 1";
            } else {
                $where_str .= " AND status = 0";
            }
        }
        $sql .= $where_str;

        $sql .= " ORDER BY timemodified desc ";
        if (isset($data['start']) || isset($data['limit'])) {
            if ($data['start'] < 0) {
                $data['start'] = 0;
            }

            if ($data['limit'] < 1) {
                $data['limit'] = 20;
            }

            $sql .= " LIMIT " . (int) $data['start'] . "," . (int) $data['limit'];
        }

        $query = $this->db->query($sql);

        return $query->rows;
    }

    public function getTotalZipcodes($data = array()) {
        $sql = "SELECT count(*) AS total FROM " . DB_PREFIX . "zipcodes WHERE id != 0";

        if (isset($data['filter_zipcode']) && trim($data['filter_zipcode']) != '') {
            $sql .= " AND zipcode LIKE '%" . $data['filter_zipcode'] . "%'";
        }
        if (isset($data['filter_status']) && trim($data['filter_status']) != '') {
            if (strtolower($data['filter_status']) == "enabled") {
                $sql .= " AND status = 1";
            } else {
                $sql .= " AND status = 0";
            }
        }

        $query = $this->db->query($sql);

        return $query->row['total'];
    }

    public function getZipcode($id) {
        $zc_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "zipcodes WHERE id = " . $id);

        if ($zc_query->num_rows) {
            return $zc_query->row;
        }
    }

    public function insertZipcode($data) {
        if (!isset($data['status'])) {
            $data['status'] = 0;
        } else {
            if ($data['status'] == 'on') {
                $data['status'] = 1;
            } else {
                $data['status'] = 0;
            }
        }
        $zc_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "zipcodes WHERE zipcode = '" . $data['zipcode'] . "'");
        if ($zc_query->num_rows) {
            return false;
        } else {
            $sql = "INSERT INTO " . DB_PREFIX . "zipcodes SET zipcode='" . $data['zipcode'] . "',status = " . $data['status'] . ",timecreated = " . time() . ",timemodified = " . time();
            $this->db->query($sql);
        }
        return true;
    }

    public function updateZipcode($data) {
        if (!isset($data['status'])) {
            $data['status'] = 0;
        } else {
            if ($data['status'] == 'on') {
                $data['status'] = 1;
            } else {
                $data['status'] = 0;
            }
        }

        $sql = "UPDATE " . DB_PREFIX . "zipcodes SET zipcode='" . $data['zipcode'] . "',status = " . $data['status'] . ", timemodified = " . time() . " WHERE id = " . $_POST['id'];
        $this->db->query($sql);
    }

    public function deleteZipcode($id) {
        $zc_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "zipcodes WHERE id = " . $id);
        if ($zc_query->num_rows) {
            $sql = "DELETE FROM " . DB_PREFIX . "zipcodes WHERE id = " . $id;
            $this->db->query($sql);
        }
    }

}
