<?php
/**
 * Entry Point: Dosen (Lecturers)
 * Menghubungkan HTTP Request dengan LecturerController
 */

require_once "controllers/LecturerController.php";

$lecturerController = new LecturerController();

if (isset($_POST['add'])) {
    $lecturerController->add($_POST);
} else if (isset($_POST['update'])) {
    $id = $_POST['id'];
    $lecturerController->update($id, $_POST);
} else if (isset($_GET['action'])) {
    $action = $_GET['action'];
    $id = $_GET['id'] ?? null;

    if ($action == 'edit' && $id) {
        $lecturerController->edit($id);
    } else if ($action == 'delete' && $id) {
        $lecturerController->delete($id);
    } else {
        $lecturerController->index();
    }
} else {
    $lecturerController->index();
}
?>
