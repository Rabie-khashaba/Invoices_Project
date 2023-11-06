<?php

namespace App\Http\Controllers;

use App\Models\invoice;
use App\Models\Invoice_attachments;
use App\Models\Invoices_details;
use App\Models\Section;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class InvoicesController extends Controller
{

    public function index()
    {
        $invoices = invoice::all();
        return view('invoices.invoices',compact('invoices'));
    }

    public function create()
    {
        $sections = Section::all();
        return view('invoices.add_invoice',compact('sections'));
    }

    public function store(Request $request)
    {

        DB::beginTransaction();
        try {

            //main invoices Table
            Invoice::create([
                'invoice_number' => $request->invoice_number,
                'invoice_Date' => $request->invoice_Date,
                'Due_date' => $request->Due_date,
                'product' => $request->product,
                'section_id' => $request->Section,
                'Amount_collection' => $request->Amount_collection,
                'Amount_Commission' => $request->Amount_Commission,
                'Discount' => $request->Discount,
                'Value_VAT' => $request->Value_VAT,
                'Rate_VAT' => $request->Rate_VAT,
                'Total' => $request->Total,
                'Status' => 'غير مدفوعة',
                'Value_Status' => 2,
                'note' => $request->note,
            ]);


            $invoice_id = Invoice::latest()->first()->id;
            Invoices_details::create([
                'id_Invoice' => $invoice_id,
                'invoice_number' => $request->invoice_number,
                'product' => $request->product,
                'Section' => $request->Section,
                'Status' => 'غير مدفوعة',
                'Value_Status' => 2,
                'note' => $request->note,
                'user' => (Auth::user()->name),
            ]);



            if ($request->hasFile('pic')) {

                $invoice_id = Invoice::latest()->first()->id;
                $image = $request->file('pic');
                $file_name = $image->getClientOriginalName();
                $invoice_number = $request->invoice_number;

                $attachments = new invoice_attachments();
                $attachments->file_name = $file_name;
                $attachments->invoice_number = $invoice_number;
                $attachments->Created_by = Auth::user()->name;
                $attachments->invoice_id = $invoice_id;
                $attachments->save();

                // move pic
                $imageName = $request->pic->getClientOriginalName();
                $request->pic->move(public_path('Attachments/' . $invoice_number), $imageName);
            }


            DB::commit();
//            $notification = array(
//                'message' => 'invoices Saved successfully',
//                'alert-type'=> 'success',
//            );
//            return redirect()->route('invoices.index')->with($notification);

            session()->flash('Store_invoice');
            return redirect('/invoices');

        }catch (\Exception $e){
            DB::rollback();
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    public function show(string $id)
    {
        //
    }

    public function edit($id)
    {
        //return $id;
        $invoices = Invoice::findOrFail($id);
        $sections = Section::all();
        //return $sections;
        return view('invoices.edit_invoice',compact('invoices','sections'));
    }

    public function update(Request $request)
    {

        DB::beginTransaction();
        try {
            $invoices = Invoice::findOrFail($request->invoice_id);
            $invoices->update([
                'invoice_number' => $request->invoice_number,
                'invoice_Date' => $request->invoice_Date,
                'Due_date' => $request->Due_date,
                'product' => $request->product,
                'section_id' => $request->Section,
                'Amount_collection' => $request->Amount_collection,
                'Amount_Commission' => $request->Amount_Commission,
                'Discount' => $request->Discount,
                'Value_VAT' => $request->Value_VAT,
                'Rate_VAT' => $request->Rate_VAT,
                'Total' => $request->Total,
                'note' => $request->note,
            ]);

            $invoicesDetails = Invoices_details::where('id_Invoice',$request->invoice_id)->first();
            $invoicesDetails->update([
               'id_Invoice'=>$request->invoice_id,
               'invoice_number'=>$request->invoice_number,
               'product'=>$request->product,
               'Section'=>$request->Section,
               'Status' => 'غير مدفوعة',
               'Value_Status' => 2,
               'note' => $request->note,
               'user' => (Auth::user()->name),
            ]);

            DB::commit();
            $notification = array(
                'message' => 'invoices Updated successfully',
                'alert-type'=> 'info',
            );
            return redirect()->route('invoices.index')->with($notification);

        }catch (\Exception $e){
            DB::rollback();
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }

    }

    public function destroy(Request $request)
    {
        $invoice = Invoice::where('id',$request->invoice_id)->first();
        //return $invoice;
        $attachmentDetails = Invoice_attachments::where('invoice_id',$request->invoice_id)->first();
        //return $attachmentDetails;


        if($request->id_page == 1){

            if(!empty($attachmentDetails->invoice_number)){
                Storage::disk('public_uploads')->deleteDirectory($attachmentDetails->invoice_number);
            }
            $invoice->forceDelete();

            $notification = array(
                'message' => 'invoice Deleted successfully',
                'alert-type'=> 'error',
            );
            return redirect()->route('invoices.index')->with($notification);


        }else{
            $invoice->delete();
            $notification = array(
                'message' => 'invoice Added to Archive',
                'alert-type'=> 'info',
            );
            return redirect()->route('invoices.index')->with($notification);
        }
    }


    // get products by Ajax
    public function getProducts($id)
    {
        $products = DB::table("products")->where("section_id", $id)->pluck("Product_name", "id");
        return json_encode($products);
    }
}
