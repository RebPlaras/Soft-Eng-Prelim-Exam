<?php

class Category extends Database {

    public function createCategory($category_name) {
        $sql = "INSERT INTO categories (category_name) VALUES (?)";
        return $this->executeNonQuery($sql, [$category_name]);
    }

    public function getCategories() {
        $sql = "SELECT * FROM categories ORDER BY date_added DESC";
        return $this->executeQuery($sql);
    }

    public function getCategory($category_id) {
        $sql = "SELECT * FROM categories WHERE category_id = ?";
        return $this->executeQuerySingle($sql, [$category_id]);
    }

    public function updateCategory($category_name, $category_id) {
        $sql = "UPDATE categories SET category_name = ? WHERE category_id = ?";
        return $this->executeNonQuery($sql, [$category_name, $category_id]);
    }

    public function deleteCategory($category_id) {
        $sql = "DELETE FROM categories WHERE category_id = ?";
        return $this->executeNonQuery($sql, [$category_id]);
    }
}
?>