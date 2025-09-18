<?php
require_once "Database.php";

class ExcuseLetter extends Database {
    private $table = "excuse_letters";

    public function submitLetter($student_id, $letter_content, $attachment_path) {
        $query = "INSERT INTO {$this->table} (student_id, letter_content, attachment_path, submission_date) 
                  VALUES (?, ?, ?, NOW())";
        return $this->create($query, [$student_id, $letter_content, $attachment_path]);
    }

    public function getLetters() {
        $query = "SELECT el.id, u.name, c.course_name, s.year_level, 
                         el.letter_content, el.attachment_path, el.submission_date, el.status
                  FROM {$this->table} el
                  JOIN students s ON el.student_id = s.id
                  JOIN users u ON s.user_id = u.id
                  JOIN courses c ON s.course_id = c.id
                  ORDER BY el.submission_date DESC";
        return $this->read($query);
    }

    public function getLettersByStudent($student_id) {
        $query = "SELECT * FROM {$this->table} WHERE student_id = ? ORDER BY submission_date DESC";
        return $this->read($query, [$student_id]);
    }

    public function updateLetterStatus($id, $status) {
        $query = "UPDATE {$this->table} SET status = ? WHERE id = ?";
        return $this->update($query, [$status, $id]);
    }

    public function filterLettersByCourse($course_id) {
        $query = "SELECT el.id, u.name, c.course_name, s.year_level, 
                         el.letter_content, el.attachment_path, el.submission_date, el.status
                  FROM {$this->table} el
                  JOIN students s ON el.student_id = s.id
                  JOIN users u ON s.user_id = u.id
                  JOIN courses c ON s.course_id = c.id
                  WHERE c.id = ?
                  ORDER BY el.submission_date DESC";
        return $this->read($query, [$course_id]);
    }
}
