<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Http\Request;
use App\Models\AutoReplyRule;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ChatManagementService extends BaseService
{
//    protected $fileUploadService;

    public function __construct(AutoReplyRule $model)
    {
        parent::__construct($model);
//        $this->fileUploadService = $fileUploadService;
    }


}
