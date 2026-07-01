<?php include 'config/database.php'; ?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=yes, viewport-fit=cover">
    <meta name="theme-color" content="#5c3a2e">
    <title>Daftar Member • Teras Coklat</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="assets/css/style.css">
    <style>
        body {
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            padding: 20px;
            margin: 0;
        }
        
        .container {
            padding: 0;
            max-width: 500px;
            width: 100%;
        }
        
        @media (max-width: 480px) {
            body {
                padding: 12px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12">
                <div class="checkin-card">
                    <div class="checkin-header">
                        <div class="chocolate-icon">
                            🍫✨🎉
                        </div>
                        <h4 class="fw-bold mb-0">DAFTAR MEMBER</h4>
                        <p class="mb-0 mt-1 small">Jadi member & kumpulkan poin!</p>
                    </div>
                    <div class="p-3 p-md-4">
                        <?php 
                        $status = $_GET['status'] ?? '';
                        if($status == 'success'): ?>
                            <div class="alert alert-premium alert-success-premium mb-4">
                                <i class="fas fa-check-circle me-2"></i>
                                <strong>✓ Pendaftaran Berhasil!</strong> Yuk scan QR untuk klaim poin pertama.
                            </div>
                        <?php endif; ?>
                        
                        <?php if($status == 'exists'): ?>
                            <div class="alert alert-premium alert-warning-premium mb-4">
                                <i class="fas fa-exclamation-triangle me-2"></i>
                                <strong>⚠ Nomor sudah terdaftar!</strong> Langsung scan QR untuk klaim poin.
                            </div>
                        <?php endif; ?>
                        
                        <?php if($status == 'error'): ?>
                            <div class="alert alert-premium alert-danger-premium mb-4">
                                <i class="fas fa-times-circle me-2"></i>
                                <strong>⚠ Gagal mendaftar!</strong> Coba lagi ya.
                            </div>
                        <?php endif; ?>

                        <form action="includes/proses.php" method="POST">
                            <div class="mb-3">
                                <label class="input-label">
                                    <i class="fas fa-user me-2"></i> Nama Lengkap
                                </label>
                                <input type="text" 
                                       name="nama" 
                                       class="form-control input-premium" 
                                       required 
                                       placeholder="Contoh: Ahmad Santoso">
                            </div>
                            <div class="mb-4">
                                <label class="input-label">
                                    <i class="fas fa-mobile-alt me-2"></i> Nomor WhatsApp
                                </label>
                                <input type="number" 
                                       name="whatsapp" 
                                       class="form-control input-premium" 
                                       required 
                                       placeholder="Contoh: 81234567890">
                                <small class="text-muted d-block mt-2">
                                    <i class="fas fa-info-circle me-1"></i> Pakai nomor ini setiap klaim poin
                                </small>
                            </div>
                            <button type="submit" name="register_member" class="btn-coklat py-3">
                                <i class="fas fa-user-plus me-2"></i> DAFTAR SEKARANG
                            </button>
                        </form>
                        
                        <hr class="my-3" style="background: linear-gradient(90deg, transparent, #e6b422, transparent); height: 1px; border: none;">
                        
                        <div class="text-center">
                            <p class="small text-muted mb-0">
                                Sudah punya akun? 
                                <a href="checkin.php?token=<?= $_GET['token'] ?? '' ?>" class="text-decoration-none fw-semibold" style="color: #e6b422;">
                                    <i class="fas fa-qrcode"></i> Langsung klaim poin
                                </a>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>