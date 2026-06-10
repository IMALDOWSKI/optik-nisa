<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class BackupController extends Controller
{
    public function index()
    {
        $backups    = [];
        $backupPath = storage_path('app/backups');

        if (!file_exists($backupPath)) {
            mkdir($backupPath, 0755, true);
        }

        $files = scandir($backupPath);
        foreach ($files as $file) {
            if (pathinfo($file, PATHINFO_EXTENSION) === 'sql') {
                $backups[] = [
                    'nama'    => $file,
                    'ukuran'  => $this->formatUkuran(filesize($backupPath . '/' . $file)),
                    'tanggal' => Carbon::createFromTimestamp(
                                    filemtime($backupPath . '/' . $file)
                                 )->format('d/m/Y H:i:s'),
                ];
            }
        }

        // Sort terbaru di atas
        usort($backups, fn($a, $b) => strcmp($b['nama'], $a['nama']));

        return view('backup.index', compact('backups'));
    }

    public function buat()
    {
        try {
            $dbName  = config('database.connections.mysql.database');
            $fileName = 'backup_' . $dbName . '_' .
                        Carbon::now()->format('Y-m-d_H-i-s') . '.sql';

            $backupPath = storage_path('app/backups');
            $filePath   = $backupPath . '/' . $fileName;

            if (!file_exists($backupPath)) {
                mkdir($backupPath, 0755, true);
            }

            // Generate SQL backup pakai PHP murni
            $sql = $this->generateSqlBackup();
            file_put_contents($filePath, $sql);

            \App\Models\ActivityLog::catat(
                'Backup', 'export',
                'Membuat backup database: ' . $fileName
            );

            return redirect()->route('backup.index')
                             ->with('success', 'Backup berhasil! File: ' . $fileName);

        } catch (\Exception $e) {
            return redirect()->route('backup.index')
                             ->with('error', 'Backup gagal: ' . $e->getMessage());
        }
    }

    public function download(Request $request)
    {
        $fileName   = $request->file;
        $backupPath = storage_path('app/backups/' . $fileName);

        if (!file_exists($backupPath)) {
            return redirect()->route('backup.index')
                             ->with('error', 'File tidak ditemukan!');
        }

        \App\Models\ActivityLog::catat(
            'Backup', 'export',
            'Download backup: ' . $fileName
        );

        return response()->download($backupPath);
    }

    public function hapus(Request $request)
    {
        $fileName   = $request->file;
        $backupPath = storage_path('app/backups/' . $fileName);

        if (file_exists($backupPath)) {
            unlink($backupPath);
        }

        return redirect()->route('backup.index')
                         ->with('success', 'File backup berhasil dihapus!');
    }

    private function generateSqlBackup()
    {
        $dbName = config('database.connections.mysql.database');

        $sql  = "-- ================================================\n";
        $sql .= "-- Optik Nisa Database Backup\n";
        $sql .= "-- Generated : " . Carbon::now()->format('Y-m-d H:i:s') . "\n";
        $sql .= "-- Database  : " . $dbName . "\n";
        $sql .= "-- ================================================\n\n";
        $sql .= "SET FOREIGN_KEY_CHECKS = 0;\n";
        $sql .= "SET SQL_MODE = 'NO_AUTO_VALUE_ON_ZERO';\n";
        $sql .= "SET NAMES utf8mb4;\n\n";

        // Ambil semua tabel
        $tables = DB::select('SHOW TABLES');
        $dbKey  = 'Tables_in_' . $dbName;

        foreach ($tables as $table) {
            $tableName = $table->$dbKey;

            $sql .= "-- ------------------------------------------------\n";
            $sql .= "-- Table: `$tableName`\n";
            $sql .= "-- ------------------------------------------------\n\n";

            // Drop & Create table
            $sql .= "DROP TABLE IF EXISTS `$tableName`;\n\n";

            $createTable = DB::select("SHOW CREATE TABLE `$tableName`");
            $sql .= $createTable[0]->{'Create Table'} . ";\n\n";

            // Insert data
            $rows = DB::table($tableName)->get();

            if ($rows->count() > 0) {
                $sql .= "-- Data untuk tabel `$tableName`\n";

                // Proses per 100 baris
                $chunks = $rows->chunk(100);
                foreach ($chunks as $chunk) {
                    $sql .= "INSERT INTO `$tableName` VALUES\n";
                    $values = [];

                    foreach ($chunk as $row) {
                        $rowArray  = (array) $row;
                        $rowValues = array_map(function ($val) {
                            if (is_null($val)) return 'NULL';
                            if (is_numeric($val)) return $val;
                            return "'" . addslashes((string) $val) . "'";
                        }, $rowArray);

                        $values[] = '(' . implode(', ', $rowValues) . ')';
                    }

                    $sql .= implode(",\n", $values) . ";\n\n";
                }
            }
        }

        $sql .= "SET FOREIGN_KEY_CHECKS = 1;\n";
        $sql .= "\n-- Backup selesai: " . Carbon::now()->format('Y-m-d H:i:s') . "\n";

        return $sql;
    }

    private function formatUkuran($bytes)
    {
        if ($bytes >= 1073741824) return number_format($bytes / 1073741824, 2) . ' GB';
        if ($bytes >= 1048576)    return number_format($bytes / 1048576, 2) . ' MB';
        if ($bytes >= 1024)       return number_format($bytes / 1024, 2) . ' KB';
        return $bytes . ' bytes';
    }
}