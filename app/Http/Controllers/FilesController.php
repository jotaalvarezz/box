<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\FileRequest;
use \Storage;

class FilesController extends Controller
{
    public function index(Request $request)
    {
        $path = $request->get('path');
        
        $path = str_replace('-@folder@-', '/', $path);
        $path = str_replace('-@space@-', ' ', $path);

        $directories = Storage::directories($path);
        $files = Storage::files($path);
        foreach($files as $key => $file) {
            if (strpos($file, '.gitignore')) {

                unset($files[$key]);

            }
        }

        return response()->json([
            'directories' => $directories,
            'files' => $files
        ]);
    }

    public function store(FileRequest $request)
    {
        //return ['save' => $request];
        $type = $request->get('type');
        $directory = $request->get('directory');

        if ($type == 'file') {

            foreach($request->file('files') as $file) {

                $file->storeAs($directory, $file->getClientOriginalName());

            }

            return response()->json(['message' => 'Archivos guardados']);

        } else if ($type == 'folder') {

            Storage::makeDirectory($request->get('directory') . '/' . $request->get('name'));

            return response()->json(['message' => 'Directorio creado']);

        }

        return response()->json(['message' => 'Solicitud no reconocida'], 401);
    }

    public function show($file)
    {
        $file = str_replace('-@folder@-', '/', $file);
        $file = str_replace('-@space@-', ' ', $file);

        if (Storage::exists($file)) {

            return Storage::download($file);

        }

        return abort(404);
    }

    public function update(Request $request, $file)
    {
        //
    }

    public function destroy($file)
    {
        $file = str_replace('-@folder@-', '/', $file);
        $file = str_replace('-@space@-', ' ', $file);

        if (Storage::exists($file)) {

            if (!Storage::delete($file)) {

                Storage::deleteDirectory($file);

            }

            return response()->json(['message' => 'Archivo borrado']);

        }

        return response()->json(['message' => 'Archivo no encontrado'], 404);
    }
}
