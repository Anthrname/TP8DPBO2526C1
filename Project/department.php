<?php
/**
 * Entry Point: Program Studi (Departments)
 * Menghubungkan HTTP Request dengan DepartmentController
 */

require_once "controllers/DepartmentController.php";

$departmentController = new DepartmentController();

if (isset($_POST['add'])) {
    $departmentController->add($_POST);
} else if (isset($_POST['update'])) {
    $id = $_POST['id'];
    $departmentController->update($id, $_POST);
} else if (isset($_GET['action'])) {
    $action = $_GET['action'];
    $id = $_GET['id'] ?? null;

    if ($action == 'edit' && $id) {
        $departmentController->edit($id);
    } else if ($action == 'delete' && $id) {
        $departmentController->delete($id);
    } else {
        $departmentController->index();
    }
} else {
    $departmentController->index();
}
?>
