<?php

namespace App\Services;

class WhatsAppService
{
    /**
     * Generate tautan WhatsApp untuk notifikasi surat.
     *
     * @param \Illuminate\Database\Eloquent\Model $surat
     * @param string $status
     * @param string|null $catatan
     * @param string $suratType
     * @return string|null
     */
    public function generateSuratNotificationLink($surat, string $status, string $suratType): ?string
    {
        if (!$surat->nomor_telepon) {
            return null;
        }

        $waMessage = '';
        $suratName = '';
        $route = '';
        $trackingToken = $surat->public_token;

        // Tentukan nama surat dan rute tracking berdasarkan tipe surat
        switch ($suratType) {
            case 'SuratKtm':
                $suratName = 'Surat Keterangan Tidak Mampu (KTM)';
                $route = route('public.surat-ktm.track', $trackingToken);
                break;
            case 'SuratKPT':
                $suratName = 'Surat Keterangan Penghasilan Tetap (KPT)';
                $route = route('public.surat-kpt.track', $trackingToken);
                break;
                // Tambahkan jenis surat lain jika diperlukan
            default:
                return null;
        }

        switch ($status) {
            case 'disetujui':
                $waMessage = "Selamat! Pengajuan {$suratName} Anda atas nama *{$surat->nama_yang_bersangkutan}* telah disetujui. ";
                if ($surat->nomor_surat) {
                    $waMessage .= "Nomor surat Anda: *{$surat->nomor_surat}*. ";
                }
                $waMessage .= "Anda dapat mengunduh atau mencetak surat Anda di: {$route}";
                break;
            case 'ditolak':
                $catatan = $surat->keterangan ? "Alasan penolakan: {$surat->keterangan}. " : "";
                $waMessage = "Mohon maaf, pengajuan {$suratName} Anda atas nama *{$surat->nama_yang_bersangkutan}* telah ditolak. {$catatan}Anda bisa memperbaiki data dan mengajukan ulang. Cek status di: {$route}";
                break;
            case 'diproses':
                $waMessage = "Pengajuan {$suratName} Anda atas nama *{$surat->nama_yang_bersangkutan}* sedang dalam tahap *pemrosesan*. Mohon menunggu untuk proses selanjutnya. Cek status di: {$route}";
                break;
        }

        if ($waMessage) {
            $phoneNumber = $this->convertToWhatsAppNumber($surat->nomor_telepon);
            return "https://wa.me/{$phoneNumber}?text=" . urlencode($waMessage);
        }

        return null;
    }

    /**
     * Generate tautan WhatsApp untuk notifikasi UMKM.
     *
     * @param \App\Models\Umkm $umkm
     * @param string $status
     * @return string|null
     */
    public function generateUmkmNotificationLink($umkm, string $status): ?string
    {
        if (!$umkm->nomor_telepon) {
            return null;
        }

        $waMessage = '';
        $route = route('umkm.show', $umkm->id);

        switch ($status) {
            case 'approved':
                $waMessage = "Pendaftaran UMKM Anda dengan nama usaha *{$umkm->nama_umkm}* telah disetujui. UMKM Anda kini sudah terdaftar di website desa. Silakan cek di tautan berikut: {$route}";
                break;
            case 'rejected':
                $catatan = $umkm->catatan_admin ? "Dengan Catatan: {$umkm->catatan_admin}. " : "";
                $waMessage = "Mohon maaf, pendaftaran UMKM Anda dengan nama usaha *{$umkm->nama_umkm}* telah ditolak. {$catatan}Anda bisa mengajukan pendaftaran ulang setelah memperbaiki kekurangan data. ";
                break;
        }

        if ($waMessage) {
            $phoneNumber = $this->convertToWhatsAppNumber($umkm->nomor_telepon);
            return "https://wa.me/{$phoneNumber}?text=" . urlencode($waMessage);
        }

        return null;
    }

    /**
     * Convert nomor telepon ke format WhatsApp yang benar.
     *
     * @param string $phoneNumber
     * @return string
     */
    private function convertToWhatsAppNumber(string $phoneNumber): string
    {
        // Hapus semua karakter non-digit kecuali +
        $cleanNumber = preg_replace('/[^0-9+]/', '', $phoneNumber);

        // Handle berbagai format nomor Indonesia
        if (preg_match('/^0[8-9]\d{8,11}$/', $cleanNumber)) {
            // Format: 0852xxxxxxxx, 0812xxxxxxxx, etc
            $cleanNumber = '62' . substr($cleanNumber, 1);
        } elseif (preg_match('/^[8-9]\d{8,11}$/', $cleanNumber)) {
            // Format: 852xxxxxxxx, 812xxxxxxxx (tanpa leading 0)
            $cleanNumber = '62' . $cleanNumber;
        } elseif (str_starts_with($cleanNumber, '62')) {
            // Sudah format 62xxxxxxxxx
            $cleanNumber = $cleanNumber;
        } elseif (str_starts_with($cleanNumber, '+62')) {
            // Format +62xxxxxxxxx, hapus +
            $cleanNumber = substr($cleanNumber, 1);
        }

        // Pastikan format akhir adalah 62xxxxxxxxx (tanpa +)
        return ltrim($cleanNumber, '+');
    }
}
