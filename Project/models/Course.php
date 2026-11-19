<?php
/**
 * Model Course
 * Mengelola data Mata Kuliah (Courses)
 */

require_once "DB.php";

class Course extends DB {
    function getCourses() {
        $query = "SELECT courses.*, lecturers.name AS lecturer_name, departments.name AS department_name 
                  FROM courses 
                  LEFT JOIN lecturers ON courses.lecturer_id = lecturers.id 
                  LEFT JOIN departments ON lecturers.department_id = departments.id 
                  ORDER BY courses.id ASC";
        return $this->execute($query);
    }

    function getCourseById($id) {
        $id = intval($id);
        $query = "SELECT * FROM courses WHERE id = $id";
        return $this->execute($query);
    }

    function addCourse($data) {
        $code = addslashes($data['code']);
        $name = addslashes($data['name']);
        $credits = intval($data['credits']);
        $semester = intval($data['semester']);
        $lecturer_id = empty($data['lecturer_id']) ? "NULL" : intval($data['lecturer_id']);

        $query = "INSERT INTO courses (code, name, credits, semester, lecturer_id) 
                  VALUES ('$code', '$name', $credits, $semester, $lecturer_id)";
        return $this->execute($query);
    }

    function updateCourse($id, $data) {
        $id = intval($id);
        $code = addslashes($data['code']);
        $name = addslashes($data['name']);
        $credits = intval($data['credits']);
        $semester = intval($data['semester']);
        $lecturer_id = empty($data['lecturer_id']) ? "NULL" : intval($data['lecturer_id']);

        $query = "UPDATE courses SET 
                    code = '$code', 
                    name = '$name', 
                    credits = $credits, 
                    semester = $semester, 
                    lecturer_id = $lecturer_id 
                  WHERE id = $id";
        return $this->execute($query);
    }

    function deleteCourse($id) {
        $id = intval($id);
        $query = "DELETE FROM courses WHERE id = $id";
        return $this->execute($query);
    }
}
?>
