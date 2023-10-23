<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ImageController extends Controller
{
    public function showUploadForm()
    {
        return view('upload_form');
    }

    public function uploadImage()

    {

        // Handle image upload here (as shown in a previous response).
        // After successful upload, you can redirect to the edit form or display the edited image.
        return view('editImage');
        //return redirect()->route('edit.form');
    }

    public function showEditForm()
    {
        return view('editImage');
    }

    public function editImage(Request $request)
    {
        // Handle image editing here (as shown in a previous response).

        return redirect()->route('upload.form')->with('success', 'Image edited and saved');
    }
}
