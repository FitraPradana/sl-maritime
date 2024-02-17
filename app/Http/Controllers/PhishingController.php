<?php

namespace App\Http\Controllers;

use Mail;
use App\Mail\PhisingEmail;
use App\Models\Phising;
use App\Models\PhisingDetected;
use App\Models\PhisingTarget;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\DataTables;

class PhishingController extends Controller
{
    public function index()
    {
        return view('ITManagement.phising.index');
    }

    public function phisingdetected(Request $request)
    {
        if ($request->ajax()) {
            $phisings = DB::connection('mysql')
                ->table('phising_detecteds');

            // Tambahkan filter sesuai kebutuhan
            // if ($request->role_name_filter != '') {
            //     $phisings->where('phisings.name', 'like', '%' . $request->role_name_filter . '%');
            // }

            $phisings->orderByDesc('phising_detecteds.updated_at');
            $query = $phisings->get();

            return DataTables::of($query)
                ->addColumn('action', function ($data) {
                    return '
                <div class="form group" align="center">
                    <button type="button" onclick="deleteData(`' . route('phisingdetected.delete', $data->id) . '`)" class="btn btn-xs btn-danger btn-sm"><i class="fa fa-trash"></i></button>
                </div>
            ';
                })
                ->addColumn('created_at', function ($data) {
                    return Carbon::parse($data->created_at)->format('d M Y H:i:s');
                })
                ->addColumn('updated_at', function ($data) {
                    return Carbon::parse($data->updated_at)->format('d M Y H:i:s');
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('ITManagement.phising.PhisingDetected.data');
    }

    public function phisingdetected_save(Request $request)
    {
        DB::beginTransaction();
        try {
            $validator = Validator::make($request->all(), [
                'username_detected' => 'required',
                'password_detected' => 'required',
                'g-recaptcha-response' => 'recaptcha',
            ]);

            if ($validator->fails()) {
                Alert::error('recaptcha', 'Invalid reCAPTCHA response');
                return redirect()->back()->with(['errors' => 'Invalid reCAPTCHA response']);
            } else {
                $dataPhising = PhisingDetected::create([
                    'phising_type'      => 'HRIS SLM',
                    'username_detected' => $request->input('username_detected'),
                    'password_detected' => $request->input('password_detected'),
                    'remarks_phising'   => '-'
                ]);

                DB::commit();
                // Alert::success('ALERT PHISING', 'Anda terkena tipuan phising, segera ganti password account anda atau hubungi HRD !');
                return redirect()->back()->with(['success' => 'Anda terkena tipuan phising, segera ganti password account HRIS anda atau segera hubungi HRD !']);
            }
        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
        }
    }

    public function phisingtarget(Request $request)
    {
        if ($request->ajax()) {
            $phisings = DB::connection('mysql')
                ->table('phising_targets');

            // Tambahkan filter sesuai kebutuhan
            // if ($request->role_name_filter != '') {
            //     $phisings->where('phisings.name', 'like', '%' . $request->role_name_filter . '%');
            // }

            $phisings->orderByDesc('phising_targets.updated_at');
            $query = $phisings->get();

            return DataTables::of($query)
                ->addColumn('action', function ($data) {
                    if ($data->is_sendMail == 'no') {
                        return '
                        <div class="form group" align="center">
                            <button type="button" onclick="sendEmail(`' . route('phisingtarget.mail', $data->id) . '`)" class="btn btn-xs btn-dark btn-sm"><i class="fa fa-paper-plane"></i> Send Email</button>
                            <button type="button" onclick="deleteData(`' . route('phisingtarget.delete', $data->id) . '`)" class="btn btn-xs btn-danger btn-sm"><i class="fa fa-trash"></i></button>
                        </div>
                        ';
                    } else {
                        return '
                        <div class="form group" align="center">
                            <button type="button" onclick="deleteData(`' . route('phisingtarget.delete', $data->id) . '`)" class="btn btn-xs btn-danger btn-sm"><i class="fa fa-trash"></i></button>
                        </div>
                        ';
                    }
                })
                ->addColumn('created_at', function ($data) {
                    return Carbon::parse($data->created_at)->format('d M Y H:i:s');
                })
                ->addColumn('updated_at', function ($data) {
                    return Carbon::parse($data->updated_at)->format('d M Y H:i:s');
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        $PhisingTarget = PhisingTarget::all();
        return view('ITManagement.phising.PhisingTarget.data', compact('PhisingTarget'));
    }

    public function phisingtarget_save(Request $request)
    {
        DB::beginTransaction();
        try {
            $validator = Validator::make($request->all(), [
                'phising_type' => 'required',
                'no_absent_target' => 'required',
                'name_target' => 'required',
                'email_target' => 'required',
            ]);

            if ($validator->fails()) {
                Alert::error('recaptcha', 'Invalid reCAPTCHA response');
                return redirect()->back()->with(['errors' => 'Invalid reCAPTCHA response']);
            }

            $dataPhising = PhisingTarget::create([
                'phising_type'      => $request->input('phising_type'),
                'no_absent_target'  => $request->input('no_absent_target'),
                'name_target'       => $request->input('name_target'),
                'email_target'      => $request->input('email_target'),
                'is_sendMail'       => 'no',
            ]);

            DB::commit();
            Alert::success('Success', 'Data berhasil disimpan !');
            return redirect()->back()->with(['success' => 'Data berhasil disimpan !']);
        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
        }
    }

    public function phisingtarget_delete($id)
    {
        $data = PhisingTarget::find($id);
        $del = $data->delete();
        return response()->json([]);
    }

    public function phisingdetected_delete($id)
    {
        $data = PhisingDetected::find($id);
        $del = $data->delete();
        return response()->json([]);
    }


    public function phisingtarget_mail($id)
    {
        $PhisingTarget = PhisingTarget::where('id', $id)->first();

        if ($PhisingTarget->phising_type == 'Gaji-Bulanan') {
            $mailData = [
                'email' => $PhisingTarget->email_target,
                'title' => 'Payslip Feb 2024 - PT Sinarmas LDA Usaha Pelabuhan',
                'no_absent_target' => $PhisingTarget->no_absent_target,
                'name_target' => $PhisingTarget->name_target,
                'email_target' => $PhisingTarget->email_target,
            ];
            $mailData["PhisingTarget"] = PhisingTarget::where('id', $id)->first();

            $pdf = Pdf::loadView('emails.getphising_gajibulanan', $mailData);
            $pdf->get_canvas()->get_cpdf()->setEncryption("userpassword", "adminpassword");

            Mail::send('emails.getphising_gajibulanan', $mailData, function ($message) use ($mailData, $pdf, $PhisingTarget) {
                $message->to($mailData["email"], $mailData["email"])
                    ->subject($mailData["title"])
                    ->attachData($pdf->output(), "$PhisingTarget->no_absent_target ______$PhisingTarget->name_target _J_3M12.pdf");
            });

            $updatePhisingTarget = PhisingTarget::where('id', $id)->first();
            $updatePhisingTarget->update([
                'is_sendMail' => 'yes'
            ]);
        } else if ($PhisingTarget->phising_type == 'Kenaikan-Gaji') {

            $mailData = [
                'email' => $PhisingTarget->email_target,
                'title' => 'Payslip Feb 2024 - PT Sinarmas LDA Usaha Pelabuhan',
                'no_absent_target' => $PhisingTarget->no_absent_target,
                'name_target' => $PhisingTarget->name_target,
                'email_target' => $PhisingTarget->email_target,
            ];
            $mailData["PhisingTarget"] = PhisingTarget::where('id', $id)->first();

            Mail::send('emails.getphising_kenaikangaji', $mailData, function ($message) use ($mailData) {
                $message->to($mailData["email"], $mailData["email"])
                    ->subject($mailData["title"]);
            });

            $updatePhisingTarget = PhisingTarget::where('id', $id)->first();
            $updatePhisingTarget->update([
                'is_sendMail' => 'yes'
            ]);
        }

        return response()->json([
            'phising_type' => $PhisingTarget->phising_type,
            'no_absent_target' => $PhisingTarget->no_absent_target,
            'name_target' => $PhisingTarget->name_target,
            'email_target' => $PhisingTarget->email_target,
            'is_sendMail' => $PhisingTarget->is_sendMail,
        ]);
    }
}
