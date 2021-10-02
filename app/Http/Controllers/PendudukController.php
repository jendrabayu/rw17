<?php

namespace App\Http\Controllers;

use App\DataTables\PendudukDataTable;
use App\Exports\PendudukExport;
use App\Http\Requests\Penduduk\PendudukStoreRequest;
use App\Http\Requests\Penduduk\PendudukUpdateRequest;
use App\Models\Agama;
use App\Models\Darah;
use App\Models\Keluarga;
use App\Models\Pekerjaan;
use App\Models\Pendidikan;
use App\Models\Penduduk;
use App\Models\Rt;
use App\Models\StatusHubunganDalamKeluarga;
use App\Models\StatusPerkawinan;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;
use PhpOffice\PhpSpreadsheet\Reader\Csv;
use PhpOffice\PhpSpreadsheet\Reader\Xls;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx;

class PendudukController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, PendudukDataTable $pendudukDataTable)
    {
        $rt = auth()->user()->rt->rw->rt->pluck('nomor', 'id');
        $agama = Agama::all()->pluck('nama', 'id');
        $darah = Darah::all()->pluck('nama', 'id');
        $pekerjaan = Pekerjaan::all()->pluck('nama', 'id');
        $statusPerkawinan = StatusPerkawinan::all()->pluck('nama', 'id');
        $pendidikan = Pendidikan::all()->pluck('nama', 'id');
        $statusHubunganDalamKeluarga = StatusHubunganDalamKeluarga::all()->pluck('nama', 'id');
        $fileTypes = Penduduk::FILE_TYPES;

        return $pendudukDataTable->render('penduduk.index', compact(
            'rt',
            'agama',
            'darah',
            'pekerjaan',
            'statusPerkawinan',
            'pendidikan',
            'statusHubunganDalamKeluarga',
            'fileTypes'
        ));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $user = auth()->user();
        $rt = $user->rt;
        $keluarga = Keluarga::whereRtId($user->rt_id)->get()->pluck('nomor', 'id');
        $agama = Agama::all()->pluck('nama', 'id');
        $darah = Darah::all()->pluck('nama', 'id');
        $pekerjaan = Pekerjaan::all()->pluck('nama', 'id');
        $statusPerkawinan = StatusPerkawinan::all()->pluck('nama', 'id');
        $pendidikan = Pendidikan::all()->pluck('nama', 'id');
        $statusHubunganDalamKeluarga = StatusHubunganDalamKeluarga::all()->pluck('nama', 'id');

        return view('penduduk.create', compact(
            'keluarga',
            'rt',
            'agama',
            'darah',
            'pekerjaan',
            'statusPerkawinan',
            'pendidikan',
            'statusHubunganDalamKeluarga'
        ));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PendudukStoreRequest $request)
    {
        $validated = $request->validated();
        if ($request->file('foto_ktp')) {
            $validated['foto_ktp'] = $request->file('foto_ktp')->store('ktp', 'public');
        }

        Penduduk::create($validated);

        return back()->withSuccess('Berhasil menambahkan penduduk');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Penduduk $penduduk)
    {
        $user = auth()->user();
        if ($user->hasRole('rt') && $penduduk->keluarga->rt_id !== $user->rt_id) {
            abort(404);
        }

        return view('penduduk.show', compact('penduduk'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Penduduk $penduduk)
    {
        $user = auth()->user();

        if ($user->hasRole('rt') && $penduduk->keluarga->rt_id !== $user->rt_id) {
            abort(404);
        }

        $rt = $user->rt;
        $keluarga = Keluarga::whereRtId($user->rt_id)->get()->pluck('nomor', 'id');
        $agama = Agama::all()->pluck('nama', 'id');
        $darah = Darah::all()->pluck('nama', 'id');
        $pekerjaan = Pekerjaan::all()->pluck('nama', 'id');
        $statusPerkawinan = StatusPerkawinan::all()->pluck('nama', 'id');
        $pendidikan = Pendidikan::all()->pluck('nama', 'id');
        $statusHubunganDalamKeluarga = StatusHubunganDalamKeluarga::all()->pluck('nama', 'id');

        return view('penduduk.edit', compact(
            'keluarga',
            'rt',
            'agama',
            'darah',
            'pekerjaan',
            'statusPerkawinan',
            'pendidikan',
            'statusHubunganDalamKeluarga',
            'penduduk'
        ));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(PendudukUpdateRequest $request, Penduduk $penduduk)
    {
        $validated = $request->validated();
        if ($request->file('foto_ktp')) {
            $validated['foto_ktp'] = $request->file('foto_ktp')->store('ktp', 'public');
            Storage::disk('public')->delete($penduduk->foto_ktp);
        }

        $penduduk->update($validated);

        return back()->withSuccess('Penduduk berhasil diupdate');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Penduduk $penduduk)
    {
        Storage::disk('public')->delete($penduduk->foto_ktp);
        $penduduk->delete();

        return response()->json(['success' => true], 204);
    }

    public function export(Request $request)
    {
        if (is_null($request->file_type) || !in_array($request->file_type, Penduduk::FILE_TYPES)) {
            return back()->withError('Tipe file harus ' . join(',', Penduduk::FILE_TYPES));
        }

        $user = auth()->user();
        $penduduk = Penduduk::filter();

        if ($user->hasRole('rt')) {
            $penduduk->whereHas('keluarga', function ($q) use ($user) {
                $q->whereRtId($user->rt_id);
            });
            $filename = 'Penduduk_RT_' . $user->rt->nomor;
        }

        if ($user->hasRole(['admin', 'rw'])) {
            $penduduk
                ->whereHas('keluarga.rt', function ($q) use ($user) {
                    $q->whereRwId($user->rt->rw_id);
                })
                ->when($request->has('rt'), function ($q) {
                    $q->whereHas('keluarga.rt', function ($q) {
                        $q->where('id', request()->get('rt'));
                    });
                });

            if ($request->has('rt')) {
                $noRt = Rt::where('id', $request->get('rt'))->firstOrFail()->nomor;
                $filename = 'Penduduk_RT_' . $noRt;
            } else {
                $filename = 'Penduduk';
            }
        }

        $penduduk = $penduduk->orderBy('keluarga_id')->get();
        $filename = "{$filename}.{$request->file_type}";

        return Excel::download(new PendudukExport($penduduk),  $filename);
    }

    public function import(Request $request)
    {
        $request->validate([
            'file_penduduk' => ['file', 'mimes:xlsx,csv,xls', 'required', 'max:1024']
        ]);

        $format = $request->file('file_penduduk')->getClientOriginalExtension();

        if ($format === 'xlsx') {
            $reader = new Xlsx();
        } else if ($format === 'xls') {
            $reader = new Xls();
        } else if ($format === 'csv') {
            $reader = new Csv();
        }

        $spreadsheet  = $reader->load($request->file('file_penduduk'));
        $penduduk = $spreadsheet->getSheet(0)->toArray();
        $headings = array_shift($penduduk);
        array_walk($penduduk, function (&$row) use ($headings) {
            $row = array_combine($headings, $row);
            $penduduk[] = $row;
        });

        $penduduk = collect($penduduk);

        try {
            $penduduk = $penduduk->map(function ($item) {
                $rt = Rt::where('nomor', 'like', "%{$item['no_rt']}%")->first();
                $gol_darah = Darah::where('nama', 'like', "%{$item['gol_darah']}%")->first();
                $agama = Agama::where('nama', 'like', "%{$item['agama']}%")->first();
                $pekerjaan = Pekerjaan::where('nama', 'like', "%{$item['pekerjaan']}%")->first();
                $pendidikan = Pendidikan::where('nama', 'like', "%{$item['pendidikan']}%")->first();
                $statusPerkawinan = StatusPerkawinan::where('nama', 'like', "%{$item['status_perkawinan']}%")->first();
                $statusHubunganDalamKeluarga = StatusHubunganDalamKeluarga::where('nama', 'like', "%{$item['status_hubungan_dalam_keluarga']}%")->first();

                $rt_id = $rt ? $rt->id : null;
                $gol_darah_id = $gol_darah ? $gol_darah->id : null;
                $agama_id = $agama ? $agama->id : null;
                $pekerjaan_id = $pekerjaan ? $pekerjaan->id : null;
                $pendidikan_id = $pendidikan ? $pendidikan->id : null;
                $status_perkawinan_id = $statusPerkawinan ? $statusPerkawinan->id : null;
                $status_hubungan_dalam_keluarga_id = $statusHubunganDalamKeluarga ? $statusHubunganDalamKeluarga->id : null;

                return [
                    'rt_id' => $rt_id,
                    'nomor' => $item['no_kk'],
                    'alamat' => $item['alamat'],
                    'agama_id' => $agama_id,
                    'darah_id' => $gol_darah_id,
                    'pekerjaan_id' => $pekerjaan_id,
                    'status_perkawinan_id' => $status_perkawinan_id,
                    'pendidikan_id' => $pendidikan_id,
                    'status_hubungan_dalam_keluarga_id' => $status_hubungan_dalam_keluarga_id,
                    'kewarganegaraan' => 1,
                    'nik' => $item['nik'],
                    'nama' =>  $item['nama'],
                    'tempat_lahir' => $item['tempat_lahir'],
                    'tanggal_lahir' => $item['tanggal_lahir'],
                    'jenis_kelamin' => $item['jenis_kelamin'],
                    'no_paspor' =>  $item['no_paspor'],
                    'no_kitas_kitap' =>  $item['no_kitas_kitap'],
                    'nama_ayah' =>  $item['nama_ayah'],
                    'nama_ibu' =>  $item['nama_ibu'],
                    'email' =>  $item['email'],
                    'no_hp' =>  $item['no_hp'],
                ];
            });
        } catch (Exception $e) {
            return back()->withErrors($e->getMessage())->withInput();
        }

        $user = auth()->user();

        if ($user->hasRole('rt')) {
            $penduduk = $penduduk->filter(function ($item)  use ($user) {
                return $item['rt_id'] === $user->rt->id;
            });
        }

        DB::beginTransaction();

        try {
            $penduduk->each(function ($item) {
                $keluarga = Keluarga::where('nomor', $item['nomor'])->first();
                if ($keluarga === null) {
                    $keluarga = Keluarga::create($item);
                }

                $item['keluarga_id'] = $keluarga->id;
                $penduduk = Penduduk::where('nik', $item['nik'])->first();

                if ($penduduk === null) {
                    Penduduk::create($item);
                }
            });
            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            return redirect()->back()->withErrors($e->getMessage())->withInput();
        }

        return back()->withSuccess('Data penduduk berhasil disimpan ke database');
    }
}
