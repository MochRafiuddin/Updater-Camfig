<?php

namespace App\Http\Controllers\Api;

use App\Models\MVersioning;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CApi extends Controller
{
    // Mengambil semua data
    function get_version()
    {
        $version = request()->input('version', '0'); // Default '0' jika tidak ada parameter
        $subversion = request()->input('subversion', '0');
        $sequence = request()->input('sequence_version', '0');
        
        // $data = MVersioning::orderBy('version', 'desc')        
        // ->orderBy('subversion', 'desc')
        // ->first();
        
        // // $version = $data->version . '.' . $data->subversion . '.' . $data->sequence_version;
        // if($data->versi > $version){
        //     $sequence = 0;
		// 	$subversion = 1;
		// 	$version = $data->versi;
		// }
		// if($data->subversion > $subversion){
        //     $sequence = 0;
		// 	$subversion = $data->subversion;
		// }

        
        $dataVersi = MVersioning::where('version', '>=', $version)
        ->where('subversion','>=', $subversion)
        ->where('sequence_version', '>=', $sequence)
        ->orderBy('version', 'asc')
        ->orderBy('subversion', 'asc')
        ->where("released", 1)
        ->get();
        
        $requestedVersion = $version . '.' . $subversion . '.' . $sequence;
        $lastVersion = $dataVersi->last();

        // Jika ada data versi terakhir, format versinya, jika tidak maka kosong
        $lastVersionString = $lastVersion ? $lastVersion->version . '.' . $lastVersion->subversion . '.' . $lastVersion->sequence_version : '0.0.0';
        
        return response()->json([
            'success' => true,
            'message' => 'Success',
            'code' => 1,
            'version' => $lastVersionString,
            'data' => $dataVersi
        ]);
    }

    // Fungsi untuk download file dari public/source
    function downloadFile()
    {
        // Tentukan path file di folder public/source
        $filePath = public_path('source/releaseApp.zip');

        // Cek apakah file ada
        if (!file_exists($filePath)) {
            return response()->json([
                'success' => false,
                'message' => 'File not found',
                'code' => 0,
            ], 404);
        }

        // Mengembalikan file untuk di-download
        return response()->download($filePath);
    }
}
