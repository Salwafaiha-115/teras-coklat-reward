<?php 
include 'config/database.php'; 
session_start();

$status = isset($_GET['status']) ? $_GET['status'] : '';
$token = isset($_GET['token']) ? $_GET['token'] : '';
$step = isset($_GET['step']) ? $_GET['step'] : 'claim';
$wa_temp = isset($_GET['wa']) ? $_GET['wa'] : '';

// KALO ADA TOKEN DARI QR, SIMPAN KE SESSION JUGA
if(!empty($token)){
    $_SESSION['qr_token'] = $token;
    $_SESSION['qr_time'] = time();
}

// AMBIL TOKEN DARI SESSION (BIAR GA EXPIRED PAS PINDAH STEP)
$active_token = isset($_SESSION['qr_token']) ? $_SESSION['qr_token'] : $token;

?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=yes, viewport-fit=cover">
    <meta name="theme-color" content="#5c3a2e">
    <title>Klaim Poin • Teras Coklat</title>
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
            background: linear-gradient(135deg, #f2f0eb 0%, #ffffff 100%);
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
                        <div class="chocolate-icon">🍫🥤✨</div>
                        <h4 class="fw-bold mb-0">TERAS COKLAT</h4>
                        <p class="mb-0 mt-1 small opacity-75">Loyalty Program</p>
                    </div>
                    <div class="p-3 p-md-4">

                        <!-- STEP 1: Klaim Poin -->
                        <?php if($step == 'claim'): ?>
                            <div class="step-indicator">
                                <div class="step active">1</div>
                                <div class="step-line"></div>
                                <div class="step">2</div>
                            </div>
                            
                            <div class="member-card text-center">
                                <i class="fas fa-mobile-alt fa-2x" style="color: #e6b422;"></i>
                                <p class="mt-2 mb-0 fw-semibold">Masukkan nomor WhatsApp kamu</p>
                                <small class="text-muted">Pakai nomor yang sama setiap belanja ya!</small>
                            </div>

                            <form action="includes/proses.php" method="POST">
                                <input type="hidden" name="token" value="<?= htmlspecialchars($active_token) ?>">
                                <div class="mb-4">
                                    <input type="tel" 
                                           name="whatsapp" 
                                           class="input-premium text-center" 
                                           required 
                                           placeholder="81234567890"
                                           style="font-size: 1rem;"
                                           autofocus>
                                    <small class="text-muted d-block mt-2 text-center">
                                        <i class="fas fa-info-circle"></i> Contoh: 081234567890
                                    </small>
                                </div>
                                <button type="submit" name="self_checkin" class="btn-coklat">
                                    <i class="fas fa-gem"></i> DAPATKAN POIN
                                </button>
                            </form>
                        <?php endif; ?>

                        <!-- STEP 2: Daftar Member Baru -->
                        <?php if($step == 'register'): ?>
                            <div class="step-indicator">
                                <div class="step">1</div>
                                <div class="step-line"></div>
                                <div class="step active">2</div>
                            </div>
                            
                            <div class="member-card text-center">
                                <i class="fas fa-user-plus fa-2x" style="color: #e6b422;"></i>
                                <p class="mt-2 mb-0">
                                    Nomor <strong class="text-coklat"><?= htmlspecialchars($wa_temp) ?></strong> belum terdaftar.<br>
                                    Isi nama dulu yuk jadi member:
                                </p>
                            </div>

                            <form action="includes/proses.php" method="POST">
                                <input type="hidden" name="token" value="<?= htmlspecialchars($active_token) ?>">
                                <input type="hidden" name="whatsapp" value="<?= htmlspecialchars($wa_temp) ?>">
                                <div class="mb-4">
                                    <input type="text" 
                                           name="nama" 
                                           class="input-premium" 
                                           required 
                                           placeholder="Nama lengkap kamu"
                                           autofocus>
                                </div>
                                <button type="submit" name="register_and_claim" class="btn-coklat">
                                    <i class="fas fa-check-circle"></i> DAFTAR & DAPATKAN POIN
                                </button>
                            </form>
                        <?php endif; ?>
                        
                        <hr class="my-3" style="background: linear-gradient(90deg, transparent, #e6b422, transparent); height: 1px; border: none;">
                        <div class="text-center">
                            <small class="text-muted">
                                <i class="fas fa-star" style="color: #e6b422;"></i>
                                10 Poin per transaksi | 50 Poin = Free 1 Cup
                            </small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function tampilkanNotif(message, type = 'success') {
            let notifLama = document.querySelector('.notif-biasa');
            if (notifLama) notifLama.remove();
            
            let notif = document.createElement('div');
            notif.className = 'notif-biasa ' + type;
            
            let icon = type === 'success' ? 'fa-check-circle' : (type === 'error' ? 'fa-times-circle' : 'fa-exclamation-triangle');
            notif.innerHTML = '<i class="fas ' + icon + '"></i> ' + message;
            
            let form = document.querySelector('form');
            if (form) {
                form.parentNode.insertBefore(notif, form);
            }
            
            setTimeout(() => {
                if (notif) notif.remove();
            }, 3000);
        }
        
        const urlParams = new URLSearchParams(window.location.search);
        const statusNotif = urlParams.get('status');
        
        if (statusNotif === 'success') {
            tampilkanNotif('🎉 +10 Poin berhasil ditambahkan! Selamat!', 'success');
            setTimeout(() => {
                window.location.href = 'index.php';
            }, 2000);
        }
        
        if (statusNotif === 'expired') {
            tampilkanNotif('⏰ QR Code expired, silakan scan ulang!', 'warning');
        }
        
        if (statusNotif === 'fail') {
            tampilkanNotif('❌ Gagal memproses! Silakan coba lagi.', 'error');
        }
    </script>
</body>
</html>