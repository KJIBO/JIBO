<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
function e($value) {
    return htmlspecialchars((string)$value, ENT_QUOTES, 'UTF-8');
}
function redirect($path) {
    header("Location: $path");
    exit;
}
function flash($key, $message = null) {
    if ($message !== null) {
        $_SESSION['flash'][$key] = $message;
        return;
    }
    if (isset($_SESSION['flash'][$key])) {
        $msg = $_SESSION['flash'][$key];
        unset($_SESSION['flash'][$key]);
        return $msg;
    }
    return null;
}
function current_user_role() {
    return $_SESSION['role'] ?? null;
}
function is_logged_in($role = null) {
    if (!isset($_SESSION['user_id'], $_SESSION['role'])) return false;
    return $role ? $_SESSION['role'] === $role : true;
}
function require_login($role = null) {
    if (!is_logged_in($role)) {
        flash('error', 'Please login first.');
        redirect(BASE_URL . '/auth/login.php');
    }
}
function upload_file($field, $targetDir, $allowed = ['pdf','doc','docx']) {
    if (!isset($_FILES[$field]) || $_FILES[$field]['error'] !== UPLOAD_ERR_OK) return null;
    $name = $_FILES[$field]['name'];
    $tmp  = $_FILES[$field]['tmp_name'];
    $ext  = strtolower(pathinfo($name, PATHINFO_EXTENSION));
    if (!in_array($ext, $allowed, true)) {
        return null;
    }
    if (!is_dir($targetDir)) mkdir($targetDir, 0777, true);
    $new = uniqid('file_', true) . '.' . $ext;
    move_uploaded_file($tmp, $targetDir . '/' . $new);
    return $new;
}
function upload_image($field, $targetDir) {
    return upload_file($field, $targetDir, ['jpg','jpeg','png','webp']);
}
function password_plain_hint() { return 'admin123'; }
function count_row($pdo, $table, $where = '1=1') {
    return (int)$pdo->query("SELECT COUNT(*) FROM {$table} WHERE {$where}")->fetchColumn();
}
function app_status_badge($status) {
    $map = [
        'pending' => 'warning',
        'shortlisted' => 'info',
        'accepted' => 'success',
        'rejected' => 'danger',
        'draft' => 'secondary',
        'active' => 'success',
        'closed' => 'dark'
    ];
    $class = $map[$status] ?? 'secondary';
    return '<span class="badge bg-' . $class . '">' . e(ucfirst($status)) . '</span>';
}
function nav_active($needle) {
    $uri = $_SERVER['REQUEST_URI'] ?? '';
    return str_contains($uri, $needle) ? 'active' : '';
}
?>
