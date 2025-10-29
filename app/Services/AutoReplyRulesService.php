<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Http\Request;
use App\Models\AutoReplyRule;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AutoReplyRulesService extends BaseService
{
//    protected $fileUploadService;

    public function __construct(AutoReplyRule $model)
    {
        parent::__construct($model);
//        $this->fileUploadService = $fileUploadService;
    }
    public function createOrUpdate(Request|array $request, int $id = null): AutoReplyRule
    {
        $data = is_array($request) ? $request : $request->all();

        if ($id) {
            // Update
            $autoReplyRule = $this->get($id);
            $autoReplyRule->fill($data);
            $autoReplyRule->save();
            return $autoReplyRule;
        } else {
            // Create
            return $this->model::create($data);
        }
    }

    public function delete($id){
        $autoReplyRule = $this->get($id);

        $autoReplyRule->delete();

    }

}
