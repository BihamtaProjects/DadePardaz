<?php

namespace App\Http\Controllers;

use App\Models\Application;
use App\Models\Category;
use App\Models\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ApplicationFormController extends Controller
{
    public function newForm()
    {
        $categories = Category::all();
        return view('user.applicationForm', compact('categories'));
    }

    public function sendForm(Request $request)
    {
        $validatedData = $request->validate([
            'category_id' => 'required',
            'description' => 'required',
            'price' => 'required|integer',
            'files.*' => 'mimes:pdf,jpg,jpeg,png,svg',
        ]);
        try {
            DB::beginTransaction();

            $user_id = Auth::user()->id;

            $application = Application::create([
                'user_id' => $user_id,
                'category_id'=>$request->category_id,
                'description'=>$request->description,
                'price'=>$request->price,
            ]);

            if ($request->hasFile('files')) {

                $ApplicationFilesController = new ApplicationFilesController();
                $fileNames = $ApplicationFilesController->upload( $request->file('files'));

                foreach ($fileNames as $fileName) {
                    File::create([
                        'application_id' => $application->id,
                        'file' => $fileName
                    ]);
                }
            }
            DB::commit();

        }catch (\Exception $ex){
            DB::rollBack();
            return redirect()->back();
        }

        return redirect()->route('dashboard');
    }
}
