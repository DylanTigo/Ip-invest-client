<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Archive;
use Illuminate\Support\Facades\File;
use Brian2694\Toastr\Facades\Toastr;

class ArchiveController extends Controller
{

    public function deleteProjectDocument($id)
    {
        $archive = Archive::with('projet_data')->find($id);
        $subFolder = "/";

        switch ($archive->type) {
            case 'FICHIER':
                $subFolder = "/documents/";
                break;
            case 'VIDEO':
                $subFolder = "/videos/";
                break;
            case 'IMAGE':
                $subFolder = "/images/";
                break;
        }

        if ($archive->projet_data->folder != null) {
            // dd(storage_path('app/public/uploads/projets/' . $archive->projet_data->folder . $subFolder . $archive->nom));
            File::delete(storage_path('app/public/uploads/projets/' . $archive->projet_data->folder . $subFolder . $archive->nom));
        }
        Archive::find($id)->delete();
        Toastr::success('Document supprimé avec succès!', 'Success');
        return back();
    }
}
