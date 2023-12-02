<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;


class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json(Employee::orderBy('created_at', 'desc')->get()); 
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $this->validate($request, [
                'name' => 'required',
                'email' => 'required|email',
                'phone' => 'required',
                'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            ]);
    
            $imagePath = $this->uploadImage($request);
    
            Employee::create([
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
                'image' => $imagePath,
            ]);
    
            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            \Log::error('Error in store method:', ['error' => $e->getMessage()]);
            return response()->json(['error' => 'Internal server error'], 500);
        }
    }
    
    private function uploadImage(Request $request): ?string
    {
        if (!$request->hasFile('image')) {
            return null;
        }
    
        $image = $request->file('image');
        $imageName = time() . '.' . $image->getClientOriginalExtension();
        $imagePath = '/uploads/employees/' . $imageName;
        Storage::disk('public')->putFileAs('uploads/employees', $image, $imageName);
       // dd($request->all(), $imagePath);
    
        return $imagePath;
    }
    

    
    
    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $employee = Employee::find($id);

        if (!$employee) {
            return response()->json(['message' => 'Employee not found'], 404);
        }

        return response()->json($employee);
    }

    /**
     * Update the specified resource in storage.
     */
    // public function update(Request $request, $id)
    // {
    //     $employee = Employee::find($id);

    //     if (!$employee) {
    //         return response()->json(['message' => 'employee not found'], 404);
    //     }

    //     $this->validate($request, [
    //         'name' => 'required',
    //         'email' => 'required|email',
    //         'phone' => 'required',
    //     ]);

    //     $employee->update([
    //         'name' => $request->input('name'),
    //         'email' => $request->input('email'),
    //         'phone' => $request->input('phone'),
    //     ]);

    //     return response()->json(['message' => 'employee updated successfully']);
    // }

    public function update(Request $request, $id)
{
    $employee = Employee::find($id);

    if (!$employee) {
        return response()->json(['message' => 'Employee not found'], 404);
    }

    $this->validateEmployeeData($request);

    try {
        $newImagePath = $this->uploadImage($request);

        $employee->update([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'phone' => $request->input('phone'),
            'image' => $newImagePath ?? $employee->image,
        ]);
        \Log::info('Update method reached successfully.');
        return response()->json(['message' => 'Employee updated successfully']);
    } catch (\Exception $e) {
        \Log::error('Error in update method:', ['error' => $e->getMessage()]);
        return response()->json(['error' => 'Internal server error'], 500);
    }
}

private function validateEmployeeData(Request $request): void
{
    $this->validate($request, [
        'name' => 'required',
        'email' => 'required|email',
        'phone' => 'required',
        'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
    ]);
}




    

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Employee $employee)
    {
        $employee->delete();
        return response()->json(true);
    }
}
