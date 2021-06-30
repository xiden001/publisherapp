<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Topic;

class TopicsController extends Controller
{
    public function createTopic(Request $request){
        //Validate incoming input
        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:topics|max:255'
        ]);
        //Throw validation error message if rules are not met
        if ($validator->fails()) {
            return response()->json([
                "status" => "error",
                "message" => "Invalid/Duplicate topic provided"
            ], 422);
        }
        //Create a new topic
        $topic = Topic::create([
            "name" => $request->name
        ]);
        //return created topic if successful
        return response()->json([
            "status" => "success",
            "topic" => $topic
        ],200);

    }

    public function retrieveTopics(){
        //fetch all topics from db
        $topics = Topic::all();
        //return topics if found 
        return response()->json([
            "status" => "success",
            "data" => $topics 
        ],200);
    }
}
