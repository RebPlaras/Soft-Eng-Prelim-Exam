<?php
require_once "Database.php";

class Student extends Database {
    private $table = "students";

    public function addStudent($user_id, $course_id, $year_level) {
        $query = "INSERT INTO $this->table (user_id, course_id, year_level) VALUES (?, ?, ?)";
        return $this->create($query, [$user_id, $course_id, $year_level]);
    }

    public function getStudents() {
        $query = "SELECT s.id, u.name, u.email, c.course_name, s.year_level
                  FROM $this->table s
                  JOIN users u ON s.user_id = u.id
                  JOIN courses c ON s.course_id = c.id
                  ORDER BY u.name ASC";
        return $this->read($query);
    }

    public function getStudentById($id) {
        $query = "SELECT s.id, u.name, u.email, c.course_name, s.year_level, s.course_id, s.user_id
                  FROM $this->table s
                  JOIN users u ON s.user_id = u.id
                  JOIN courses c ON s.course_id = c.id
                  WHERE s.id = ?";
        $result = $this->read($query, [$id]);
        return $result ? $result[0] : null;
    }

    public function updateStudent($id, $course_id, $year_level) {
        $query = "UPDATE $this->table SET course_id = ?, year_level = ? WHERE id = ?";
        return $this->update($query, [$course_id, $year_level, $id]);
    }

    public function deleteStudent($id) {
        $query = "DELETE FROM $this->table WHERE id = ?";
        return $this->delete($query, [$id]);
    }

    public function getStudentByUserId($user_id) {
        $query = "SELECT * FROM $this->table WHERE user_id = ?";
        $result = $this->read($query, [$user_id]);
        return $result ? $result[0] : null;
    }

}
