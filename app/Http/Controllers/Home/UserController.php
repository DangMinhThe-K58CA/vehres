<?php

namespace App\Http\Controllers\Home;

use App\Helpers\MyHelper;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use App\Http\Requests\UpdateUserRequest;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {

    }

    /**
     * Upload file: $isAvatar default 0;
     * @param Request $request
     * @param array $options
     * @return mixed
     */
    public function uploadFile(UploadedFile $file, $isAvatar = 0)
    {
        $storedFile = MyHelper::uploadFile($file, ['avatar' => $isAvatar, 'fileable_type' => 'users', 'fileable_id' => Auth::user()->id]);
        if ($isAvatar) {
            return $this->changeAvatar($storedFile['name']);
        }

        return Redirect::to(url('/home/user'))->with('success', trans('helper.file_uploaded_success'));
    }

    /**
     * Change avatar by image name.
     * @param $avatarName
     * @return mixed
     */
    public function changeAvatar($avatarName)
    {
        Auth::user()->avatar = $avatarName;
        return Auth::user()->save();
    }
    //
    public function index()
    {
        //
        return view('homes.user.profile');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateUserRequest $request)
    {
        if ( $request->type == 1 ) {
            return $this->updateProfile($request);
        }

        if ( $request->type == 2) {
            return $this->changePassword($request);
        }
    }

    /**
     * Update user information.
     * @param $request
     * @return mixed
     */
    protected function updateProfile($request)
    {
        //Upload and change avatar if requested.
        if ($request->hasFile('avatar')) {
            $this->uploadFile($request->file('avatar'), 1);
        }

        //Change user name if requested.
        $requestedData = $request->only('name', 'description');
        $keys = array_keys($requestedData);
        $isChanged = false;
        $notify = trans('auth.no_changed_data');

        foreach ($keys as $key)
        {
            if ($requestedData[$key] != '' && $requestedData[$key] != Auth::user()->$key) {
                Auth::user()->$key = $requestedData[$key];
                $isChanged = true;
                $notify = trans('auth.updated_info_success');
            }
        }

        if ($isChanged) {
            Auth::user()->save();
        }

        return Redirect::to('home/users')->with('success', $notify);
    }

    /**
     * Change password methoad.
     * @param $request
     * @return mixed
     */
    protected function changePassword($request)
    {
        $curPass = $request->input('currentPassword');
        $isCorrectCurPass = Auth::user()->isCorrectCurrentPassword($curPass);

        if ($isCorrectCurPass) {
            Auth::user()->password = $request->input('newPassword');
            Auth::logout();
            return Redirect::to('/login')->with('success', 'Password is Changed');
        }

        return $request->response(['currentPassword'=>"Password not match !"]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
