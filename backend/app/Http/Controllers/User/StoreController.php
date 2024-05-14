<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\StoreRequest;
use App\Models\User;
use GuzzleHttp\Psr7\Request;

class StoreController extends Controller
{
    public function reg(StoreRequest $request)
    {
        $data = $request->validated();
        $data['password'] = bcrypt($data['password']);
        User::firstOrCreate([
            'email'=> $data['email']
        ], $data);
        return $data;
        // TODO: Implement __invoke() method.
    }
}
