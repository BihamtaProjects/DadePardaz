<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\ApplicationFilesController;
use App\Http\Controllers\Controller;
use App\Models\Application;
use App\Models\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;


class FormController extends Controller
{
    public function submitForm(Request $request)
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


            if($request->files) {

                $ApplicationFilesController = new ApplicationFilesController();
                $fileNames = $ApplicationFilesController->upload($request->files);

                foreach ($fileNames as $fileName) {
                    File::create([
                        'application_id' => $application->id,
                        'file' => $fileName
                    ]);
                }
            }


            DB::commit();
            return response()->json(['message' => 'Form submitted successfully'], 200);

        }catch (\Exception $ex){
            DB::rollBack();
            return redirect()->back();
        }
    }
}
