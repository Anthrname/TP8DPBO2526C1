<?php
/**
 * View DepartmentView
 * Menangani rendering tampilan Program Studi / Departemen
 */

require_once "Template.php";

class DepartmentView {
    public function render($departments, $editData = null) {
        $template = new Template("templates/department.html");

        $template->replace("DATA_PAGE_TITLE", "Data Program Studi");
        $template->replace("DATA_NAV_LECTURER", "");
        $template->replace("DATA_NAV_DEPARTMENT", "active fw-bold text-white");
        $template->replace("DATA_NAV_COURSE", "");

        // Menentukan mode Form (Tambah / Edit)
        if ($editData != null) {
            $template->replace("DATA_FORM_TITLE", "Edit Program Studi");
            $template->replace("DATA_FORM_ACTION", "department.php");
            $template->replace("DATA_FORM_INPUT_ID", '<input type="hidden" name="id" value="' . htmlspecialchars($editData['id']) . '">');
            $template->replace("DATA_CODE_VALUE", htmlspecialchars($editData['code']));
            $template->replace("DATA_NAME_VALUE", htmlspecialchars($editData['name']));
            $template->replace("DATA_FACULTY_VALUE", htmlspecialchars($editData['faculty']));
            $template->replace("DATA_BUTTON_NAME", "update");
            $template->replace("DATA_BUTTON_TEXT", '<i class="bi bi-save me-1"></i> Simpan Perubahan');
            $template->replace("DATA_BUTTON_CANCEL", '<a href="department.php" class="btn btn-outline-secondary">Batal Edit</a>');
        } else {
            $template->replace("DATA_FORM_TITLE", "Tambah Prodi Baru");
            $template->replace("DATA_FORM_ACTION", "department.php");
            $template->replace("DATA_FORM_INPUT_ID", "");
            $template->replace("DATA_CODE_VALUE", "");
            $template->replace("DATA_NAME_VALUE", "");
            $template->replace("DATA_FACULTY_VALUE", "");
            $template->replace("DATA_BUTTON_NAME", "add");
            $template->replace("DATA_BUTTON_TEXT", '<i class="bi bi-plus-circle me-1"></i> Tambah Program Studi');
            $template->replace("DATA_BUTTON_CANCEL", "");
        }

        // Render Baris Tabel
        $tableContent = "";
        $count = 0;
        foreach ($departments as $row) {
            $count++;
            $lecturerBadge = '<span class="badge bg-secondary">' . ($row['total_lecturers'] ?? 0) . ' Dosen</span>';

            $tableContent .= '<tr>
                <td class="text-center fw-bold">' . $row['id'] . '</td>
                <td><span class="badge-dept fw-bold">' . htmlspecialchars($row['code']) . '</span></td>
                <td><span class="fw-bold text-dark">' . htmlspecialchars($row['name']) . '</span></td>
                <td>' . htmlspecialchars($row['faculty']) . '</td>
                <td class="text-center">' . $lecturerBadge . '</td>
                <td class="text-center">
                    <a href="department.php?action=edit&id=' . $row['id'] . '" class="btn btn-warning btn-action text-dark me-1" title="Edit">
                        <i class="bi bi-pencil-square"></i> Edit
                    </a>
                    <a href="department.php?action=delete&id=' . $row['id'] . '" class="btn btn-danger btn-action" onclick="return confirm(\'Perhatian: Menghapus program studi ini akan mengubah program studi dosen terkait menjadi belum ditentukan. Yakin ingin menghapus?\')" title="Hapus">
                        <i class="bi bi-trash-fill"></i> Hapus
                    </a>
                </td>
            </tr>' . "\n";
        }

        if ($count === 0) {
            $tableContent = '<tr><td colspan="6" class="text-center text-muted py-4">Belum ada data program studi tersimpan.</td></tr>';
        }

        $template->replace("DATA_TOTAL_COUNT", $count);
        $template->replace("DATA_TABLE_CONTENT", $tableContent);

        $template->write();
    }
}
?>
