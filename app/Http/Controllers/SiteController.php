<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

// Laravel
use App;
use Cookie;
use Session;
use Storage;
use Validator;

class SiteController extends Controller
{
    // =======================|              |=======================  //
    // =======================|     SITE     |=======================  //
    // =======================|              |=======================  //

    protected $filename = 'site/static.json';

    // GET
    public function siteSettings() {
        try {
            $settings = $this->getStaticJson();
            return view('admin.settings.site', compact('settings'));
        } catch (\Throwable $th) {
            $this->setStaticJson(null);
            return redirect()->route('admin.site');
        }
    }

    // POST
    public function siteUpdateSettings(Request $request) {
        $validator = Validator::make($request->all(), [
            'link-facebook' => 'nullable|string|url',
            'link-twitter' => 'nullable|string|url',
            'link-instagram' => 'nullable|string|url',
            'link-youtube' => 'nullable|string|url',
            'link-google-maps' => 'nullable|string|url',
            'use-facebook' => 'nullable',
            'use-twitter' => 'nullable',
            'use-instagram' => 'nullable',
            'use-youtube' => 'nullable',
            'use-google-maps' => 'nullable',
            'use-header' => 'nullable',
            'use-footer' => 'nullable',
            'template-email-approval-accepted' => 'nullable|string',
            'template-email-approval-rejected' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Change "true" is string to true is boolean
        $request['use-facebook'] = json_decode($request['use-facebook']);
        $request['use-twitter'] = json_decode($request['use-twitter']);
        $request['use-instagram'] = json_decode($request['use-instagram']);
        $request['use-youtube'] = json_decode($request['use-youtube']);
        $request['use-google-maps'] = json_decode($request['use-google-maps']);
        $request['use-header'] = json_decode($request['use-header']);
        $request['use-footer'] = json_decode($request['use-footer']);

        if ($this->setStaticJson($request)) {
            Session::flash('success', trans('messages.session:success-update-site'));
        } else {
            Session::flash('failure', trans('messages.session:failure-update-site'));
        }
        return redirect()->back();
    }

    // SELF
    public function setStaticJson($request)
    {
        $json = collect([
            'links' => [
                'social-media' => [
                    'facebook' => [
                        'use' => $request['use-facebook'] ?? true,
                        'link' => $request['link-facebook'] ?? config('app.url'),
                    ],
                    'twitter' => [
                        'use' => $request['use-twitter'] ?? true,
                        'link' => $request['link-twitter'] ?? config('app.url'),
                    ],
                    'instagram' => [
                        'use' => $request['use-instagram'] ?? true,
                        'link' => $request['link-instagram'] ?? config('app.url'),
                    ],
                    'youtube' => [
                        'use' => $request['use-youtube'] ?? true,
                        'link' => $request['link-youtube'] ?? config('app.url'),
                    ],
                ],
                'google-maps' => [
                    'use' => $request['use-google-maps'] ?? true,
                    'link' => $request['link-google-maps'] ?? config('app.url'),
                ],
            ],
            'ui' => [
                'header' => $request['use-header'] ?? true,
                'footer' => $request['use-footer'] ?? true
            ],
            'template' => [
                'email' => [
                    'approval' => [
                        'accepted' => $request['template-email-approval-accepted'] ?? "Hai,
Selamat !!
Anda telah diterima Magang di Bea Cukai Jember. Kami dengan senang hati mengundang Anda untuk melaksanakan Magang Praktik Kerja Lapangan di kantor kami.
Untuk mengonfirmasi tempat Anda di Kantor kami, silakan unduh surat tugas yang kami lampirkan dibawah ini.
Jika Anda telah berubah pikiran sejak mendaftar dan ingin menolak penerimaan pendaftaran ini, silakan balas email dengan alasan yang jelas sesegera mungkin.
Sekali lagi, Selamat. Kami akan menghubungi Anda mengenai program terperinci segera.
Salam hormat
Tim Bea Cukai Jember",
                        'rejected' => $request['template-email-approval-rejected'] ?? "Hai,
Atas nama tim Bea Cukai Jember, kami mengucapkan terima kasih atas minat dan antusiasme Anda dalam mendaftar Magang di kantor kami.
Sayangnya, kami ingin meminta maaf bahwa kami tidak dapat melanjutkan pendaftaran Anda karena beberapa hal yang tidak memenuhi kualifikasi kami.
Namun, Anda masih dapat mendaftar sebagai peserta kami lagi. kami membuka lowongan magang lagi di tanggal yang sudah tertera di surat lampiran dan anda dapat mulai mendaftarkan diri seperti langkah diawal.
Salam hormat
Tim Bea Cukai Jember"
                    ]
                ]
            ]
        ]);
        
        try {
            Storage::disk('local')->put($this->filename, $json);
            return true;
        } catch (\Throwable $th) {
            return false;
        }
    }

    // SELF
    public function getStaticJson()
    {
        return json_decode(Storage::disk('local')->get($this->filename), true);
    }

    // =======================|                      |=======================  //
    // =======================|     LOCALIZATION     |=======================  //
    // =======================|                      |=======================  //

    // GET
    public function setLocale($locale)
    {
        App::setLocale($locale);
        Cookie::queue(Cookie::forever('locale', App::getLocale()));
        return redirect()->back();
    }

    // =======================|              |=======================  //
    // =======================|     PAGE     |=======================  //
    // =======================|              |=======================  //

    // GET
    public function pageNotFound()
    {
        return view('errors.404');
    }

    // =======================|               |=======================  //
    // =======================|     OTHER     |=======================  //
    // =======================|               |=======================  //

    // GET
    public function download($location)
    {
        $path = base64_decode($location);
        if (Storage::exists($path)) {
            return Storage::download($path);
        } else {
            abort(404);
        }
    }
}