<?php

namespace App\Helpers;

class WhatsappHelper
{
    // Format nomor telepon ke format internasional (62xxx)
    public static function formatNomor($nomor)
    {
        $nomor = preg_replace('/[^0-9]/', '', $nomor);

        if (substr($nomor, 0, 1) == '0') {
            $nomor = '62' . substr($nomor, 1);
        } elseif (substr($nomor, 0, 2) != '62') {
            $nomor = '62' . $nomor;
        }

        return $nomor;
    }

    // Generate link WhatsApp
    public static function link($nomor, $pesan)
    {
        $nomorFormatted = self::formatNomor($nomor);
        $pesanEncoded   = rawurlencode($pesan);

        return "https://wa.me/{$nomorFormatted}?text={$pesanEncoded}";
    }
}