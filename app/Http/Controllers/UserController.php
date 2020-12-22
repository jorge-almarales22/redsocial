<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Config;

class UserController extends Controller
{
    public function getInfoPerfil(User $user)
    {        
        return view('users.edit', compact('user'));
    }
    public function putEditarPerfil(Request $request)
    {
        $user = auth()->user();
        $request->validate([
            'name' => 'required|min:3',
            'lastname' => 'required|min:3',
            'email' => 'required|email',
        ]);

        $ipp = $user->file_path;
        $ip = $user->avatar;
        
        $user->name = e($request->name);
        $user->lastname = e($request->lastname);
        $user->email = e($request->email);
        $user->file_path = date('Y-m-d');

        if($request->hasFile('avatar')){

            $path = '/'.date('Y-m-d');
            $fileExt = trim($request->file('avatar')->getClientOriginalExtension());
            $upload_path = Config::get('filesystems.disks.uploads.root');
            $name = Str::slug(str_replace($fileExt, '', $request->file('avatar')->getClientOriginalName()));
            $filename = rand(1,999).'-'. $name.'.' .$fileExt;
            $file_file = $upload_path.'/'.$path.'/'.$filename;
            $user->avatar = $filename;
            $request->avatar->storeAs($path, $filename, 'uploads');
            $avatar = Image::make($file_file);
            $avatar->fit(256,256, function($constraint){
                $constraint->upsize();
            });
            $avatar->save($upload_path.'/'.$path.'/t_'.$filename);
            if(is_null(auth()->user()->file_path && auth()->user()->avatar))
            {
                $ipp = $user->file_path;
                $ip = $user->avatar;                
            }else{
                // unlink($upload_path.'/'.$ipp.'/'.$ip);
                // unlink($upload_path.'/'.$ipp.'/t_'.$ip);
            }
        }
        if($user->save())
        { 
            return back()->with('status', '¡ su informacion fue guardada con exito felicidades !');
        }
    }
}
