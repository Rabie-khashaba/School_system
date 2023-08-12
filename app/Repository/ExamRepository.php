<?php

namespace App\Repository;

use App\Models\Exam;


class ExamRepository implements ExamRepositoryInterface
{
    public function index()
    {
        $exams = Exam::get();
        return view('pages.Exams.index', compact('exams'));
    }

    public function create()
    {
        return view('pages.Exams.create');
    }

    public function store($request)
    {
        try {
            $exams = new Exam();
            $exams->name = ['en' => $request->Name_en, 'ar' => $request->Name_ar];
            $exams->term = $request->term;
            $exams->academic_year = $request->academic_year;
            $exams->save();

            $notification = array(
                'message' => 'Exams Saved successfully',
                'alert-type'=> 'success',
            );
            return redirect()->route('Exams.create')->with($notification);
        } catch (\Exception $e) {
            return redirect()->back()->with(['error' => $e->getMessage()]);
        }
    }

    public function edit($id)
    {
        $exam = Exam::findorFail($id);
        return view('pages.Exams.edit', compact('exam'));
    }

    public function update($request)
    {
        try {
            $exam = Exam::findorFail($request->id);
            $exam->name = ['en' => $request->Name_en, 'ar' => $request->Name_ar];
            $exam->term = $request->term;
            $exam->academic_year = $request->academic_year;
            $exam->save();
            $notification = array(
                'message' => 'Exams Updated successfully',
                'alert-type'=> 'success',
            );
            return redirect()->route('Exams.index')->with($notification);
        } catch (\Exception $e) {
            return redirect()->back()->with(['error' => $e->getMessage()]);
        }
    }

    public function destroy($request)
    {
        try {
            Exam::destroy($request->id);
            $notification = array(
                'message' => 'Exams Deleted successfully',
                'alert-type'=> 'error',
            );
            return redirect()->route('Exams.index')->with($notification);
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }

}
