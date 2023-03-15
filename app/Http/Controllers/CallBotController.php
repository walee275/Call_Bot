<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Google\Cloud\Speech\V1\SpeechClient;
use Google\Cloud\Speech\V1\RecognitionAudio;
use Google\Cloud\Speech\V1\RecognitionConfig;
use Google\Cloud\Speech\V1\RecognitionConfig\AudioEncoding;

class CallBotController extends Controller
{

    public function show_users()
    {

        $data = [
            'users' => User::all(),
        ];

        return view('index', $data);
    }
    public function user_add(Request $request)
    {
        // $data = [
        //     'name' => 'khan',
        //     'age' => 'kalil',
        //     'name_audio' => 'jhdjas',
        //     'age_audio' => 'skfjk',
        // ];

        // $is_user_created = User::create($data);
        // return json_encode('hello');
        // dd($request->all());
        // $request->validate([
        //     'name' => ['required'],
        //     'age' => ['required'],
        // ]);
        // return json_encode($request->all());
            // return dd('hello');
        $name_audio = $request->file('name-audio');
        $age_audio = $request->file('age-audio');
        $user_already_exist = User::where([
            ['name', $request->name],
            ['age', $request->age],
        ])->first();

        if($user_already_exist){
            return json_encode('error', 'User already exist!');

        }

        $file_name_name = $name_audio->getClientOriginalName();
        $file_name_name = 'user-' . $request->name . '-name' . rand(1, 15) .'-'. $file_name_name;

        // return json_encode($file_name_name);

        $is_name_audio_uploaded = $name_audio->move(public_path('audio_files'), $file_name_name);

        if ($is_name_audio_uploaded) {
            $file_name_age =  $age_audio->getClientOriginalName();
            $file_name_age = 'user-' . $request->name . '-age' . rand(10, 1) .'-'. $file_name_age;
            // return json_encode($file_name_age);

            $is_age_audio_uploaded = $age_audio->move(public_path('audio_files'), $file_name_age);
            if ($is_age_audio_uploaded) {

                $data = [
                    'name' => $request->name,
                    'age' => $request->age,
                    'name_audio' => $file_name_name,
                    'age_audio' => $file_name_age,
                ];

                $is_user_created = User::create($data);
                // return json_encode('hello');

                if ($is_user_created) {
                    return json_encode('User added successfully');
                } else {
                    return json_encode('User has failed to add');
                }
            } else {
                return json_encode('User has failed to add');
            }
        } else {
            return json_encode('User has failed to add');
        }
    }


    public function add_audio(Request $request)
    {
    }
}
