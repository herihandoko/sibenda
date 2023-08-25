<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Admin\DependentDropdownController;
use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\ContactMessage;
use App\Models\DataBencana\DataBencana;
use App\Models\EmailTemplate;
use App\Models\Product;
use App\Models\Subscriber;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;
use App\Models\DataBencana\DataLokasi;
use App\Models\Dokumentasi;
use App\Models\LaporanKejadian;
use App\Models\Master\JenisBencana;
use App\Models\Master\StatusKorban;
use App\Models\Message;
use Laravolt\Indonesia\Models\City;
use Laravolt\Indonesia\Models\District;
use Laravolt\Indonesia\Models\Kabupaten;
use Illuminate\Support\Facades\Crypt;

class HomePageController extends Controller {

    public function index() {
        $status = StatusKorban::select([
                    'm_status_korban.id',
                    'm_status_korban.name',
                    'm_status_korban.icon',
                    DB::raw('COUNT( data_korban.id ) AS ttl_korban')
                ])
                ->leftJoin('data_korban', 'm_status_korban.id', '=', 'data_korban.status_korban_id')
                ->where('m_status_korban.is_deleted', 0)
                ->groupBy('m_status_korban.id', 'm_status_korban.name', 'm_status_korban.icon')
                ->get();
        $ttlBencana = DataBencana::where('is_deleted', 0)->get()->count();
        return view('frontend.home', [
            'status' => $status,
            'ttl_bencana' => $ttlBencana
        ]);
    }

    public function laporankejadian() {
        $jenisBencana = JenisBencana::select('id', 'name', 'icon')->where('is_deleted', 0)->orderBy('name', 'asc')->get();
        $provinces = new DependentDropdownController();
        $provinces = $provinces->provinces();
        return view('frontend.laporankejadian', [
            'jenisbencana' => $jenisBencana,
            'provinces' => $provinces
        ]);
    }

    public function databencana() {
        $jenisBencana = JenisBencana::select('id', 'name', 'icon')->where('is_deleted', 0)->orderBy('name', 'asc')->get();
        $provinces = new DependentDropdownController();
        $provinces = $provinces->provinces();
        return view('frontend.databencana', [
            'jenisbencana' => $jenisBencana,
            'provinces' => $provinces
        ]);
    }

    public function grafik() {
        $jenisBencana = JenisBencana::select(
                        'm_jenis_bencana.id',
                        'm_jenis_bencana.name',
                        'm_jenis_bencana.icon',
                        DB::raw('COUNT( data_bencana.id ) AS ttl_bencana')
                )
                ->leftJoin('data_bencana', 'data_bencana.jenis_bencana_id', '=', 'm_jenis_bencana.id')
                ->where('m_jenis_bencana.is_deleted', 0)
                ->groupBy(
                        'm_jenis_bencana.id',
                        'm_jenis_bencana.name',
                        'm_jenis_bencana.icon'
                )
                ->get();
        $cities = City::select(
                        'indonesia_cities.code',
                        'indonesia_cities.name',
                        DB::raw('COUNT( data_lokasi_bencana.id ) AS ttl_kejadian')
                )
                ->leftJoin('data_lokasi_bencana', 'data_lokasi_bencana.kabupaten', '=', 'indonesia_cities.id')
                ->leftJoin('data_bencana', 'data_bencana.id', '=', 'data_lokasi_bencana.id_databencana')
                ->where('indonesia_cities.province_code', 36)
                ->groupBy(
                        'indonesia_cities.code',
                        'indonesia_cities.name'
                )
                ->get();
        return view('frontend.grafik', [
            'jenisbencana' => $jenisBencana,
            'cities' => $cities
        ]);
    }

    public function kontak() {
        return view('frontend.kontak');
    }

    public function infografis() {
        return view('frontend.infografis');
    }

    public function login_form() {
        return view('frontend.loginIndex');
    }

    public function location() {
        $data = DataLokasi::select('m_jenis_bencana.name', 'data_lokasi_bencana.lat', 'data_lokasi_bencana.long', 'm_jenis_bencana.icon')
                ->join('data_bencana', 'data_bencana.id', '=', 'data_lokasi_bencana.id_databencana')
                ->join('m_jenis_bencana', 'm_jenis_bencana.id', '=', 'data_bencana.jenis_bencana_id')
                ->get();
        $features = [];
        foreach ($data as $key => $value) {
            $features[] = [
                'type' => 'Feature',
                'properties' => [
                    'title' => $value->name,
                    'icon' => url($value->icon)
                ],
                'geometry' => [
                    'type' => 'Point',
                    'coordinates' => [
                        floatval($value->long),
                        floatval($value->lat)
                    ]
                ]
            ];
        }
        $dataLoc = [
            'type' => 'FeatureCollection',
            'features' => $features
        ];
        return response()->json([
                    'status' => 'success',
                    'data' => $dataLoc
        ]);
    }

    public function legends() {
        $jenisBencana = JenisBencana::select('id', 'name', 'icon')->where('is_deleted', 0)->orderBy('name', 'asc')->get();
        $dataJenisBencana = [];
        foreach ($jenisBencana as $key => $value) {
            # code...
            $dataJenisBencana[] = [
                'label' => $value->name,
                'type' => 'image',
                'url' => url($value->icon)
            ];
        }
        return response()->json([
                    'status' => 'success',
                    'data' => $dataJenisBencana
        ]);
    }

    public function news_letter(Request $request) {
        $validator = Validator::make($request->all(), [
                    'email' => 'required|email',
        ]);
        if ($validator->fails()) {
            return response([
                'status' => 'invalid',
            ]);
        }
        if (Subscriber::where(['email' => $request->email])->count()) {
            return response([
                'status' => 'exist',
            ]);
        }
        $subscriber = new Subscriber;
        $subscriber->email = $request->email;
        $subscriber->is_confirmed = 0;
        $subscriber->save();
        $token = Str::random(64);
        DB::table('password_resets')->insert([
            'email' => $request->email,
            'token' => $token,
            'created_at' => Carbon::now()
        ]);
        $link = url('/email-subscribe') . '/' . $token;
        $template = EmailTemplate::find(4);
        $body = str_replace('{link}', $link, str_replace('http://', '', $template->description));
        Mail::send('frontend.emailHtml', ['body' => html_entity_decode($body)], function ($message) use ($request, $template) {
            $message->to($request->email);
            $message->subject($template->subject);
        });
        return response([
            'status' => 'success',
        ]);
    }

    public function news_letter_verify(Request $request) {
        $tokenData = DB::table('password_resets')
                        ->where('token', $request->token)->first();
        if (!$tokenData) {
            toast(trans('frontend.Invalid Token!'), 'error')->width('350px');
            return redirect()->route('home');
        }
        $email = Subscriber::where('email', $tokenData->email)->first();
        if (!$email) {
            toast(trans('frontend.Email not found!'), 'error')->width('350px');
            return redirect()->route('home');
        }
        $email->is_confirmed = 1;
        $email->update();
        DB::table('password_resets')->where('email', $email->email)
                ->delete();
        $template = EmailTemplate::find(6);
        $body = str_replace('{website}', GetSetting('site_name'), $template->description);
        Mail::send('frontend.emailHtml', ['body' => html_entity_decode($body)], function ($message) use ($email, $template) {
            $message->to($email->email);
            $message->subject($template->subject);
        });
        toast(trans('frontend.Email subscribed successfully!'), 'success')->width('350px');
        return redirect()->route('home');
    }

    public function appointment() {
        return view('frontend.appointmentIndex');
    }

    public function appointment_submit(Request $request) {
        if (checkDemo()) {
            trans('frontend.This action is blocked in demo mode!');
            return redirect()->route('home');
        }
        if (ReCaptcha('recaptcha_status') == 1 && !$request->{'g-recaptcha-response'}) {
            toast(trans(trans('frontend.Captcha Required!')), 'error')->width('350px');
            return redirect()->route('home');
        }
        $appointment = new Appointment();
        $appointment->name = $request->name;
        $appointment->email = $request->email;
        $appointment->phone = $request->phone;
        $appointment->appointment_date = $request->date;
        $appointment->message = $request->message;
        $appointment->service_id = $request->service_id;
        $appointment->status = 0;
        $appointment->save();

        toast(trans(trans('frontend.Appointment Requested!')), 'success')->width('400px');

        return redirect()->route('home');
    }

    public function cart_add(Request $request) {
        if ($request->quantity) {
            $qty = $request->quantity;
        } else {
            $qty = 1;
        }
        \Cart::add([
            'id' => $request->product_id,
            'name' => Product::find($request->product_id)->name,
            'qty' => $qty,
            'price' => Product::find($request->product_id)->discount_price ?: Product::find($request->product_id)->price,
            'weight' => 550,
            'options' => []
        ]);
        return response([
            'status' => 'success'
        ]);
    }

    public function cart_remove(Request $request) {
        \Cart::remove($request->item);
        return response([
            'status' => 'success'
        ]);
    }

    public function cart_quantity(Request $request) {
        if ($request->type == 'increment') {
            $request->quantity = $request->quantity + 1;
        } else {
            if ($request->quantity >= 2) {
                $request->quantity = $request->quantity - 1;
            }
        }
        \Cart::update($request->product_id, $request->quantity);
        return response([
            'status' => 'success'
        ]);
    }

    public function cart_clear() {
        \Cart::destroy();
        return response([
            'status' => 'success'
        ]);
    }

    public function contact_message(Request $request) {
        $template = EmailTemplate::find(5);
        $body = str_replace('{name}', $request->name, $template->description);
        $body = str_replace('{email}', $request->email, $body);
        $body = str_replace('{phone}', $request->phone, $body);
        $body = str_replace('{subject}', $request->subject, $body);
        $body = str_replace('{message}', $request->message, $body);
        Mail::send('frontend.emailHtml', ['body' => html_entity_decode($body)], function ($message) use ($request, $template) {
            $message->to($request->email);
            $message->subject($template->subject);
        });
        if (GetSetting('save_contact_message') == 1) {
            $message = new ContactMessage();
            $message->name = $request->name;
            $message->email = $request->email;
            $message->phone = $request->phone;
            $message->subject = $request->subject;
            $message->message = $request->message;
            $message->save();
        }
        toast(trans('frontend.Message Sent!'), 'success')->width('350px');
        return redirect()->back();
    }

    public function store(Request $request) {
        $validator = Validator::make($request->all(), [
                    'full_name' => 'required|max:500',
                    'email' => 'required|email|max:1000',
                    'subject' => 'required|max:1000',
                    'message' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        $model = new Message();
        $model->full_name = $request->full_name;
        $model->email = $request->email;
        $model->subject = $request->subject;
        $model->message = $request->message;
        $model->save();
        return redirect()->back()->with('status', 'Pesan berhasil dikirim!')->withInput();
    }

    public function dokumentasi() {
        $carbon = new Carbon();
        $str = new Str();
        $dokumentasi = Dokumentasi::where('status', 1)->get();
        return view('frontend.dokumentasi', [
            'dokumentasi' => $dokumentasi,
            'carbon' => $carbon,
            'str' => $str
        ]);
    }

    public function fetch_databencana(Request $request) {
        $draw = $request->get('draw');
        $start = $request->get("start");
        $rowperpage = $request->get("length");

        $columnIndex_arr = $request->get('order');
        $columnName_arr = $request->get('columns');
        $order_arr = $request->get('order');
        $search_arr = $request->get('search');

        $columnIndex = $columnIndex_arr[0]['column'];
        $columnName = $columnName_arr[$columnIndex]['data'];
        $columnSortOrder = $order_arr[0]['dir'];
        $searchValue = $search_arr['value'];

        if ($columnName == 'rownum')
            $columnName = 'data_bencana.kode';

        $filter = $request->get("filter");

        $query = DataBencana::select(
                        'data_bencana.id',
                        'data_bencana.kode',
                        DB::raw('m_jenis_bencana.name AS jenis_bencana'),
                        'data_bencana.tgl_kejadian',
                        'data_bencana.jam_kejadian',
                        'data_lokasi_bencana.provinsi',
                        'data_lokasi_bencana.kabupaten',
                        'data_lokasi_bencana.kecamatan',
                        'data_lokasi_bencana.kelurahan',
                        'data_lokasi_bencana.lat',
                        'data_lokasi_bencana.long',
                        'data_lokasi_bencana.lokasi',
                        'data_bencana.penyebab_bencana',
                        'data_bencana.deskripsi_bencana',
                        DB::raw('indonesia_cities.code AS kode_kota'),
                        DB::raw('indonesia_cities.name AS nama_kota'),
                        DB::raw('indonesia_districts.code AS kode_kec'),
                        DB::raw('indonesia_districts.name AS nama_kec'),
                        DB::raw('indonesia_villages.code AS kode_kel'),
                        DB::raw('indonesia_villages.name AS nama_kel')
                )->join('data_lokasi_bencana', 'data_lokasi_bencana.id_databencana', '=', 'data_bencana.id')
                ->join('m_jenis_bencana', 'm_jenis_bencana.id', '=', 'data_bencana.jenis_bencana_id')
                ->join('indonesia_cities', 'indonesia_cities.id', '=', 'data_lokasi_bencana.kabupaten')
                ->join('indonesia_districts', 'indonesia_districts.id', '=', 'data_lokasi_bencana.kecamatan')
                ->join('indonesia_villages', 'indonesia_villages.id', '=', 'data_lokasi_bencana.kelurahan');

        $totalRecords = $query->get()->count();
        $recordsx = $query->where(function ($query) use ($searchValue, $filter) {
                    if ($searchValue)
                        $query->orWhere('m_jenis_bencana.name', 'LIKE', "%" . Str::lower($searchValue) . "%")
                        ->orWhere('indonesia_cities.name', 'LIKE', "%" . Str::lower($searchValue) . "%")
                        ->orWhere('indonesia_districts.name', 'LIKE', "%" . Str::lower($searchValue) . "%")
                        ->orWhere('indonesia_villages.name', 'LIKE', "%" . Str::lower($searchValue) . "%");

                    if (isset($filter['jenis_bencana']))
                        $query->where('data_bencana.jenis_bencana_id', $filter['jenis_bencana']);

                    if (isset($filter['start_date'])) {
                        $query->where('data_bencana.tgl_kejadian', '>=', $filter['start_date']);
                    }

                    if (isset($filter['end_date'])) {
                        $query->where('data_bencana.tgl_kejadian', '<=', $filter['end_date']);
                    }

                    if (isset($filter['start_date']) && isset($filter['end_date'])) {
                        $query->whereBetween('data_bencana.tgl_kejadian', [$filter['start_date'], $filter['end_date']]);
                    }
                    /** provinsi */
                    if (isset($filter['kabupaten']) && ($filter['kabupaten'] != '-- Pilih --'))
                        $query->where('data_lokasi_bencana.kabupaten', $filter['kabupaten']);

                    if (isset($filter['kecamatan']) && ($filter['kecamatan'] != '-- Pilih --'))
                        $query->where('data_lokasi_bencana.kecamatan', $filter['kecamatan']);

                    if (isset($filter['kelurahan']) && ($filter['kelurahan'] != '-- Pilih --'))
                        $query->where('data_lokasi_bencana.kelurahan', $filter['kelurahan']);
                })
                ->get();
        $totalRecordswithFilter = $recordsx->count();

        $records = $query->where(function ($query) use ($searchValue, $filter) {
                    if ($searchValue)
                        $query->orWhere('m_jenis_bencana.name', 'LIKE', "%" . Str::lower($searchValue) . "%")
                        ->orWhere('indonesia_cities.name', 'LIKE', "%" . Str::lower($searchValue) . "%")
                        ->orWhere('indonesia_districts.name', 'LIKE', "%" . Str::lower($searchValue) . "%")
                        ->orWhere('indonesia_villages.name', 'LIKE', "%" . Str::lower($searchValue) . "%");

                    if (isset($filter['jenis_bencana']))
                        $query->where('data_bencana.jenis_bencana_id', $filter['jenis_bencana']);

                    if (isset($filter['start_date'])) {
                        $query->where('data_bencana.tgl_kejadian', '>=', $filter['start_date']);
                    }

                    if (isset($filter['end_date'])) {
                        $query->where('data_bencana.tgl_kejadian', '<=', $filter['end_date']);
                    }

                    if (isset($filter['start_date']) && isset($filter['end_date'])) {
                        $query->whereBetween('data_bencana.tgl_kejadian', [$filter['start_date'], $filter['end_date']]);
                    }
                    /** provinsi */
                    if (isset($filter['kabupaten']) && ($filter['kabupaten'] != '-- Pilih --'))
                        $query->where('data_lokasi_bencana.kabupaten', $filter['kabupaten']);

                    if (isset($filter['kecamatan']) && ($filter['kecamatan'] != '-- Pilih --'))
                        $query->where('data_lokasi_bencana.kecamatan', $filter['kecamatan']);

                    if (isset($filter['kelurahan']) && ($filter['kelurahan'] != '-- Pilih --'))
                        $query->where('data_lokasi_bencana.kelurahan', $filter['kelurahan']);
                })
                ->skip($start)
                ->take($rowperpage)
                ->orderBy($columnName, $columnSortOrder)
                ->get();

        $data_arr = array();
        $rownum = $start + 1;
        $crypt = new Crypt();
        foreach ($records as $record => $value) {
            $data_arr[] = array(
                'id' => $value->id,
                'rownum' => $rownum++,
                'kode' => $value->kode,
                'jenis_bencana' => $value->jenis_bencana,
                'tgl_kejadian' => Carbon::createFromFormat('Y-m-d', $value->tgl_kejadian)->format('d M Y'),
                'jam_kejadian' => $value->jam_kejadian,
                'provinsi' => $value->provinsi,
                'kabupaten' => $value->kabupaten,
                'kecamatan' => $value->kecamatan,
                'kelurahan' => $value->kelurahan,
                'lat' => $value->lat,
                'long' => $value->long,
                'penyebab_bencana' => $value->penyebab_bencana,
                'deskripsi_bencana' => $value->deskripsi_bencana,
                'kode_kota' => $value->kode_kota,
                'nama_kota' => $value->nama_kota,
                'kode_kec' => $value->kode_kec,
                'nama_kec' => $value->nama_kec,
                'kode_kel' => $value->kode_kel,
                'nama_kel' => $value->nama_kel,
                'lokasi' => ($value->lokasi ? $value->lokasi : '-') . ' <a class="btn btn-sm btn-light btn-copy-lokasi" data-toggle="tooltip" data-placement="top" title="Copy Kp./Link." data-value="https://maps.google.com?q=' . $value->lat . ',' . $value->long . '"><i class="fa fa-copy"></i> Copy</a>',
                'dokumentasi' => '<a class="btn btn-success btn-sm" target="_blank" href="' . route('data-bencana.dokumentasi', $crypt::encryptString($value->id)) . '"><i class="fa fa-image"></i> Lihat</a>',
                'koordinat' => '<button class="btn btn-primary btn-sm btn-detail-koordinat" data-lat="' . $value->lat . '" data-lng="' . $value->long . '"><i class="fa fa-map"></i> Lihat</button>'
            );
        }

        $response = array(
            "draw" => intval($draw),
            "iTotalRecords" => $totalRecords,
            "iTotalDisplayRecords" => $totalRecordswithFilter,
            "aaData" => $data_arr
        );
        return response()->json($response);
    }

    public function fetch_chart(Request $request) {
        $jenisBencana = JenisBencana::select(
                        'm_jenis_bencana.id',
                        'm_jenis_bencana.name',
                        'm_jenis_bencana.icon',
                        DB::raw('COUNT( data_bencana.id ) AS ttl_bencana')
                )
                ->leftJoin('data_bencana', function ($join) use ($request) {
                    $join->on('data_bencana.jenis_bencana_id', '=', 'm_jenis_bencana.id');
                    $join->whereYear('data_bencana.tgl_kejadian', '=', $request->tahun);
                })
                ->where('m_jenis_bencana.is_deleted', 0)
                ->groupBy(
                        'm_jenis_bencana.id',
                        'm_jenis_bencana.name',
                        'm_jenis_bencana.icon'
                )
                ->get();
        $label = [];
        $data = [];
        $backcolor = [];
        foreach ($jenisBencana as $key => $value) {
            $label[] = $value->name;
            $data[] = $value->ttl_bencana;
            $backcolor[] = '#' . substr(str_shuffle('ABCDEF0123456789'), 0, 6);
        }

        $response = [
            'labels' => $label,
            'datasets' => [
                [
                    'label' => $request->tahun,
                    'data' => $data,
                    'backgroundColor' => $backcolor,
                    'borderRadius' => 5,
                ],
            ]
        ];
        return response()->json($response);
    }

    public function chart_city(Request $request) {
        $label = [];
        $data = [];
        $backcolor = [];
        $cities = City::select(
                        'indonesia_cities.id',
                        'indonesia_cities.name',
                        DB::raw('COUNT( data_bencana.id ) AS ttl_kejadian')
                )
                ->leftJoin('data_lokasi_bencana', 'data_lokasi_bencana.kabupaten', '=', 'indonesia_cities.id')
                ->leftJoin('data_bencana', function ($join) use ($request) {
                    $join->on('data_bencana.id', '=', 'data_lokasi_bencana.id_databencana');
                    $join->whereYear('data_bencana.tgl_kejadian', '=', $request->tahun);
                })
                ->where('indonesia_cities.province_code', 36)
                ->groupBy(
                        'indonesia_cities.id',
                        'indonesia_cities.name'
                )
                ->get();

        foreach ($cities as $key => $value) {
            $label[] = $value->name;
            $data[] = $value->ttl_kejadian;
            $backcolor[] = '#' . substr(str_shuffle('ABCDEF0123456789'), 0, 6);
        }
        $response = [
            'labels' => $label,
            'datasets' => [
                [
                    'label' => $request->tahun,
                    'data' => $data,
                    'backgroundColor' => $backcolor,
                    'borderRadius' => 5,
                ],
            ]
        ];
        return response()->json($response);
    }

    public function laporan_fetch(Request $request) {
        $draw = $request->get('draw');
        $start = $request->get("start");
        $rowperpage = $request->get("length");

        $columnIndex_arr = $request->get('order');
        $columnName_arr = $request->get('columns');
        $order_arr = $request->get('order');
        $search_arr = $request->get('search');

        $columnIndex = $columnIndex_arr[0]['column'];
        $columnName = $columnName_arr[$columnIndex]['data'];
        $columnSortOrder = $order_arr[0]['dir'];
        $searchValue = $search_arr['value'];

        if ($columnName == 'rownum')
            $columnName = 'id';

        $filter = $request->get("filter");

        $query = LaporanKejadian::select(
                        'data_laporan_kejadian.id',
                        'data_laporan_kejadian.jenis_bencana',
                        'data_laporan_kejadian.tgl_kejadian',
                        'data_laporan_kejadian.waktu_kejadian',
                        'data_laporan_kejadian.lokasi_kejadian',
                        'data_laporan_kejadian.penyebab_bencana',
                        'data_laporan_kejadian.dampak_bencana_rr',
                        'data_laporan_kejadian.dampak_bencana_rs',
                        'data_laporan_kejadian.dampak_bencana_rb',
                        'data_laporan_kejadian.korban_jiwa_md',
                        'data_laporan_kejadian.korban_jiwa_lr',
                        'data_laporan_kejadian.korban_jiwa_lb',
                        'data_laporan_kejadian.pengungsi_jiwa',
                        'data_laporan_kejadian.pengungsi_kk',
                        'data_laporan_kejadian.nama_pelapor',
                        'data_laporan_kejadian.telp_pelapor',
                        'data_laporan_kejadian.email_pelapor',
                        'data_laporan_kejadian.dokumentasi',
                        'data_laporan_kejadian.kondisi_umum',
                        'data_laporan_kejadian.kegiatan',
                        'data_laporan_kejadian.kendala',
                        'data_laporan_kejadian.created_at',
                        'data_laporan_kejadian.updated_at',
                        'data_laporan_kejadian.lat',
                        'data_laporan_kejadian.lng',
                        'data_laporan_kejadian.nomor_laporan',
                        'data_laporan_kejadian.status',
                        DB::raw('indonesia_cities.code AS kode_kota'),
                        DB::raw('indonesia_cities.name AS nama_kota'),
                        DB::raw('indonesia_districts.code AS kode_kec'),
                        DB::raw('indonesia_districts.name AS nama_kec'),
                        DB::raw('indonesia_villages.code AS kode_kel'),
                        DB::raw('indonesia_villages.name AS nama_kel')
                )->join('indonesia_cities', 'indonesia_cities.id', '=', 'data_laporan_kejadian.kabupaten')
                ->join('indonesia_districts', 'indonesia_districts.id', '=', 'data_laporan_kejadian.kecamatan')
                ->join('indonesia_villages', 'indonesia_villages.id', '=', 'data_laporan_kejadian.kelurahan');

        $totalRecords = $query->get()->count();
        $recordsx = $query->where(function ($query) use ($searchValue, $filter) {
                    if ($searchValue)
                        $query->orWhere('jenis_bencana', 'LIKE', "%" . Str::lower($searchValue) . "%");

                    if (isset($filter['jenis_bencana']))
                        $query->where('jenis_bencana', $filter['jenis_bencana']);

                    if (isset($filter['start_date'])) {
                        $query->where('tgl_kejadian', '>=', $filter['start_date']);
                    }

                    if (isset($filter['end_date'])) {
                        $query->where('tgl_kejadian', '<=', $filter['end_date']);
                    }

                    if (isset($filter['start_date']) && isset($filter['end_date'])) {
                        $query->whereBetween('tgl_kejadian', [$filter['start_date'], $filter['end_date']]);
                    }
                    /** provinsi */
                    if (isset($filter['kabupaten']) && ($filter['kabupaten'] != '-- Pilih --'))
                        $query->where('data_laporan_kejadian.kabupaten', $filter['kabupaten']);

                    if (isset($filter['kecamatan']) && ($filter['kecamatan'] != '-- Pilih --'))
                        $query->where('data_laporan_kejadian.kecamatan', $filter['kecamatan']);

                    if (isset($filter['kelurahan']) && ($filter['kelurahan'] != '-- Pilih --'))
                        $query->where('data_laporan_kejadian.kelurahan', $filter['kelurahan']);
                })
                ->get();

        $totalRecordswithFilter = $recordsx->count();

        $records = $query->where(function ($query) use ($searchValue, $filter) {
                    if ($searchValue)
                        $query->orWhere('jenis_bencana', 'LIKE', "%" . Str::lower($searchValue) . "%");

                    if (isset($filter['jenis_bencana']))
                        $query->where('jenis_bencana', $filter['jenis_bencana']);

                    if (isset($filter['start_date'])) {
                        $query->where('tgl_kejadian', '>=', $filter['start_date']);
                    }

                    if (isset($filter['end_date'])) {
                        $query->where('tgl_kejadian', '<=', $filter['end_date']);
                    }

                    if (isset($filter['start_date']) && isset($filter['end_date'])) {
                        $query->whereBetween('tgl_kejadian', [$filter['start_date'], $filter['end_date']]);
                    }
                    /** provinsi */
                    if (isset($filter['kabupaten']) && ($filter['kabupaten'] != '-- Pilih --'))
                        $query->where('data_laporan_kejadian.kabupaten', $filter['kabupaten']);

                    if (isset($filter['kecamatan']) && ($filter['kecamatan'] != '-- Pilih --'))
                        $query->where('data_laporan_kejadian.kecamatan', $filter['kecamatan']);

                    if (isset($filter['kelurahan']) && ($filter['kelurahan'] != '-- Pilih --'))
                        $query->where('data_laporan_kejadian.kelurahan', $filter['kelurahan']);
                })
                ->skip($start)
                ->take($rowperpage)
                ->orderBy($columnName, $columnSortOrder)
                ->get();

        $data_arr = array();
        $rownum = $start + 1;
        foreach ($records as $record => $value) {
            $data_arr[] = array(
                'rownum' => $rownum++,
                'jenis_bencana' => $value->jenis_bencana,
                'tgl_kejadian' => $value->tgl_kejadian,
                'waktu_kejadian' => $value->waktu_kejadian,
                'lokasi_kejadian' => ($value->lokasi_kejadian ? $value->lokasi_kejadian : '-') . ' <a class="btn btn-sm btn-light btn-copy-lokasi" data-toggle="tooltip" data-placement="top" title="Copy Kp./Link." data-value="https://maps.google.com?q=' . $value->lat . ',' . $value->lng . '"><i class="fa fa-copy"></i> Copy</a>',
                'penyebab_bencana' => $value->penyebab_bencana,
                'dampak_bencana_rr' => $value->dampak_bencana_rr,
                'dampak_bencana_rs' => $value->dampak_bencana_rs,
                'dampak_bencana_rb' => $value->dampak_bencana_rb,
                'korban_jiwa_md' => $value->korban_jiwa_md,
                'korban_jiwa_lr' => $value->korban_jiwa_lr,
                'korban_jiwa_lb' => $value->korban_jiwa_lb,
                'pengungsi_jiwa' => $value->pengungsi_jiwa,
                'pengungsi_kk' => $value->pengungsi_kk,
                'nama_pelapor' => $value->nama_pelapor,
                'telp_pelapor' => $value->telp_pelapor,
                'email_pelapor' => $value->email_pelapor,
                'dokumentasi' => $value->dokumentasi,
                'kondisi_umum' => $value->kondisi_umum,
                'kegiatan' => $value->kegiatan,
                'kendala' => $value->kendala,
                'created_at' => $value->created_at,
                'updated_at' => $value->updated_at,
                'lat' => $value->lat,
                'lng' => $value->lng,
                'nomor_laporan' => $value->nomor_laporan,
                'status' => '<span class="badge-laporan">' . ucfirst($value->status) . '</span>',
                'kode_kota' => $value->kode_kota,
                'nama_kota' => $value->nama_kota,
                'kode_kec' => $value->kode_kec,
                'nama_kec' => $value->nama_kec,
                'kode_kel' => $value->kode_kel,
                'nama_kel' => $value->nama_kel,
                'lokasi' => '<a class="btn btn-warning btn-sm btn-detail-lokasi" data-lat="' . $value->lat . '" data-lng="' . $value->lng . '" style="margin-top:-4px !important;"><i class="fa fa-map-marker"></i> Lihat</a>'
            );
        }

        $response = array(
            "draw" => intval($draw),
            "iTotalRecords" => $totalRecords,
            "iTotalDisplayRecords" => $totalRecordswithFilter,
            "aaData" => $data_arr
        );
        return response()->json($response);
    }

    public function laporan_add() {
        $provinces = new DependentDropdownController();
        $provinces = $provinces->provinces();
        return view('frontend.laporanform', [
            'provinces' => $provinces
        ]);
    }

    public function laporan_store(Request $request) {
        $validator = Validator::make($request->all(), [
                    'g-recaptcha-response' => 'recaptcha',
                    'jenis_bencana' => 'required|max:255|min:5',
                    'tgl_kejadian' => 'required|date_format:Y-m-d|before:tomorrow',
                    'waktu_kejadian' => 'required|date_format:H:i',
                    'lokasi_kejadian' => 'required|max:1000',
                    'penyebab_bencana' => 'required|max:1000',
                    'dampak_bencana_rr' => 'numeric|min:0|nullable',
                    'dampak_bencana_rs' => 'numeric|min:0|nullable',
                    'dampak_bencana_rb' => 'numeric|min:0|nullable',
                    'korban_jiwa_md' => 'numeric|min:0|nullable',
                    'korban_jiwa_lr' => 'numeric|min:0|nullable',
                    'korban_jiwa_lb' => 'numeric|min:0|nullable',
                    'pengungsi_jiwa' => 'numeric|min:0|nullable',
                    'pengungsi_kk' => 'numeric|min:0|nullable',
                    'nama_pelapor' => 'required|max:500|min:3',
                    'telp_pelapor' => 'required|max:18|min:1',
                    'email_pelapor' => 'email',
                    'provinsi' => 'required',
                    'kabupaten' => 'required',
                    'kecamatan' => 'required',
                    'kelurahan' => 'required',
                    'image' => 'required|image|mimes:jpeg,png,jpg|max:2048',
                    'lat' => 'required',
                    'lng' => 'required'
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        $imageName = time() . '.' . $request->image->extension();
        $request->image->storeAs('public/bpbd/laporan/' . date('Ym'), $imageName);
        $data = $request->except(['_token', 'image']);
        $data['dokumentasi'] = '/storage/bpbd/laporan/' . date('Ym') . '/' . $imageName;
        $data['status'] = 'terkirim';
        $ttlCurrentReport = LaporanKejadian::count();
        $data['nomor_laporan'] = date('Ymd') . '-' . str_pad($ttlCurrentReport + 1, 5, "0", STR_PAD_LEFT);
        ;
        LaporanKejadian::create($data);
        return redirect()->route('laporankejadian')->with('success', 'Laporan Bencana Berhasil Dikirim Untuk di Tindaklanjuti. Terima kasih.');
        ;
    }

    public function dokumentasi_detail($slug) {
        $dokumen = Dokumentasi::where('slug', $slug)->first();
        $carbon = new Carbon();
        $str = new Str();
        $dokumentasi = Dokumentasi::where('status', 1)->where('slug', '!=', $slug)->inRandomOrder()->limit(5)->get();
        return view('frontend.detail', [
            'dokumen' => $dokumen,
            'carbon' => $carbon,
            'str' => $str,
            'dokumentasi' => $dokumentasi
        ]);
    }

    public function kabkota() {
        $cities = City::select('code', 'name', 'color')->where('province_code', 36)->get();
        $data = [];
        foreach ($cities as $key => $city) {
            $data[$city->code] = [
                'code' => $city->code,
                'name' => $city->name,
                'color' => $city->color
            ];
        }
        return response()->json([
                    'status' => 'success',
                    'data' => $data
        ]);
    }

    public function detail_data($slug) {
        $id = Crypt::decryptString($slug);
        $data = DataBencana::select(
                        'data_bencana.id',
                        'data_bencana.kode',
                        'data_bencana.image_1',
                        'data_bencana.image_2',
                        'data_bencana.image_3',
                        'data_bencana.image_4',
                        'data_bencana.image_5',
                        'data_bencana.image_6',
                        DB::raw('m_jenis_bencana.name AS jenis_bencana'),
                        'data_bencana.tgl_kejadian',
                        'data_bencana.jam_kejadian',
                        'data_lokasi_bencana.provinsi',
                        'data_lokasi_bencana.kabupaten',
                        'data_lokasi_bencana.kecamatan',
                        'data_lokasi_bencana.kelurahan',
                        'data_lokasi_bencana.lat',
                        'data_lokasi_bencana.long',
                        'data_bencana.penyebab_bencana',
                        'data_bencana.deskripsi_bencana',
                        DB::raw('indonesia_cities.code AS kode_kota'),
                        DB::raw('indonesia_cities.name AS nama_kota'),
                        DB::raw('indonesia_districts.code AS kode_kec'),
                        DB::raw('indonesia_districts.name AS nama_kec'),
                        DB::raw('indonesia_villages.code AS kode_kel'),
                        DB::raw('indonesia_villages.name AS nama_kel')
                )->join('data_lokasi_bencana', 'data_lokasi_bencana.id_databencana', '=', 'data_bencana.id')
                ->join('m_jenis_bencana', 'm_jenis_bencana.id', '=', 'data_bencana.jenis_bencana_id')
                ->join('indonesia_cities', 'indonesia_cities.id', '=', 'data_lokasi_bencana.kabupaten')
                ->join('indonesia_districts', 'indonesia_districts.id', '=', 'data_lokasi_bencana.kecamatan')
                ->join('indonesia_villages', 'indonesia_villages.id', '=', 'data_lokasi_bencana.kelurahan')
                ->where('data_bencana.id', $id)
                ->first();
        $carbon = new Carbon();
        $str = new Str();
        return view('frontend.detaildatabencana', [
            'dokumen' => $data,
            'carbon' => $carbon,
            'str' => $str
        ]);
    }
}
