<?php
include '../config/database.php';

// Folder untuk menyimpan token
$cache_dir = '../cache/';
if (!file_exists($cache_dir)) {
    mkdir($cache_dir, 0755, true);
}

// Generate QR Token (dipanggil oleh index.php)
if (isset($_GET['aksi']) && $_GET['aksi'] == 'generate_qr') {
    $token = bin2hex(random_bytes(16));
    $data = [
        'token' => $token,
        'time' => time()
    ];
    file_put_contents($cache_dir . 'qr_token.json', json_encode($data));
    echo $token;
    exit();
}

// Baca token dari file
function getToken() {
    global $cache_dir;
    $file = $cache_dir . 'qr_token.json';
    if (file_exists($file)) {
        $data = json_decode(file_get_contents($file), true);
        return $data;
    }
    return null;
}

// Self Check-in (Klaim Poin)
if (isset($_POST['self_checkin'])) {
    $wa = mysqli_real_escape_string($conn, $_POST['whatsapp']);
    $token_input = $_POST['token'];
    
    $token_data = getToken();
    
    if ($token_data && $token_input === $token_data['token'] && (time() - $token_data['time']) < 120) {
        $cek = mysqli_query($conn, "SELECT id FROM pelanggan WHERE whatsapp = '$wa'");
        
        if (mysqli_num_rows($cek) > 0) {
            mysqli_query($conn, "UPDATE pelanggan SET total_poin = total_poin + 10 WHERE whatsapp = '$wa'");
            header("Location: ../checkin.php?status=success&token=" . urlencode($token_input));
            exit();
        } else {
            header("Location: ../checkin.php?step=register&token=" . urlencode($token_input) . "&wa=" . urlencode($wa));
            exit();
        }
    } else {
        header("Location: ../checkin.php?status=expired&token=" . urlencode($token_input));
        exit();
    }
}

// Register + Claim (untuk member baru)
if (isset($_POST['register_and_claim'])) {
    $nama = mysqli_real_escape_string($conn, $_POST['nama']);
    $wa = mysqli_real_escape_string($conn, $_POST['whatsapp']);
    $token_input = $_POST['token'];
    
    $token_data = getToken();
    
    if (!$token_data || $token_input !== $token_data['token'] || (time() - $token_data['time']) >= 120) {
        header("Location: ../checkin.php?status=expired");
        exit();
    }

    $cek = mysqli_query($conn, "SELECT id FROM pelanggan WHERE whatsapp = '$wa'");
    if (mysqli_num_rows($cek) > 0) {
        mysqli_query($conn, "UPDATE pelanggan SET total_poin = total_poin + 10 WHERE whatsapp = '$wa'");
        header("Location: ../checkin.php?status=success&token=" . urlencode($token_input));
        exit();
    }

    $query = "INSERT INTO pelanggan (nama, whatsapp, total_poin) VALUES ('$nama', '$wa', 10)";
    if (mysqli_query($conn, $query)) {
        header("Location: ../checkin.php?status=success&token=" . urlencode($token_input));
    } else {
        header("Location: ../checkin.php?status=fail&token=" . urlencode($token_input));
    }
    exit();
}

// Register Member Biasa
if (isset($_POST['register_member'])) {
    $nama = mysqli_real_escape_string($conn, $_POST['nama']);
    $wa = mysqli_real_escape_string($conn, $_POST['whatsapp']);
    
    $cek = mysqli_query($conn, "SELECT id FROM pelanggan WHERE whatsapp = '$wa'");
    if (mysqli_num_rows($cek) > 0) {
        header("Location: ../register.php?status=exists");
        exit();
    }
    
    $query = "INSERT INTO pelanggan (nama, whatsapp, total_poin) VALUES ('$nama', '$wa', 0)";
    if (mysqli_query($conn, $query)) {
        header("Location: ../register.php?status=success");
    } else {
        header("Location: ../register.php?status=error");
    }
    exit();
}

// REDEEM & RESET
if (isset($_GET['aksi']) && isset($_GET['id'])) {
    $id = (int)$_GET['id'];
    
    if ($_GET['aksi'] == 'tukar_poin') {
        $cek = mysqli_query($conn, "SELECT total_poin FROM pelanggan WHERE id = $id");
        if ($cek && mysqli_num_rows($cek) > 0) {
            $data = mysqli_fetch_assoc($cek);
            if ($data['total_poin'] >= 50) {
                mysqli_query($conn, "UPDATE pelanggan SET total_poin = total_poin - 50 WHERE id = $id");
            }
        }
        header("Location: ../index.php");
        exit();
    }
    
    if ($_GET['aksi'] == 'reset_poin') {
        mysqli_query($conn, "UPDATE pelanggan SET total_poin = 0 WHERE id = $id");
        header("Location: ../index.php");
        exit();
    }
}

header("Location: ../index.php");
exit();
?>