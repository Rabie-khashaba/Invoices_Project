<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\Invoice_attachments;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class InvoiceAttachmentsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        //return $request;

        $this->validate($request, [

            'file_name' => 'mimes:pdf,jpeg,png,jpg',

        ], [
            'file_name.mimes' => 'صيغة المرفق يجب ان تكون   pdf, jpeg , png , jpg',
        ]);


        if($request->hasFile('file_name')) {
            $image = $request->file('file_name');
            $file_name = $image->getClientOriginalName();


            $attachments = new invoice_attachments();
            $attachments->file_name = $file_name;
            $attachments->invoice_number = $request->invoice_number;
            $attachments->Created_by = Auth::user()->name;
            $attachments->invoice_id = $request->invoice_id;
            $attachments->save();

            // move pic
            $imageName = $request->file_name->getClientOriginalName();
            $request->file_name->move(public_path('Attachments/' . $request->invoice_number), $imageName);

            $notification = array(
                'message' => 'Attachments Saved successfully',
                'alert-type'=> 'success',
            );
            return redirect()->route('invoices.index')->with($notification);
        }

    }
    /**
     * Display the specified resource.
     */
    public function show(Invoice_attachments $invoice_attachments)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Invoice_attachments $invoice_attachments)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Invoice_attachments $invoice_attachments)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Invoice_attachments $invoice_attachments)
    {
        //
    }
}
