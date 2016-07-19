<?php

namespace Wooter\Http\Controllers\API\Files;

use Illuminate\Http\Request;

use Wooter\Http\Requests;
use Wooter\Http\Controllers\Controller;

use Auth;
use Storage;

class Upload extends Controller {

    private $uploadFolder = '/upload';

    /**
     * @param $type (profile)
     * @param Request $req
     * @return \Illuminate\Http\JsonResponse
     */
    public function uploadFile($type = null, Request $req){
		if ($type) {
			switch ($type) {
				case 'profile':
					return $this->methodProfile($req);
				break;

				default:
					abort(404);
				break;
			}

		}
	}

	public function methodProfile(Request $req, $getter = 'file'){
        $validate = $this->validateFile($req);

		if ($validate['success']) {
            $id = Auth::user()->id;
            $ext = $req->all()[$getter]->getClientOriginalExtension();
            $to = 'users/'.$id.'/';
            $save = $this->storeFile($req, $to, 'profile.'.$ext);
            return array_merge($save, [
                'u_id' => $id,
                'success' => true
            ]);
		} else {
            return response()->json($validate, 422);
        }
	}

    public function storeFile(Request $req, $to, $name, $getter='file'){
        $path = implode('/', explode('//', base_path($this->uploadFolder).'/'.$to));

        $req->file($getter)->move($path, $name);

        return [
            "dir" => $path,
            "file" => $name,
            "cat" => implode('/', explode('//', $path.'/'.$name))
        ];
    }

    /**
     * @description If data are file return success else return error
     * @param Request $req
     * @param string $getter (input name)
     * @return array
     */
    public function validateFile(Request $req, $getter = 'file'){
		if ($req->hasFile($getter)) {
            return [
                "success" => true
            ];
		} else {
			return [
				"error" => "This not is a file!"
			];
		}
	}

}
