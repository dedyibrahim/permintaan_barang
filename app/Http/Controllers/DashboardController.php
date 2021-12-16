<?php

namespace App\Http\Controllers;

use App\Models\karyawans;
use App\Models\Barangs;
use App\Models\daftarpermintaans;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Permintaans;
use Illuminate\Support\Facades\Validator;

class DashboardController extends ApiController
{
    public function SearchNik(Request $request)
    {

        $ka = karyawans::where('id_nik', $request->post("id_nik"))->get();

        foreach ($ka as $r) {
            $data = array(
                'id_nik'            => $r->id_nik,
                'nama'              => $r->nama,
                'department'        => $r->department,
                'tgl_permintaan'    =>date("Y-m-d")
            );
            return $this->successResponse($data, "Nik Peminta Berhasil ditemukan");
        }

        return $this->errorResponse(null, "Nik Peminta tidak ditemukan", 404);
    }

    public function getBarang()
    {
        $b = Barangs::orderBy("nama_barang")->get();
        foreach ($b as $r) {

          if($r->qty < 1 ){
            $status = "Stok Kosong";
          }else{
            $status = "Terpenuhi";
          }
            $data[] = array(
                'id_barang'     => $r->id_barang,
                'nama_barang'   => $r->id_barang . " - " . $r->nama_barang,
                'ketersediaan'  => $r->qty,
                'qty'           => 1,
                'lokasi'        => $r->lokasi,
                'keterangan'    => '-',
                'status'        => $status,
                'satuan'        => $r->satuan
            );
        }
        return $this->successResponse($data, "Berhasil mengambil data barang");
    }
    public function ProsesPermintaan(Request $request)
    {
        $request->validate([
            'karyawan.id_nik' => ['required', 'exists:karyawans,id_nik'],
            'pesanan.*.id_barang' => 'required',
        ]);


        $permintaan = DB::table('permintaans')
            ->orderBy('id_permintaan', 'desc')
            ->limit(1)
            ->first();

        if (isset($permintaan->id_permintaan)) {
            $urutan = (int) substr($permintaan->id_permintaan, 3) + 1;
        } else {
            $urutan = 1;
        }

        $id_permintaan    =  "PMT" . str_pad($urutan, 4, "0", STR_PAD_LEFT);
        $d = $request->input("karyawan");

        $pmt = array(
            'id_permintaan'        => $id_permintaan,
            'id_nik'               => $d['id_nik'],
            'tgl_permintaan'       => $d['tgl_permintaan']
        );
        Permintaans::create($pmt);

        foreach ($request->input('pesanan') as $a) {
            $daftarpermintaan = DB::table('daftarpermintaans')
                ->orderBy('id_daftar_permintaan', 'desc')
                ->limit(1)
                ->first();

            if (isset($daftarpermintaan->id_daftar_permintaan)) {
                $urutan = (int) substr($daftarpermintaan->id_daftar_permintaan, 3) + 1;
            } else {
                $urutan = 1;
            }
            $id_dftr    =  "DFT" . str_pad($urutan, 4, "0", STR_PAD_LEFT);

            $psn = array(
                'id_daftar_permintaan' => $id_dftr,
                'id_permintaan'       => $id_permintaan,
                'id_barang'           => $a['id_barang'],
                'qty'                 => $a['qty'],
                'keterangan'          => $a['keterangan']
            );

            daftarpermintaans::create($psn);
        }

        return $this->successResponse(null, "Berhasil memproses permintaan");
    }

    public function DataPermintaan(){

        $query = DB::table('daftarpermintaans')
                ->join('permintaans', 'daftarpermintaans.id_permintaan', '=', 'permintaans.id_permintaan')
                ->leftJoin('karyawans', 'permintaans.id_nik', '=', 'karyawans.id_nik')
                ->select('karyawans.nama','daftarpermintaans.id_permintaan','permintaans.id_nik','permintaans.tgl_permintaan',DB::raw('count(*) as jumlah_item'),DB::raw('SUM(daftarpermintaans.qty) as jumlah_qty'))
                ->groupBy('daftarpermintaans.id_permintaan')
                ->orderByDesc("daftarpermintaans.id_permintaan")
                ->get();

        $data = array();

        foreach($query as $r){


             $daftar = $this->getDaftarPermintaan($r->id_permintaan);
         $data[] = array(
            'nama'              => $r->nama,
            'id_permintaan'     => $r->id_permintaan,
            'id_nik'            => $r->id_nik,
            'tgl_permintaan'    => $r->tgl_permintaan,
            'jumlah_item'       => $r->jumlah_item,
            'jumlah_qty'        => $r->jumlah_qty,
            'daftarpermintaan'  => $daftar
         );
        }

        return $this->successResponse($data, "Berhasil menampilkan data permintaan");

    }
    public function getDaftarPermintaan($id_permintaan){
        $daftarpermintaan = DB::table('daftarpermintaans')
        ->join('barangs', 'daftarpermintaans.id_barang', '=', 'barangs.id_barang')
        ->select('barangs.nama_barang','daftarpermintaans.id_daftar_permintaan','barangs.satuan','daftarpermintaans.qty','daftarpermintaans.keterangan')
        ->where('daftarpermintaans.id_permintaan',$id_permintaan)
        ->get();

        foreach($daftarpermintaan as $p){
            $daftar[] = array(
                'id_daftar_permintaan'      =>$p->id_daftar_permintaan,
                'nama_barang'               =>$p->nama_barang,
                'satuan'                    =>$p->satuan,
                'qty'                       =>$p->qty,
                'keterangan'                =>$p->keterangan
            );
            }
            return $daftar;
    }
    public function DataKaryawan(){

        $query = DB::table('karyawans')->get();


        foreach($query as $r){
         $data[] = array(
            'nama'              => $r->nama,
            'id_nik'            => $r->id_nik,
            'department'        => $r->department,
         );
        }

        return $this->successResponse($data, "Berhasil menampilkan data karyawan");

    }

    public function DataBarang(){

        $query = DB::table('barangs')->get();


        foreach($query as $r){
         $data[] = array(
            'nama_barang'   => $r->nama_barang,
            'id_barang'     => $r->id_barang,
            'qty'           => $r->qty,
            'lokasi'        => $r->lokasi,
            'ketersediaan'  => $r->ketersediaan,
            'satuan'        => $r->satuan,
         );
        }

        return $this->successResponse($data, "Berhasil menampilkan data barang");

    }
}
