<?php

namespace App\Http\Controllers;

use App\Http\Requests\BankDetailRequest;
use App\Http\Requests\UpdateBankRequest;
use App\Models\BankDetail;
use App\Models\PendingInfo;
use Illuminate\Http\Request;

class BankDetailController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $bank_details = PendingInfo::where('bank_detail_id', $id)->where('status', PendingInfo::STATUS_PENDING)->first();
        if ($bank_details) return api_success_app($bank_details);
        return api_error_app('not found');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateBankRequest $request)
    {
        $pending_info = PendingInfo::where('bank_detail_id', $request->bank_detail_id)->where('status', PendingInfo::STATUS_PENDING)->first();
        if ($request->status == PendingInfo::STATUS_APPROVED && $pending_info) {
            $bank_details = BankDetail::where('rider_id', request()->rider->rider_id)->first();
            $bank_details->account = $pending_info->account;
            $bank_details->bank    = $pending_info->bank;
            $bank_details->agency  = $pending_info->agency;
            $bank_details->account_verification_code = $pending_info->verification_code;
            $pending_info->status = PendingInfo::STATUS_APPROVED;
            $pending_info->save();
            if ($bank_details->save()) return api_success_app('Bank details updated Successfully');
            return api_error_app('Bank details did not updated ');
        } elseif ($request->status == PendingInfo::STATUS_REJECTED && $pending_info) {
            $pending_info->status = PendingInfo::STATUS_REJECTED;
            $pending_info->comment = $request->comment;
            if ($pending_info->save()) return api_success_app('Bank details Rejected');
        }
        return api_error_app();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
