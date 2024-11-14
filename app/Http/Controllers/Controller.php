<?php

use App\Models\Student;
use Illuminate\Http\Request;

abstract class Controller
{
    public function index()
    {
        $students = Student::all();
        return view('students.index', compact('students'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:students',
            'phone' => 'required',
        ]);

        Student::create($request->all());

        return response()->json(['success' => 'Student added successfully!']);
    }

    public function update(Request $request, $id)
    {
        $student = Student::findOrFail($id);

        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:students,email,'.$id,
            'phone' => 'required',
        ]);

        $student->update($request->all());

        return response()->json(['success' => 'Student updated successfully!']);
    }

    public function destroy($id)
    {
        Student::destroy($id);

        return response()->json(['success' => 'Student deleted successfully!']);
    }
}
