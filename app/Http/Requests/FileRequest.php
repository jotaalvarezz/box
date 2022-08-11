<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FileRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $type  = $this->get('type');

        $validations = [
            'type' => 'required|in:folder,file',
            'directory' => ['required', function($attribute, $value, $fail) {

                if (!\Storage::exists($value)) {

                    $fail("El directorio en el que quiere guardar no existe.");

                }
            }],
        ];

        if ($type == 'folder') {

            $directory = $this->get('directory');

            $validations['name'] = ['required', 'string', 'min:1', 'max:100', function($attribute, $value, $fail) use ($directory) {

                $create = $directory . '/' . $value;

                if (\Storage::exists($create)) {

                    $fail("El directorio a crear ya existe.");

                }

            }];

        } else if ($type == 'file') {

            $validations['files'] = ['required', 'array'];
            $validations['files.*'] = ['file'];

        }

        return $validations;
    }
}
