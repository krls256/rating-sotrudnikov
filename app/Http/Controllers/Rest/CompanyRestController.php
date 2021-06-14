<?php


namespace app\Http\Controllers\Rest;


use app\Http\Requests\Rest\Company\CompanyEditRestRequest;
use app\Http\Requests\Rest\Company\CompanyUpdateRestRequest;
use helperClasses\Request;
use helperClasses\Storage;

class CompanyRestController extends RestController
{
    public function edit(Request $request) {
        $req = $request->all();
        $this->validate(CompanyEditRestRequest::class, $req);
        $id = $req['id'];
        $company = $this->repository->getEdit($id);
        return [
            'company' => $company
        ];
    }

    public function update(Request $request) {
        $req = $request->all();

        $this->validate(CompanyUpdateRestRequest::class, $req);
        $id = $req['id'];
        $file = $request->get('file');
        // TODO: move to observer
        if($file) {
            $storage = new Storage('public/upload');
            $filename = 'remont_' . time();
            $res = $storage->storeFileFromHTTP($file, $filename);
            if($res['status'] === false) {
                session()->error('Не можем загрузить файл');
                back();
            }
            $path = $res['path'];
            unset($req['file']);
            $req['logo'] = '../upload/' . $path;
        }

        return $this->repository->update($id, $req);
    }
}
