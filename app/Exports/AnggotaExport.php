<?php

namespace App\Exports;

use App\Models\Anggota;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class AnggotaExport implements FromCollection, WithHeadings, WithMapping, WithStyles
{
    /**
     * Ambil data anggota yang akan diexport
     */
    public function collection()
    {
        return Anggota::select([
            'kode_anggota', 'nama', 'email', 'telepon', 'alamat',
            'tanggal_lahir', 'jenis_kelamin', 'pekerjaan', 'status', 'tanggal_daftar',
        ])->orderBy('kode_anggota', 'asc')->get();
    }

    /**
     * Judul kolom di file Excel
     */
    public function headings(): array
    {
        return [
            'Kode Anggota', 'Nama', 'Email', 'Telepon', 'Alamat',
            'Tanggal Lahir', 'Jenis Kelamin', 'Pekerjaan', 'Status', 'Tanggal Daftar',
        ];
    }

    /**
     * Format tiap baris data sebelum masuk ke Excel
     */
    public function map($anggota): array
    {
        return [
            $anggota->kode_anggota,
            $anggota->nama,
            $anggota->email,
            $anggota->telepon,
            $anggota->alamat,
            $anggota->tanggal_lahir?->format('d-m-Y'),
            $anggota->jenis_kelamin,
            $anggota->pekerjaan ?? '-',
            $anggota->status,
            $anggota->tanggal_daftar?->format('d-m-Y'),
        ];
    }

    /**
     * Styling header (bold) biar rapi
     */
    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true]],
        ];
    }
}