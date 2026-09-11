<?php
require_once __DIR__ . '/../config/db.php';
function e(string $value): string { return htmlspecialchars($value, ENT_QUOTES, 'UTF-8'); }
function redirect(string $url): void { header('Location: ' . $url); exit; }
function set_flash(string $type, string $message): void { $_SESSION['flash'] = ['type' => $type, 'message' => $message]; }
function get_flash(): ?array { if (!isset($_SESSION['flash'])) return null; $f=$_SESSION['flash']; unset($_SESSION['flash']); return $f; }
function is_admin_logged_in(): bool { return !empty($_SESSION['admin_id']); }
function require_admin(): void { if (!is_admin_logged_in()) redirect('/car-rent-sale-system/auth/login.php'); }
function count_rows(string $table, ?string $where = null): int { $sql="SELECT COUNT(*) AS total FROM {$table}" . ($where ? " WHERE {$where}" : ''); return (int) db()->query($sql)->fetch()['total']; }
function fetch_all_cars(?string $type = null, bool $featuredOnly = false): array {
    $conditions=[];
    if ($type==='rental') $conditions[]="car_type IN ('rental','both')";
    elseif ($type==='sale') $conditions[]="car_type IN ('sale','both')";
    if ($featuredOnly) $conditions[]='is_featured = 1';
    $conditions[]="status = 'available'";
    $sql='SELECT * FROM cars WHERE '.implode(' AND ', $conditions).' ORDER BY id DESC';
    return db()->query($sql)->fetchAll();
}
function find_car(int $id): ?array { $stmt=db()->prepare('SELECT * FROM cars WHERE id=? LIMIT 1'); $stmt->execute([$id]); return $stmt->fetch() ?: null; }
function booking_total(string $pickup, string $return, float $dailyRate): array { $s=new DateTime($pickup); $e=new DateTime($return); $days=max(1,(int)$s->diff($e)->days); return ['days'=>$days,'total'=>$days*$dailyRate]; }
