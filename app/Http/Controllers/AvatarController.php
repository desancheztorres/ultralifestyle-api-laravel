<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Image;
use App\Models\{Avatar, Profile};
use Auth;
use App\Transformers\AvatarTransformer;
use File;


class AvatarController extends Controller
{
    public function store(Request $request) {

        $userId = Auth::guard('api')->id();
        $profile = Profile::where('user_id', $userId)->first();

        if($request->hasFile('avatar')) {
            $avatar = $request->file('avatar');
            $filename = time() . '.' . $avatar->getClientOriginalExtension();

            Image::make($avatar)->resize(300,300)->save('uploads/avatars/'.$filename);

            $avatar = new Avatar();
            $avatar->image = url('/').'/uploads/avatars/'.$filename;
            $avatar->profile_id = $profile->id;
            $avatar->save();
        }
    }

    public function update(Request $request) {

        $userId = Auth::guard('api')->id();
        $profile = Profile::where('user_id', $userId)->first();
        $avatar = Avatar::where('profile_id', $profile->id)->first();

        $oldImage = "uploads/avatars/" . $avatar->image;

        if($request->hasFile('avatar')) {
            $image = $request->file('avatar');
            $filename = time() . '.' . $image->getClientOriginalExtension();

            Image::make($image)->resize(300,300)->save('uploads/avatars/'.$filename);

            $avatar->image = $filename;
            $avatar->save();

            if(File::exists($oldImage)) {
                File::delete($oldImage);
            }
            
            return fractal()
                ->item($avatar)
                ->transformWith(new AvatarTransformer)
                ->toArray();

        }
    }
}
