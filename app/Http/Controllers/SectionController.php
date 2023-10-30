<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreSectionRequest;
use App\Models\Section;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SectionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $sections = Section::all();
       // return $sections;
        return view('sections.sections',compact('sections'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreSectionRequest $request)
    {

        //التاكد من  وجود  القسم مسبقا
//        $b_exists = Section::where('section_name','=',$request->section_name)->exists();
//        if ($b_exists){
//
//            $notification = array(
//                'message' => 'Section already exist',
//                'alert-type'=> 'error',
//            );
//            return redirect()->route('sections.index')->with($notification);
//        }else{}



//        $validated = $request->validate([
//            'section_name' => 'required|unique:sections|max:255',
//            'description'=>'required',
//        ],[
//            'section_name.required'=>'يرجي ادخال اسم القسم',
//            'section_name.unique'=>'اسم القسم موجود مسبقا',
//            'description.required'=>'يرجي ادخال ملاحظات القسم',
//        ]);



        //saving
            try {
                Section::create([
                    'section_name'=>$request->section_name,
                    'description'=>$request->description,
                    'Created_by' => (Auth::user()->name),
                ]);
                $notification = array(
                    'message' => 'Section Saved successfully',
                    'alert-type'=> 'success',
                );
                return redirect()->route('sections.index')->with($notification);
            }catch (\Exception $e) {
                return redirect()->back()->withErrors(['error' => $e->getMessage()]);
            }
        }


    public function show(Section $section)
    {
        //
    }

    public function edit($id)
    {
        return $id;
    }

    public function update(Request $request)
    {
        try {

            $id = $request->id;

//            $this->validate($request, [
//                'section_name' => 'required|max:255|unique:sections,section_name,'.$id,
//                'description' => 'required',
//            ],[
//                'section_name.required' =>'يرجي ادخال اسم القسم',
//                'section_name.unique' =>'اسم القسم مسجل مسبقا',
//                'description.required' =>'يرجي ادخال البيان',
//            ]);

            $validated = $request->validate([
            'section_name' => 'required|max:255|unique:sections,section_name,'.$id,
            'description'=>'required',
        ],[
            'section_name.required'=>'يرجي ادخال اسم القسم',
            'section_name.unique'=>'اسم القسم موجود مسبقا',
            'description.required'=>'يرجي ادخال ملاحظات القسم',
        ]);

            //return $request;
            $section = Section::findOrFail($request->id);

            $section->update([
                'section_name'=>$request->section_name,
                'description'=>$request->description,
                'Created_by' => (Auth::user()->name),
            ]);

            $notification = array(
                'message' => 'Section Updated successfully',
                'alert-type'=> 'info',
            );
            return redirect()->route('sections.index')->with($notification);

        }catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }

    }

    public function destroy(Request $request)
    {
        $section = Section::findOrFail($request->id);
        $section->delete();
        $notification = array(
            'message' => 'Section Deleted successfully',
            'alert-type'=> 'error',
        );
        return redirect()->route('sections.index')->with($notification);

    }
}
