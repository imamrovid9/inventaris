<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Perangkat;
use App\Roleuser;
use App\Skpd;
use App\User;
use App\Inventaris;

use Illuminate\Support\Facades\Validator;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $data['menu'] = "masterperangkat";
        return view('home', $data);
    }



    public function skpd()
    {
        $data['menu'] = "masterskpd";
        $data['skpd'] = Skpd::get();
        return view('auth.master.index', $data);
    }

    public function createskpd(Request $request)
    {
        // return $request;

        $rules = array(

            'name' => 'required|max:191',
            'alamat' => 'required|string|max:191',
            'telepon' => 'required|numeric|min:11',
            'pembuat' => 'required',
            'kota'          => 'required',

        );

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
            dd($validator);
        } else {
            $skpd = new Skpd();
            $skpd->namaskpd = $request->name;
            $skpd->alamat = $request->alamat;
            $skpd->tlp = $request->telepon;
            $skpd->kota = $request->kota;
            $skpd->pembuat = $request->pembuat;
            $skpd->save();
            return back()->withSuccess('Success Add Skpd');
        }
    }

    public function deleteskpd($id)
    {
        $skpd = Skpd::find($id);
        $skpd->delete();
        return back()->withSuccess('Success Delete Skpd');
    }

    //Master Skpd

    public function perangkat()
    {
        $data['menu'] = "masterperangkat";
        $data['perangkat'] = Perangkat::get();
        return view('auth.master.perangkat', $data);
    }

    public function createperangkat(Request $request)
    {
        // return $request;

        $rules = array(

            'perangkat' => 'required|max:191',
            'jenis' => 'required|string|max:191',
            'pembuat' => 'required',

        );

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
            dd($validator);
        } else {
            $perangkat = new Perangkat();
            $perangkat->namaperangkat = $request->perangkat;
            $perangkat->jenis = $request->jenis;
            $perangkat->pembuat = $request->pembuat;
            $perangkat->save();
            return back()->withSuccess('Success Add Perangkat');
        }
    }

    public function deleteperangkat($id)
    {
        $perangkat = Perangkat::find($id);
        $perangkat->delete();
        return back()->withSuccess('Success Delete Perangkat');
    }

    public function inventaris()
    {
        $data['menu'] = "inventaris";
        $data['inventaris']  = Inventaris::get();
        $data['perangkat'] = Perangkat::get();
        $data['skpd'] = Skpd::get();
        return view('auth.inventaris.index', $data);
    }
    public function createinventaris(Request $request)
    {

        $rules = array(

            'namaskpd' => 'required|max:191',
            'namaperangkat' => 'required|max:191',
            'jumlahperangkat' => 'integer',
            'tanggal' => 'required|max:191',
            'pembuat' => 'required|max:191',
            'keterangan' => 'required',

        );

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
            dd($validator);
        } else {
            $time = strtotime($request->tanggal);
            $newformat = date('Y-m-d', $time);
            $inventaris = new Inventaris();
            $inventaris->namaskpd = $request->namaskpd;
            $inventaris->namaperangkat = $request->namaperangkat;
            $inventaris->jumlah = $request->jumlahperangkat;
            $inventaris->pembuat = $request->pembuat;
            $inventaris->tanggal = $newformat;
            $inventaris->deskripsi = $request->keterangan;
            $inventaris->save();
            return back()->withSuccess('Success Add Perangkat');
        }
    }

    public function deleteinventaris($id)
    {
        $inventaris = Inventaris::find($id);
        $inventaris->delete();
        return back()->withSuccess('Success Delete Inventaris');
    }
    public function laporan()
    {
        $data['menu'] = "laporan";
        if (isset($_GET['filter'])) {
            if (isset($_GET['skpd'])) {
                $namaskpd = $_GET['skpd'];
            } else {
                $namaskpd = '-';
            }
            $dateeee = explode("-", $_GET['filter']);
            $from = date("d-m-Y", strtotime($dateeee[0]));
            $from1 = date("d-m-Y", strtotime($dateeee[1]));
            $fromasd = date("Y-m-d", strtotime($from));
            $fromasd1 = date("Y-m-d", strtotime($from1));

            if ($fromasd != null and $fromasd1 != null and $namaskpd == null) {
                $data['inventaris']  = Inventaris::whereDate('inventaris.created_at', '>=', $fromasd)->whereDate('inventaris.created_at', '<=', $fromasd1)
                    ->join('skpds', 'skpds.id', '=', 'inventaris.skpd_id')
                    ->join('perangkats', 'perangkats.id', '=', 'inventaris.perangkat_id')
                    ->select('skpds.namaskpd', 'perangkats.namaperangkat', 'inventaris.*', 'skpds.alamat', 'skpds.tlp', 'skpds.kota')
                    ->get();
                $data['fromasd'] = $fromasd;
                $data['fromasd1'] = $fromasd1;
                $data['namaskpd'] = '-';

                $data['print'] = "1";
                $data['bisa_print'] = "yes";
                $data['skpdnow'] = $namaskpd;
                $data['skpdlist']      = Skpd::get();
            } elseif ($fromasd == null and $fromasd1 == null and $namaskpd != null) {
                $data['inventaris']  = Inventaris::join('skpds', 'skpds.id', '=', 'inventaris.skpd_id')->where('skpds', 'skpds.id', '=', $namaskpd)
                    ->join('perangkats', 'perangkats.id', '=', 'inventaris.perangkat_id')
                    ->select('skpds.namaskpd', 'perangkats.namaperangkat', 'inventaris.*', 'skpds.alamat', 'skpds.tlp', 'skpds.kota')
                    ->get();

                $data['namaskpd'] = $namaskpd;
                $data['print'] = "2";
                $data['bisa_print'] = "yes";
                $data['skpdnow'] = $namaskpd;
                $data['skpdlist']      = Skpd::get();
            } elseif ($fromasd != null and $fromasd1 != null and $namaskpd != null) {
                $data['inventaris']  = Inventaris::whereDate('inventaris.created_at', '>=', $fromasd)->whereDate('inventaris.created_at', '<=', $fromasd1)
                    ->join('skpds', 'skpds.id', '=', 'inventaris.skpd_id')->where('skpds.id', '=', $namaskpd)
                    ->join('perangkats', 'perangkats.id', '=', 'inventaris.perangkat_id')
                    ->select('skpds.namaskpd', 'perangkats.namaperangkat', 'inventaris.*', 'skpds.alamat', 'skpds.tlp', 'skpds.kota')
                    ->get();

                $data['namaskpd'] = $namaskpd;
                $data['fromasd'] = $fromasd;
                $data['fromasd1'] = $fromasd1;
                $data['print'] = "3";
                $data['bisa_print'] = "yes";
                $data['skpdnow'] = $namaskpd;
                $data['skpdlist']    = Skpd::get();
            }
        } else {
            $data['inventaris']  = Inventaris::join('skpds', 'skpds.id', '=', 'inventaris.skpd_id')
                ->join('perangkats', 'perangkats.id', '=', 'inventaris.perangkat_id')
                ->select('skpds.namaskpd', 'perangkats.namaperangkat', 'inventaris.*', 'skpds.alamat', 'skpds.tlp', 'skpds.kota')
                ->get();

            $data['namaskpd'] = '-';
            $data['skpdnow'] = "-";
            $data['print'] = "-";
            $data['bisa_print'] = "no";
            $data['skpdlist']      = Skpd::get();
        }
        return view('multiauth::admin.laporan.index', $data);
    }
    public function laporanprint(Request $request)
    {
        $fromasd = $request->fromasd;
        $fromasd1 = $request->fromasd1;
        $namaskpd = $request->namaskpd;

        if ($request->print == '1') {
            $inventaris = Inventaris::whereDate('inventaris.created_at', '>=', $fromasd)->whereDate('inventaris.created_at', '<=', $fromasd1)
                ->join('skpds', 'skpds.id', '=', 'inventaris.skpd_id')
                ->join('perangkats', 'perangkats.id', '=', 'inventaris.perangkat_id')
                ->select('skpds.namaskpd', 'perangkats.namaperangkat', 'perangkats.jenis', 'inventaris.*', 'skpds.alamat', 'skpds.tlp', 'skpds.kota')
                ->get();

            $asd = Inventaris::whereDate('inventaris.created_at', '>=', $fromasd)->whereDate('inventaris.created_at', '<=', $fromasd1)
                ->join('skpds', 'skpds.id', '=', 'inventaris.skpd_id')
                ->join('perangkats', 'perangkats.id', '=', 'inventaris.perangkat_id')
                ->select('skpds.namaskpd', 'perangkats.namaperangkat', 'perangkats.jenis', 'inventaris.*', 'skpds.alamat', 'skpds.tlp', 'skpds.kota')
                ->first();
        } elseif ($request->print == '2') {
            $inventaris = Inventaris::join('skpds', 'skpds.id', '=', 'inventaris.skpd_id')->where('skpds', 'skpds.id', '=', $namaskpd)
                ->join('perangkats', 'perangkats.id', '=', 'inventaris.perangkat_id')
                ->select('skpds.namaskpd', 'perangkats.namaperangkat', 'perangkats.jenis',  'inventaris.*', 'skpds.alamat', 'skpds.tlp', 'skpds.kota')
                ->get();

            $asd = Inventaris::join('skpds', 'skpds.id', '=', 'inventaris.skpd_id')->where('skpds', 'skpds.id', '=', $namaskpd)
                ->join('perangkats', 'perangkats.id', '=', 'inventaris.perangkat_id')
                ->select('skpds.namaskpd', 'perangkats.namaperangkat', 'perangkats.jenis',  'inventaris.*', 'skpds.alamat', 'skpds.tlp', 'skpds.kota')
                ->first();
        } elseif ($request->print == "3") {
            $inventaris = Inventaris::whereDate('inventaris.created_at', '>=', $fromasd)->whereDate('inventaris.created_at', '<=', $fromasd1)
                ->join('skpds', 'skpds.id', '=', 'inventaris.skpd_id')->where('skpds.id', '=', $namaskpd)
                ->join('perangkats', 'perangkats.id', '=', 'inventaris.perangkat_id')
                ->select('skpds.namaskpd', 'perangkats.namaperangkat', 'perangkats.jenis', 'inventaris.*', 'skpds.alamat', 'skpds.tlp', 'skpds.kota')
                ->get();

            $asd = Inventaris::whereDate('inventaris.created_at', '>=', $fromasd)->whereDate('inventaris.created_at', '<=', $fromasd1)
                ->join('skpds', 'skpds.id', '=', 'inventaris.skpd_id')->where('skpds.id', '=', $namaskpd)
                ->join('perangkats', 'perangkats.id', '=', 'inventaris.perangkat_id')
                ->select('skpds.namaskpd', 'perangkats.namaperangkat', 'perangkats.jenis', 'inventaris.*', 'skpds.alamat', 'skpds.tlp', 'skpds.kota')
                ->first();
        }


        $nama_pembuat = auth()->user()->username == null ? auth()->user()->name : auth()->user()->username;
        $time = now();
        $mpdf = new \Mpdf\Mpdf();
        $html = '<p style="text-align: center;"><strong>Laporan SKPD</strong></p><hr><p style="text-align: left;"><br></p><p style="text-align: left;">
        <span style="font-size: 12px;">Tanggal : ' . $time . ' &nbsp;</span></p><p style="text-align: left;">
        <span style="font-size: 12px;">Nama Pembuat Laporan : ' . $nama_pembuat . '&nbsp;</span></p><hr><p><span style="font-size: 12px;"><br></span></p><p>
        <span style="font-size: 12px;">Nama Skpd : ' . $asd->namaskpd . '&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; Telp Skpd : ' . $asd->tlp . '</span></p><p><span style="font-size: 12px;">Alamat Skpd : ' . $asd->alamat . '&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; Kota Skpd : ' . $asd->kota . '</span></p><p><span style="font-size: 12px;">Pembuat Skpd :' . $asd->pembuat . '</span></p><p><span style="font-size: 12px;"><br></span></p><p><span style="font-size: 12px;">URAIAN PERANGKAT</span></p><hr><p><br></p>
        <style>
            table {
                border-collapse: collapse;
            }

            table, td, th {
                border: 1px solid black;
                text-align: center;
            }
        </style>
        <table style="width: 100%; border="1"">
        <tbody>
            <tr>
                <td style="width: 16.6667%;">
                    <div style="text-align: center; ">
                        Nama Perangkat
                    </div>
                </td>
                <td style="width: 16.6667%;">
                    <div style="text-align: center;">
                        Jenis Perangkat
                    </div>
                </td>
                <td style="width: 16.6667%;">
                    <div style="text-align: center;">
                        Jumlah
                    </div>
                </td>
                <td style="width: 16.6667%;">
                    <div style="text-align: center;">
                        Deskripsi</div>
                </td>
                <td style="width: 16.6667%;">
                <div style="text-align: center;">
                    Pembuat Inventaris</div>
                </td>
                <td style="width: 16.6667%;">
                <div style="text-align: center;">
                    Tanggal Inventaris</div>
                </td>
            </tr>';

        foreach ($inventaris as $inven) {
            $html .=
                '<tr>
                <td style="width: 16.6667%;">
                    <div style="text-align: center; ">
                    ' . $inven->namaperangkat . '
                    </div>
                </td>
                <td style="width: 16.6667%;">
                    <div style="text-align: center;">
                       ' . $inven->jenis . '
                    </div>
                </td>
                <td style="width: 16.6667%;">
                    <div style="text-align: center;">
                       ' . $inven->jumlah . '
                    </div>
                </td>
                <td style="width: 16.6667%;">
                    <div style="text-align: center;">
                    ' . $inven->deskripsi . '
                        </div>
                </td>
                <td style="width: 16.6667%;">
                <div style="text-align: center;">
                ' . $inven->pembuat . '
                    </div>
                </td>
                <td style="width: 16.6667%;">
                <div style="text-align: center;">
                ' . $inven->tanggal . '
                    </div>
                </td>
            </tr>';
        }
        $html .= '





        </tbody>
        </table>
        <p><br></p><p><br></p><p><br></p><p><br></p><p><br></p><p><br></p><p><br></p><p><br></p><p>&nbsp; &nbsp; &nbsp; &nbsp; Pembuat &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; Admin</p><p><br></p><p>(................................) &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; (................................)</p>';
        $mpdf->WriteHTML($html);
        $mpdf->Output();
    }
}
