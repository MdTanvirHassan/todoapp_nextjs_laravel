<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json(Contact::orderBy('created_at', 'desc')->get()); 
    }

    /**
     * Store a newly created resource in storage.
     */
    // public function store(Request $request)
    // {
    //     Contact::create([
    //         'name' => $request->name,
    //         'email' => $request->email,
    //         'phone' => $request->phone
    //     ]);
    //     return response()->json(true);
    // }
    public function store(Request $request)
{
    try {
        Contact::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone
        ]);
        return response()->json(['success' => true]);
    } catch (\Exception $e) {
        // Log the error for debugging purposes
        error_log($e->getMessage());

        // Return an error response with a status code of 500
        return response()->json(['error' => 'Internal server error'], 500);
    }
}



    /**
     * Display the specified resource.
     */
    // public function show(Contact $contact)
    // {
    //     //
    // }

    // /**
    //  * Update the specified resource in storage.
    //  */
    // public function update(Request $request, Contact $contact)
    // {
    //     // Validate the incoming request data (e.g., name, email, phone)
    //     $validatedData = $request->validate([
    //         'name' => 'required',
    //         'email' => 'required|email',
    //         'phone' => 'required',
    //     ]);
    
    //     // Check if the contact exists
    //     if (!$contact) {
    //         return response()->json(['error' => 'Contact not found'], 404);
    //     }
    
    //     // Update the contact using the validated data
    //     $contact->update($validatedData);
    
    //     // Optionally, you can return a response to indicate the update was successful
    //     return response()->json(['message' => 'Contact updated successfully']);
    // }
    public function show($id)
    {
        $contact = Contact::find($id);

        if (!$contact) {
            return response()->json(['message' => 'Contact not found'], 404);
        }

        return response()->json($contact);
    }

    // Update a contact
    public function update(Request $request, $id)
    {
        $contact = Contact::find($id);

        if (!$contact) {
            return response()->json(['message' => 'Contact not found'], 404);
        }

        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email',
            'phone' => 'required',
        ]);

        $contact->update([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'phone' => $request->input('phone'),
        ]);

        return response()->json(['message' => 'Contact updated successfully']);
    }
    
    

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Contact $contact)
    {
        $contact->delete();
        return response()->json(true);
    }
}
