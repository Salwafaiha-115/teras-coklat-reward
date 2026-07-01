<?php include 'config/database.php'; session_start(); ?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=yes, viewport-fit=cover">
    <meta name="theme-color" content="#1e3932">
    <meta name="description" content="Teras Coklat Loyalty Program - Kumpulkan poin dan dapatkan hadiah menarik!">
    <title>Teras Coklat • Rewards</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="assets/css/style.css">
    
    <!-- TAMBAHAN CSS FIX (TIDAK MENGHAPUS YANG ASLI) -->
    <style>
        /* FIX QR CODE BIAR GA KELUAR DARI CARD */
        .qr-wrapper {
            background: white;
            padding: 15px;
            border-radius: 20px;
            display: flex;
            justify-content: center;
            align-items: center;
            width: 100%;
            max-width: 200px;
            margin: 0 auto;
            overflow: hidden;
        }
        .qr-wrapper canvas,
        .qr-wrapper img {
            width: 100% !important;
            height: auto !important;
            max-width: 170px !important;
        }
        
        /* FIX RESPONSIVE HP */
        @media (max-width: 768px) {
            .hero-starbucks .hero-wrapper {
                flex-direction: column;
                text-align: center;
            }
            .hero-starbucks .hero-text {
                text-align: center;
            }
            .hero-starbucks .hero-description {
                margin-left: auto;
                margin-right: auto;
            }
            .hero-starbucks .hero-image img {
                max-width: 280px;
            }
            .tier-starbucks .tier-header {
                flex-direction: column;
                gap: 8px;
            }
            .tier-starbucks .tier-benefits {
                grid-template-columns: 1fr;
            }
            .qr-wrapper {
                max-width: 160px;
                padding: 10px;
            }
            .qr-wrapper canvas,
            .qr-wrapper img {
                max-width: 140px !important;
            }
            .table-premium thead th {
                padding: 8px;
                font-size: 0.7rem;
            }
            .table-premium tbody td {
                padding: 8px;
                font-size: 0.75rem;
            }
            .btn-redeem, .btn-reset {
                padding: 4px 8px;
                font-size: 0.6rem;
            }
            .stat-number {
                font-size: 1.3rem;
            }
            .reward-item {
                min-width: 130px;
                padding: 1rem;
            }
        }
        
        @media (max-width: 480px) {
            .qr-wrapper {
                max-width: 140px;
                padding: 8px;
            }
            .qr-wrapper canvas,
            .qr-wrapper img {
                max-width: 120px !important;
            }
            .btn-redeem, .btn-reset {
                padding: 3px 6px;
                font-size: 0.55rem;
            }
            .reward-item {
                min-width: 110px;
                padding: 0.8rem;
            }
        }
        
        /* FIX TABEL LEADERBOARD */
        .table-responsive {
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
        }
        .table-premium {
            min-width: 100%;
        }
        
        /* FIX CARD PREMIUM */
        .card-premium {
            background: #ffffff;
            border-radius: 28px;
            overflow: hidden;
        }
        .card-header-premium h6,
        .card-header-premium p {
            color: white !important;
        }
        .card-header-premium i {
            color: #e6b422 !important;
        }
    </style>
</head>
<body>

<!-- NAVBAR - Logo di KIRI -->
<nav class="navbar navbar-premium">
    <div class="container">
        <div class="logo-container" onclick="openModal()" style="cursor: pointer;">
            <img src="assets/img/logo.jpeg" alt="Teras Coklat" class="logo-img">
            <span class="navbar-brand mb-0">Teras Coklat</span>
        </div>
    </div>
</nav>

<!-- HERO SECTION ala Starbucks -->
<section class="hero-starbucks">
    <div class="container">
        <div class="hero-wrapper">
            <div class="hero-text">
                <p class="hero-badge">TERAS COKLAT REWARDS</p>
                <h1 class="hero-title">
                    Free chocolate<br>
                    is just<br>
                    the beginning
                </h1>
                <p class="hero-description">
                    Collect points on every purchase, exchange them for attractive prizes!
                </p>
                <a href="checkin.php" class="hero-btn">✨ Gabung Sekarang ✨</a>
            </div>
            <div class="hero-image">
                <img src="assets/img/es sodap.jpeg" alt="Teras Coklat" onerror="this.src='https://placehold.co/400x400/1e3932/white?text=🍫'">
            </div>
        </div>
    </div>
</section>

<!-- HOW IT WORKS -->
<section class="how-it-works">
    <div class="container">
        <h2 class="text-center fw-bold mb-5" style="color: #1e3932;">Caranya Dengan</h2>
        <div class="steps-grid">
            <div class="step-card text-center">
                <div class="step-icon"><i class="fas fa-qrcode"></i></div>
                <h4 class="fw-bold">Scan QR Code</h4>
                <p class="text-muted">Tunjukkan QR Code ke kasir setiap belanja</p>
            </div>
            <div class="step-card text-center">
                <div class="step-icon"><i class="fas fa-star"></i></div>
                <h4 class="fw-bold">Kumpulkan Poin</h4>
                <p class="text-muted">Setiap transaksi dapat +10 Poin</p>
            </div>
            <div class="step-card text-center">
                <div class="step-icon"><i class="fas fa-gift"></i></div>
                <h4 class="fw-bold">Tukar Hadiah</h4>
                <p class="text-muted">Tukarkan poin dengan minuman gratis & merchandise</p>
            </div>
        </div>
    </div>
</section>

<!-- ========== TIER LEVELS ala STARBUCKS ========== -->
<section class="tier-starbucks">
    <div class="container">
        <div class="section-header">
            <h2>Dapatkan hadiah untuk rutinitas Anda</h2>
            <p>Seiring meningkatnya status Anda, manfaat yang Anda peroleh juga akan meningkat.</p>
        </div>
        
        <div class="tier-list">
            <!-- SILVER -->
            <div class="tier-item">
                <div class="tier-header">
                    <span class="tier-name">🍫 Silver</span>
                    <span class="tier-points">Kurang dari 50 poin</span>
                </div>
                <ul class="tier-benefits">
                    <li><i class="fas fa-check-circle"></i> Hadiah gratis di hari ulang tahunmu (Free topping)</li>
                    <li><i class="fas fa-coffee"></i> Dapatkan 1 poin per Rp5.000 yang dibelanjakan</li>
                    <li><i class="fas fa-mobile-alt"></i> Akses leaderboard & pantau perkembanganmu</li>
                    <li><i class="fas fa-ticket-alt"></i> Akses awal penawaran spesial</li>
                </ul>
            </div>
            
            <!-- GOLD -->
            <div class="tier-item">
                <div class="tier-header">
                    <span class="tier-name">🌟 Gold</span>
                    <span class="tier-points">50 - 199 poin</span>
                </div>
                <ul class="tier-benefits">
                    <li><i class="fas fa-check-circle"></i> Free 1 Cup (tukar 50 poin)</li>
                    <li><i class="fas fa-check-circle"></i> 7 hari untuk menukarkan hadiah ulang tahun</li>
                    <li><i class="fas fa-star"></i> Dapatkan 1.5x poin setiap transaksi</li>
                    <li><i class="fas fa-infinity"></i> Poin tidak akan kadaluarsa selama status Gold</li>
                    <li><i class="fas fa-calendar-alt"></i> 1x event spesial per tahun</li>
                </ul>
            </div>
            
            <!-- PLATINUM -->
            <div class="tier-item">
                <div class="tier-header">
                    <span class="tier-name">👑 Platinum</span>
                    <span class="tier-points">200+ poin</span>
                </div>
                <ul class="tier-benefits">
                    <li><i class="fas fa-check-circle"></i> Free 1 Cup setiap 40 poin (lebih hemat!)</li>
                    <li><i class="fas fa-check-circle"></i> 30 hari untuk menukarkan hadiah ulang tahun</li>
                    <li><i class="fas fa-gem"></i> Dapatkan 2x poin setiap transaksi</li>
                    <li><i class="fas fa-infinity"></i> Poin tidak akan kadaluarsa</li>
                    <li><i class="fas fa-users"></i> Undangan VIP tasting & acara eksklusif</li>
                    <li><i class="fas fa-tshirt"></i> Merchandise eksklusif Teras Coklat</li>
                </ul>
            </div>
        </div>
    </div>
</section>

<!-- REWARDS CATALOG -->
<section class="rewards-catalog">
    <div class="container">
        <h2 class="text-center fw-bold mb-5" style="color: #1e3932;">Tukarkan Poin Kamu</h2>
        <div class="rewards-grid">
            <div class="reward-item">
                <div class="reward-icon">🍪</div>
                <div class="reward-name fw-bold">Extra Topping</div>
                <div class="reward-points">20 Poin</div>
            </div>
            <div class="reward-item">
                <div class="reward-icon">☕</div>
                <div class="reward-name fw-bold">Free 1 Cup</div>
                <div class="reward-points">50 Poin</div>
            </div>
            <div class="reward-item">
                <div class="reward-icon">🎁</div>
                <div class="reward-name fw-bold">Merchandise</div>
                <div class="reward-points">100 Poin</div>
            </div>
            <div class="reward-item">
                <div class="reward-icon">🎟️</div>
                <div class="reward-name fw-bold">Event VIP</div>
                <div class="reward-points">200 Poin</div>
            </div>
        </div>
    </div>
</section>

<!-- QR & LEADERBOARD -->
<div class="container py-4">
    <div class="row g-4">
        <div class="col-12 col-lg-4">
            <div class="card-premium">
                <div class="card-header-premium">
                    <i class="fas fa-qrcode"></i>
                    <h6 class="mt-2 fw-bold mb-0">SCAN & CLAIM</h6>
                    <p class="small opacity-75 mb-0">Setiap scan = +10 Poin</p>
                </div>
                <div class="card-body text-center p-3 p-md-4">
                    <div class="qr-wrapper mx-auto">
                        <div id="qrcode"></div>
                    </div>
                    <div class="mt-3">
                        <span class="qr-timer-badge">
                            <i class="fas fa-sync-alt fa-fw"></i> Update tiap 60 detik
                        </span>
                    </div>
                    <p class="small text-muted mt-3 mb-0">
                        <i class="fas fa-info-circle"></i> Tunjukkan QR ini ke customer
                    </p>
                </div>
            </div>
            
            <div class="card-premium mt-4">
                <div class="card-body p-3">
                    <?php 
                    $total_members = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as total FROM pelanggan"));
                    $total_poin_all = mysqli_fetch_assoc(mysqli_query($conn, "SELECT SUM(total_poin) as total FROM pelanggan"));
                    ?>
                    <div class="row g-2 text-center">
                        <div class="col-4">
                            <div class="hero-stats">
                                <p class="stat-number"><?= $total_members['total'] ?></p>
                                <p class="small mb-0"><i class="fas fa-users"></i> Member</p>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="hero-stats">
                                <p class="stat-number"><?= $total_poin_all['total'] ?? 0 ?></p>
                                <p class="small mb-0"><i class="fas fa-star"></i> Poin</p>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="hero-stats">
                                <p class="stat-number"><?= $total_members['total'] ?></p>
                                <p class="small mb-0"><i class="fas fa-user-plus"></i> Aktif</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12 col-lg-8">
            <div class="card-premium">
                <div class="card-header-premium d-flex justify-content-between align-items-center flex-wrap">
                    <div>
                        <i class="fas fa-trophy"></i>
                        <h5 class="d-inline-block ms-2 mb-0 fw-bold">Leaderboard</h5>
                    </div>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-premium mb-0">
                            <thead>
                                <tr><th><i class="fas fa-user"></i> Nama Member</th><th class="text-center"><i class="fas fa-coins"></i> Poin</th><th class="text-center"><i class="fas fa-cog"></i> Aksi</th></tr>
                            </thead>
                            <tbody>
                                <?php 
                                $q = mysqli_query($conn, "SELECT * FROM pelanggan ORDER BY total_poin DESC");
                                $rank = 1;
                                if(mysqli_num_rows($q) > 0):
                                while($r = mysqli_fetch_assoc($q)): 
                                ?>
                                <tr>
                                    <td><div class="d-flex align-items-center"><div class="me-2"><?php if($rank==1): ?><i class="fas fa-crown" style="color:#e6b422;"></i><?php elseif($rank==2): ?><i class="fas fa-medal" style="color:#c0c0c0;"></i><?php elseif($rank==3): ?><i class="fas fa-medal" style="color:#cd7f32;"></i><?php else: ?><span class="text-muted fw-bold">#<?=$rank?></span><?php endif; ?></div><div><strong><?= htmlspecialchars($r['nama']) ?></strong><br><small class="text-muted"><i class="fab fa-whatsapp"></i> <?= htmlspecialchars($r['whatsapp']) ?></small></div></div></td>
                                    <td class="text-center align-middle"><span class="badge-poin"><i class="fas fa-star"></i> <?= $r['total_poin'] ?></span></td>
                                    <td class="text-center align-middle"><a href="includes/proses.php?aksi=tukar_poin&id=<?= $r['id'] ?>" class="btn-redeem" onclick="return confirm('🍫 Tukar 50 poin untuk 1 Cup gratis?')"><i class="fas fa-gift"></i> Redeem</a> <a href="includes/proses.php?aksi=reset_poin&id=<?= $r['id'] ?>" class="btn-reset" onclick="return confirm('⚠️ Reset semua poin?')"><i class="fas fa-undo-alt"></i> Reset</a></td>
                                </tr>
                                <?php $rank++; endwhile; else: ?>
                                <tr><td colspan="3" class="text-center py-4 text-muted">Belum ada member</td></tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<footer style="background: #1e3932; color: white; padding: 2rem 0; text-align: center; margin-top: 2rem;">
    <div class="container">
        <p><i class="fas fa-copyright"></i> 2025 Teras Coklat Rewards | Nikmati setiap tetes kebahagiaan 🍫</p>
        <p class="small opacity-75">*Syarat dan ketentuan berlaku</p>
    </div>
</footer>

<!-- ========== MODAL PROFILE DIBAWAKAN KEMBALI DENGAN WRAPPER UTUH ========== -->
<div id="profileModal" class="modal-premium">
    <div class="modal-content-premium">
        <div class="modal-header-premium">
            <div class="modal-logo">
                <img src="assets/img/logo.jpeg" alt="Teras Coklat" style="width:80px;height:80px;border-radius:50%;object-fit:cover;border:3px solid #e6b422;">
            </div>
            <h3>Teras Coklat</h3>
            <span class="modal-close" onclick="closeModal()">×</span>
        </div>
        <div class="modal-body-premium">
            <div class="profile-item">
                <i class="fas fa-store"></i>
                <div class="info">
                    <h6>Tentang Kami</h6>
                    <p>Minuman coklat kekinian dengan cita rasa premium dan berkelas ala teras mania</p>
                </div>
            </div>
            <div class="profile-item">
                <i class="fas fa-map-marker-alt"></i>
                <div class="info">
                    <h6>Lokasi</h6>
                    <p>Jl. Samirejo, Kepuh, Pandan Arum, Kec. Tirto, Kabupaten Pekalongan, Jawa Tengah 51151</p>
                </div>
            </div>
            <div class="profile-item">
                <i class="fas fa-clock"></i>
                <div class="info">
                    <h6>Jam Operasional</h6>
                    <p>Senin - Minggu: 10:00 - 22:00</p>
                </div>
            </div>
            <button class="btn-close-modal" onclick="closeModal()">Tutup</button>
        </div>
    </div>
</div>

<!-- ALL JAVASCRIPT GLOBAL -->
<script>
    let qrInterval;
    function updateQR() {
        fetch('includes/proses.php?aksi=generate_qr&t=' + new Date().getTime())
        .then(res => res.text())
        .then(token => {
            const qrcodeDiv = document.getElementById("qrcode");
            if (qrcodeDiv) {
                qrcodeDiv.innerHTML = "";
                let qrUrl = window.location.origin + "/checkin.php?token=" + token;
                new QRCode(qrcodeDiv, { text: qrUrl, width: 180, height: 180 });
            }
        })
        .catch(err => console.log('QR Error:', err));
    }
    
    // Jalankan QR saat awal load
    updateQR();
    qrInterval = setInterval(updateQR, 60000);

    // Fungsi Pengendali Modal Teras Coklat
    function openModal() {
        const modal = document.getElementById('profileModal');
        if (modal) {
            modal.classList.add('active');
            document.body.style.overflow = 'hidden';
        }
    }
    
    function closeModal() {
        const modal = document.getElementById('profileModal');
        if (modal) {
            modal.classList.remove('active');
            document.body.style.overflow = 'auto';
        }
    }

    // Deteksi klik di luar konten luar modal untuk menutup otomatis
    window.addEventListener('click', function(e) {
        const modal = document.getElementById('profileModal');
        if (e.target === modal) {
            closeModal();
        }
    });
</script>
</body>
</html>