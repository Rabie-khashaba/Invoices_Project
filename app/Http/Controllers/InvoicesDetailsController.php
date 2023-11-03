<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\Invoice_attachments;
use App\Models\Invoices_details;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;


class InvoicesDetailsController extends Controller
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
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Invoices_details $invoices_details)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $invoices = Invoice::where('id',$id)->first();   // first --> لان هجيب صف واحد فقط
        $details  = invoices_Details::where('id_Invoice',$id)->get();  // git --> invoices_Details لان احتمال يكون  هناك اكتر من
        $attachments  = Invoice_attachments::where('invoice_id',$id)->get();

        return view('invoices.details_invoice',compact('invoices','details','attachments'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Invoices_details $invoices_details)
    {
        //
    }



    public function destroy(Request $request)
    {
        //return $request;
        $invoices = Invoice_attachments::findOrFail($request->id_file);
        //return $invoices;
        $invoices->delete();
        Storage::disk('public_uploads')->delete($request->invoice_number.'/'.$request->file_name);
        $notification = array(
            'message' => 'Attachment deleted successfully',
            'alert-type'=> 'error',
        );
        return redirect()->route('invoices.index')->with($notification);
    }

    public function get_file($invoice_number,$file_name)

    {
        return response()->download(public_path('Attachments'.'/'.$invoice_number.'/'.$file_name));
    }


    public function open_file($invoice_number,$file_name)
    {
        return response()->file(public_path('Attachments'.'/'.$invoice_number.'/'.$file_name));
    }


}
