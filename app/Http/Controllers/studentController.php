<?php

namespace App\Http\Controllers;
use App\Models\student;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
// use PhpParser\CompatibilityTest;

class studentController extends Controller
{
   public function index(){
    $data = student::get();
    return view('student-list',compact('data'));
   }

   public function addStudent(){
    return view('add-student');
   }

   public function saveStudent(Request $request){
     
    $request->validate([
        'name' => 'required',
        'email' => 'required|email|unique:students',
        'phone' => 'required|min:10|max:10|unique:students',
        'address' => 'required',
        'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048'
    ]);

    // dd($request->all());
       $name=$request->name;
       $email=$request->email;
       $phone=$request->phone;
       $address=$request->address;
       $image=$request->image;

       $stu = new student();
         $stu->name=$name;
         $stu->email=$email;
         $stu->phone=$phone;	
         $stu->address=$address;
         if($request->hasfile('image'))
         {
             $file = $request->file('image');
             $extenstion = $file->getClientOriginalExtension();
             $filename = time().'.'.$extenstion;
             $file->move('uploads/students/', $filename);
             $stu->image = $filename;
         }
         
         $stu->save();

         return redirect()->back()->with('success','Student added successfully');

   }

   public function editStudent($id){
    $data = student::where('id','=',$id)->first();
    return view('edit-student', compact('data'));
   }


  //  update code line from here 
  //  update code line from here 
   public function  updateStudent(Request $request){
    $request->validate([
        'name' => 'required',
        'email' => 'required|email',
        'phone' => 'required',
        'address' => 'required',
        'image' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
      
        
    ]);
     
     $id = $request->id;
     $name=$request->name;
     $email=$request->email;
     $phone=$request->phone;
     $address=$request->address;

      // Retrieve the current image path from the database
    $currentImage = student::where('id', $id)->value('image');

     // Handle image upload
    if ($request->hasFile('image')) {
      $image = $request->file('image');
      $imageName = time().'.'.$image->getClientOriginalExtension();
      $image->move(public_path('uploads/students/'), $imageName);
   
       // Delete the old image
       if ($currentImage) {
        $imagePath = public_path('uploads/students/') . $currentImage;
        if (file_exists($imagePath)) {
            unlink($imagePath);
        }
    }
  
      // For example, updating the 'image' field in the Student model
      Student::where('id', '=', $id)->update(['name' => $name, 'email' => $email, 'phone' => $phone, 'address' => $address, 'image' => $imageName]);
  } else {
      // No image uploaded, update other fields
      Student::where('id', '=', $id)->update(['name' => $name, 'email' => $email, 'phone' => $phone, 'address' => $address]);
  }
    return redirect()->back()->with('success','Student updated successfully');
   }



  //  Delete code line from here 
  //  Delete code line from here 
   public function deleteStudent($id){

    //  Student::where('id','=',$id)->delete();
    $student = student::find($id);
    
    // Check if the student exists 
    if($student){
    //  Delete the associated image file 
    $imagePath = public_path('uploads/students/' .$student->image);
    if(file_exists($imagePath)){
      unlink($imagePath);
    }
    // Delete the student record from the database 
    $student->delete();

    // Redirect back with success message
    return redirect()->back()->with('success','Student delete successfully');
    }else{
      return redirect()->back()->with('error', 'Student not found');
    }
   }

   public function recentPost(){
    $data = Student::get();
    return view('recent-post', compact('data'));
   }
}

