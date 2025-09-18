<?php
require_once "Database.php";

class Course extends Database {
    private $table = "courses";

    // adding a new course
    public function addCourse($course_name) {
        $query = "INSERT INTO $this->table (course_name) VALUES (?)";
        return $this->create($query, [$course_name]);
    }

    // get all courses
    public function getCourses() {
        $query = "SELECT * FROM $this->table ORDER BY course_name ASC";
        return $this->read($query);
    }

    // getting the course by ID
    public function getCourseById($id) {
        $query = "SELECT * FROM $this->table WHERE id = ?";
        $result = $this->read($query, [$id]);
        return $result ? $result[0] : null;
    }

    // updating a course
    public function updateCourse($id, $course_name) {
        $query = "UPDATE $this->table SET course_name = ? WHERE id = ?";
        return $this->update($query, [$course_name, $id]);
    }

    // deleting a course
    public function deleteCourse($id) {
        $query = "DELETE FROM $this->table WHERE id = ?";
        return $this->delete($query, [$id]);
    }
}
