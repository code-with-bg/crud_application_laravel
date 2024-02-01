<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\student;
use Faker\Provider\UserAgent;
use Illuminate\Support\Facades\Validator;
class studentApiController extends Controller
{
    // get all users data through this method 
    // get all users data through this method 
   public function index(){
    $students = student::all();
    return response()->json([
        'message' => count($students),
        'data' => $students,
        'status' => true
    ]);
   }


//    get the single student data from the database 
//    get the single student data from the database 
public function show($id){
    $students = student::find($id);
    if($students != null){
        return response()->json([
            'message' => 'Record Found',
            'data' => $students,
            'status' => true
        ],200);
    }else{
        return response()->json([
            'message'=> 'Rocord not Found',
            'data' => [],
            'status' => true

        ],200);
    }
}

// create api to store data into database 
// create api to store data into database 
public function store(Request $request){
$validation = Validator::make($request->all(),[
        'name' => 'required',
        'email' => 'required|email|unique:students',
        'phone' => 'required|min:10|max:10|unique:students',
        'address' => 'required',
        'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048'
]);
   if($validation->fails()){
    return response()->json([
    'message' => 'Masum bikesh pahele toh tum error ko fix karo',
    'errors' => $validation->errors(),
     'status' => false
    ]);
   }

     // Handle image upload
     $img = $request->file('image');
     $ext = $img->getClientOriginalExtension();
     $imageName = time().'.'.$ext; 
     $img->move(public_path().'/uploads/students/', $imageName);

   $student = new Student;
   $student->name = $request->name;
   $student->email = $request->email;
   $student->phone = $request->phone;
   $student->address = $request->address;
   $student->image = $imageName; // Save the image path to the 'image' column in the database
   $student->save();

   return response()->json([
    'message' => 'Student added successfully',
    'errors' => $validation->errors(),
    'status' => true
   ],200);
}

// create update api data from database 
// create update api data from database 
public function update(Request $request, $id){
     
    // Find the student by ID 
    $student = Student::find($id);

    // Check if student is exists 
    if($student == null){
        return response()->json([
            'message' => 'Student not found',
            'status' => false
        ],400); // Return  a 404 status code for not found
    }

    // Validate the request students data 
    $validation = Validator::make($request->all(),[
        'name' => 'required',
        'email' => 'required|email|unique:students',
        'phone' => 'required|min:10|max:10|unique:students',
        'address' => 'required',
        'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048'
    ]);
    
    if($validation->fails()){
        return response()->json([
            'message' => 'Validation error',
            'errors' => $validation->errors(),
            'status' => false
        ],400);
    }

     // Handle image upload
     $img = $request->file('image');
     $ext = $img->getClientOriginalExtension();
     $imageName = time().'.'.$ext; 
     $img->move(public_path().'/uploads/students/', $imageName);

    $student->name = $request->input('name');
    $student->email = $request->input('email');
    $student->phone = $request->input('phone');
    $student->address = $request->input('address');
    $student->image = $imageName;
    $student->save();

    return response()->json([
        'massage' => 'Student updated successfully',
        'student' => $student,
        'status' => true
    ],200);

}


// Create delete data through api from database 
// Create delete data through api from database 
public function destroy($id){
    $student = Student::find($id);
    if($student == null){
        return response()->json([
            'massage' => 'Student not found',
            'status' => false
        ],404);
    }

    $student->delete();
    return response()->json([
        'messages' => 'Student deleted successfully',
        'status' => true
    ],200);

}

}
