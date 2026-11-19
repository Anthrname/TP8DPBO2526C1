<?php
/**
 * Model Department
 * Mengelola data master Program Studi / Departemen
 */

require_once "DB.php";

class Department extends DB {
    function getDepartments() {
        $query = "SELECT departments.*, COUNT(lecturers.id) AS total_lecturers 
                  FROM departments 
                  LEFT JOIN lecturers ON departments.id = lecturers.department_id 
                  GROUP BY departments.id 
                  ORDER BY departments.id ASC";
        return $this->execute($query);
    }

    function getDepartmentById($id) {
        $id = intval($id);
        $query = "SELECT * FROM departments WHERE id = $id";
        return $this->execute($query);
    }

    function addDepartment($data) {
        $code = addslashes($data['code']);
        $name = addslashes($data['name']);
        $faculty = addslashes($data['faculty']);

        $query = "INSERT INTO departments (code, name, faculty) 
                  VALUES ('$code', '$name', '$faculty')";
        return $this->execute($query);
    }

    function updateDepartment($id, $data) {
        $id = intval($id);
        $code = addslashes($data['code']);
        $name = addslashes($data['name']);
        $faculty = addslashes($data['faculty']);

        $query = "UPDATE departments SET 
                    code = '$code', 
                    name = '$name', 
                    faculty = '$faculty' 
                  WHERE id = $id";
        return $this->execute($query);
    }

    function deleteDepartment($id) {
        $id = intval($id);
        $query = "DELETE FROM departments WHERE id = $id";
        return $this->execute($query);
    }
}
?>
