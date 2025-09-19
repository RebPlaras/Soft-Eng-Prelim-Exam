<?php

class Subcategory extends Database {

    public function createSubcategory($category_id, $subcategory_name) {
        $sql = "INSERT INTO subcategories (category_id, subcategory_name) VALUES (?, ?)";
        return $this->executeNonQuery($sql, [$category_id, $subcategory_name]);
    }

    public function getSubcategories() {
        $sql = "SELECT * FROM subcategories JOIN categories ON subcategories.category_id = categories.category_id ORDER BY subcategories.date_added DESC";
        return $this->executeQuery($sql);
    }

    public function getSubcategory($subcategory_id) {
        $sql = "SELECT * FROM subcategories WHERE subcategory_id = ?";
        return $this->executeQuerySingle($sql, [$subcategory_id]);
    }

    public function getSubcategoriesByCategory($category_id) {
        $sql = "SELECT * FROM subcategories WHERE category_id = ? ORDER BY date_added DESC";
        return $this->executeQuery($sql, [$category_id]);
    }

    public function updateSubcategory($subcategory_name, $subcategory_id) {
        $sql = "UPDATE subcategories SET subcategory_name = ? WHERE subcategory_id = ?";
        return $this->executeNonQuery($sql, [$subcategory_name, $subcategory_id]);
    }

    public function deleteSubcategory($subcategory_id) {
        $sql = "DELETE FROM subcategories WHERE subcategory_id = ?";
        return $this->executeNonQuery($sql, [$subcategory_id]);
    }
}
?>