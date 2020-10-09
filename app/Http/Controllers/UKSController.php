<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Session;


class UKSController extends Controller
{
    public function index(Request $request)
    {	$riwayat;
		$noinduk = $request->session()->get('noinduk');
		if($request->session()->get('usertype')==0)
			$riwayat= DB::select('SELECT * FROM riwayat JOIN user ON riwayat.nisn = user.noinduk ORDER by waktu DESC');
		elseif ($request->session()->get('usertype')==1)
			$riwayat= DB::select('SELECT * FROM riwayat JOIN user ON riwayat.nisn = user.noinduk WHERE riwayat.nisn = '.$noinduk.' ORDER by waktu DESC');
		$siswa= DB::select('SELECT * FROM user WHERE usertype = 1 ORDER BY nama ASC');
		return view('index',compact('riwayat','siswa'));
		
    }
	
	public function edit(Request $request){
		$update = DB::table('riwayat')
              ->where('id', $request->id)
              ->update(['keterangan' => $request->keterangan]);
		return redirect('/')->with('notif', 'Perubahan Data berhasil disimpan!');
	}
	
	public function hapus(Request $request){
		$hapus = DB::table('riwayat')
              ->where('id', $request->id)
              ->delete();
		return redirect('/')->with('notif', 'Data berhasil dihapus!');
	}
	
	public function tambah(Request $request){
		$tambah = DB::table('riwayat')->insert(
				['nisn' => $request->nisn, 'keterangan' => $request->keterangan]
			  );
		return redirect('/')->with('notif', 'Data berhasil ditambahkan!');
	}

	// public function cetak(Request $request){
	// 	if(isset($_POST['btn_pdf']))
    // {
    //     require('fpdf.php');

    //     $pdf = new FPDF();
    //     $pdf->AddPage();
    //     $pdf->SetFont('Arial','B',16);
    //     $pdf->Cell(40,10,'Hello World!');
    //     $pdf->Output();
    // }
		

		

	// }
		
	public function login(){
		return view('login');
	}
	
	public function auth(Request $request)
    {
		$noinduk= DB::table('user')->where('noinduk', '=', $request->noinduk)->value('noinduk');
		$usertype= DB::table('user')->where('noinduk', '=', $request->noinduk)->value('usertype');
		if($request->noinduk==$noinduk){
			Session::put('noinduk',$noinduk);
			Session::put('usertype',$usertype);
			return redirect('/');
		}
		else{
			return redirect('/login')->with('error', 'No.Induk Tidak Ditemukan!');
		}

    }

	public function logout(){
        Session::flush();
        return redirect('/login')->with('error','Anda berhasil Keluar!');
    }
}
