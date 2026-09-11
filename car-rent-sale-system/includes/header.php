<?php require_once __DIR__ . '/functions.php'; $flash = get_flash(); ?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title><?= isset($pageTitle) ? e($pageTitle) : 'JIBO-Car Rental'; ?></title>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
        <link rel="stylesheet" href="/car-rent-sale-system/assets/css/style.css">
    </head>
    <body>
        <?php include __DIR__ . '/navbar.php'; ?>
        <?php if($flash): ?>
            <div class="container mt-3">
                <div class="alert alert-<?= e($flash['type']); ?> alert-dismissible fade show" role="alert">
                    <?= e($flash['message']); ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            </div>
        <?php endif; ?>
