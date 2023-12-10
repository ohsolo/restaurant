<?php

namespace App\Http\Controllers;

use App\Http\Requests\BackDetailsRequest;
use App\Http\Requests\BankDetailRequest;
use App\Http\Requests\RiderDetailRequest;
use App\Mail\BankDetailRequestMail;
use App\Mail\RiderDetailRequestMail;
use App\Models\BankDetail;
use App\Models\PendingInfo;
use App\Models\Rider;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;

class PendingInfoController extends Controller
{
    public function index()
    {
        //
    }

    public function create()
    {
        //
    }

    public function store(RiderDetailRequest $request)
    {
        $check = PendingInfo::where('rider_id', request()->rider->rider_id)->where('status', PendingInfo::STATUS_PENDING)->first();
        if ($check) return api_error_app('You have already request for this operation. Please wait for it to complete or get rejected.');

        $rider                  = new PendingInfo;
        $rider->pending_info_id = Str::uuid();
        $rider->cpf             = $request->cpf;
        $rider->phone           = $request->phone;
        $rider->name            = $request->name;
        $rider->rider_id        = request()->rider->rider_id;
        $rider->status          = PendingInfo::STATUS_PENDING;
        if ($rider->save())
        {
            $rider_data = Rider::where('rider_id', request()->rider->rider_id)->first();
            $rider_data->addFlag(Rider::FLAG_DETAILS_CHANGE_REQUESTED);
            $rider_data->save();

            Mail::to(config('credentials.admin_email_address'))->send(new RiderDetailRequestMail($rider));
            if (count(Mail::failures()) > 0) return api_error('email couldn\'t send!', 400);
            return api_success_app('Riders details Add Successfully Update When Admin Approve');
        }
        return api_error_app('Riders details did not Add');
    }

    public function bank_details(BankDetailRequest $request, $bank_detail)
    {
        $check = PendingInfo::where('bank_detail_id', $bank_detail)->where('status', PendingInfo::STATUS_PENDING)->first();
        if ($check) return api_error_app('Details Already Added Contact Admin to Approve');

        $bank_details = new PendingInfo();
        $bank_details->pending_info_id = Str::uuid();
        $bank_details->account = $request->account;
        $bank_details->bank    = $request->bank;
        $bank_details->bank_detail_id = $bank_detail;
        $bank_details->agency  = $request->agency;
        $bank_details->verification_code = $request->digit;
       
        if ($bank_details->save())
        {
            Mail::to(config('credentials.admin_email_address'))->send(new BankDetailRequestMail($bank_details));
            if (count(Mail::failures()) > 0) return api_error('email couldn\'t send!', 400);
             return api_success_app('Bank details Add Successfully Update When Admin Approve');
        }
        return api_error_app('Bank details did not Add');

       
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\PendingInfo  $pendingInfo
     * @return \Illuminate\Http\Response
     */
    public function show(PendingInfo $pendingInfo)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\PendingInfo  $pendingInfo
     * @return \Illuminate\Http\Response
     */
    public function edit(PendingInfo $pendingInfo)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\PendingInfo  $pendingInfo
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, PendingInfo $pendingInfo)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\PendingInfo  $pendingInfo
     * @return \Illuminate\Http\Response
     */
    public function destroy(PendingInfo $pendingInfo)
    {
        //
    }
}
