<?php
require_once "Database.php";

class Attendance extends Database {
    private $table = "attendance";

    // mark attendance (course_id auto-determined via student_id)
    public function markAttendance($student_id, $status, $is_late = "No") {
        $query = "INSERT INTO {$this->table} (student_id, status, is_late, date) 
                  VALUES (?, ?, ?, NOW())";
        return $this->create($query, [$student_id, $status, $is_late]);
    }

    // get all attendance records (admin use)
    public function getAttendance() {
        $query = "SELECT a.id, u.name, c.course_name, s.year_level, 
                         a.status, a.is_late, a.date
                  FROM {$this->table} a
                  JOIN students s ON a.student_id = s.id
                  JOIN users u ON s.user_id = u.id
                  JOIN courses c ON s.course_id = c.id
                  ORDER BY a.date DESC";
        return $this->read($query);
    }

    // get attendance for a single student (student use)
    public function getAttendanceByStudent($student_id) {
        $query = "SELECT a.id, a.status, a.is_late, a.date
                  FROM {$this->table} a
                  WHERE a.student_id = ?
                  ORDER BY a.date DESC";
        return $this->read($query, [$student_id]);
    }

    // filter by course + year level (admin use)
    public function filterAttendance($course_id, $year_level) {
        $query = "SELECT a.id, u.name, c.course_name, s.year_level, 
                         a.status, a.is_late, a.date
                  FROM {$this->table} a
                  JOIN students s ON a.student_id = s.id
                  JOIN users u ON s.user_id = u.id
                  JOIN courses c ON s.course_id = c.id
                  WHERE c.id = ? AND s.year_level = ?
                  ORDER BY a.date DESC";
        return $this->read($query, [$course_id, $year_level]);
    }
}
