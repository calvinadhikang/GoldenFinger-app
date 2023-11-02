<?php

namespace App\Imports;

use App\Models\Barang;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class BarangImport implements ToModel, WithHeadingRow
{
    /**
    * @param Collection $collection
    */
    public function model(array $row)
    {
        $part = $row['part'];
        $nama = $row['nama'];
        $harga = $row['harga'];
        $stok = $row['stok'];
        $batas = $row['batas'];

        DB::beginTransaction();
        try {
            $barang = DB::table('barang')->where('part', $part)->get();
            if (count($barang) > 0) {
                DB::table('barang')->where('part', $part)->update([
                    'nama' => $nama,
                    'harga' => $harga,
                    'stok' => $stok,
                    'batas' => $batas,
                ]);
            }else{
                DB::table('barang')->insert([
                    'part' => $part,
                    'nama' => $nama,
                    'harga' => $harga,
                    'stok' => $stok,
                    'batas' => $batas,
                ]);
            }

            toast('Data Barang berhasil di update', 'success');
            DB::commit();
        } catch (\Exception $ex) {
            dd($ex);
            DB::rollBack();
        }
    }
}
