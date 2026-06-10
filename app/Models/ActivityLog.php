<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ActivityLog extends Model
{
    protected $fillable = [
        'user_id',
        'modul',
        'aksi',
        'deskripsi',
        'model_type',
        'model_id',
        'data_lama',
        'data_baru',
        'ip_address',
        'user_agent',
    ];

    protected $casts = [
        'data_lama' => 'array',
        'data_baru' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Method untuk catat activity
    public static function catat(
        string $modul,
        string $aksi,
        string $deskripsi,
        $model = null,
        array $dataLama = null,
        array $dataBaru = null
    ) {
        self::create([
            'user_id'    => auth()->id(),
            'modul'      => $modul,
            'aksi'       => $aksi,
            'deskripsi'  => $deskripsi,
            'model_type' => $model ? get_class($model) : null,
            'model_id'   => $model ? $model->id : null,
            'data_lama'  => $dataLama,
            'data_baru'  => $dataBaru,
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
        ]);
    }

    // Warna badge berdasarkan aksi
    public function warnaAksi()
    {
        return match($this->aksi) {
            'login'   => 'success',
            'logout'  => 'secondary',
            'create'  => 'primary',
            'update'  => 'warning',
            'delete'  => 'danger',
            'export'  => 'info',
            'print'   => 'info',
            default   => 'light',
        };
    }
}