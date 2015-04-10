<?php
class ModelModuleZipcode extends Model {
    public function checkZipcode($zipcode) {
        if(trim($zipcode) != '') {
            $result = $this->db->query("SELECT id FROM " . DB_PREFIX . "zipcodes WHERE zipcode = '".$zipcode."' AND status = 1");
            if($result->num_rows) {
                return true;
            }
        }
        return false;
    }
}