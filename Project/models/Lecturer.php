<?php
/**
 * Model Lecturer
 * Mengelola data Dosen (Lecturers)
 */

require_once "DB.php";

class Lecturer extends DB {
    function getLecturers() {
        $query = "SELECT lecturers.*, departments.name AS department_name, departments.code AS department_code 
                  FROM lecturers 
                  LEFT JOIN departments ON lecturers.department_id = departments.id 
                  ORDER BY lecturers.id ASC";
        return $this->execute($query);
    }

    function getLecturerById($id) {
        $id = intval($id);
        $query = "SELECT * FROM lecturers WHERE id = $id";
        return $this->execute($query);
    }

    function addLecturer($data) {
        $name = addslashes($data['name']);
        $nidn = addslashes($data['nidn']);
        $phone = addslashes($data['phone']);
        $join_date = addslashes($data['join_date']);
        $department_id = empty($data['department_id']) ? "NULL" : intval($data['department_id']);

        $query = "INSERT INTO lecturers (name, nidn, phone, join_date, department_id) 
                  VALUES ('$name', '$nidn', '$phone', '$join_date', $department_id)";
        return $this->execute($query);
    }

    function updateLecturer($id, $data) {
        $id = intval($id);
        $name = addslashes($data['name']);
        $nidn = addslashes($data['nidn']);
        $phone = addslashes($data['phone']);
        $join_date = addslashes($data['join_date']);
        $department_id = empty($data['department_id']) ? "NULL" : intval($data['department_id']);

        $query = "UPDATE lecturers SET 
                    name = '$name', 
                    nidn = '$nidn', 
                    phone = '$phone', 
                    join_date = '$join_date', 
                    department_id = $department_id 
                  WHERE id = $id";
        return $this->execute($query);
    }

    function deleteLecturer($id) {
        $id = intval($id);
        $query = "DELETE FROM lecturers WHERE id = $id";
        return $this->execute($query);
    }
}
?>
