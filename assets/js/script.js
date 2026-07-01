// Konfirmasi Redeem
function konfirmasiRedeem(nama, totalPoin, id) {
    if (totalPoin < 50) {
        alert("⚠️ Poin " + nama + " belum cukup! Minimal 50 poin untuk redeem.");
        return;
    }

    if (confirm("🍫 Yakin mau tukar 50 poin milik " + nama + "?\n\n✅ Bonus: 1 Cup Es Coklat GRATIS!\n💰 Sisa poin: " + (totalPoin - 50))) {
        window.location.href = "includes/proses.php?aksi=tukar_poin&id=" + id;
    }
}

// Konfirmasi Reset
function konfirmasiReset(id) {
    if (confirm("⚠️ PERINGATAN!\n\nSemua poin akan direset menjadi 0!\n\nApakah Anda yakin?")) {
        window.location.href = "includes/proses.php?aksi=reset_poin&id=" + id;
    }
}