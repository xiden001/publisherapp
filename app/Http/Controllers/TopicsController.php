<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Topic;

class TopicsController extends Controller
{
    public function createTopic(Request $request){
        
        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:topics|max:255'
        ]);

        if ($validator->fails()) {
            return response()->json([
                "status" => "error",
                "message" => "Invalid/Duplicate topic provided"
            ], 422);
        }

        $topic = Topic::create([
            "name" => $request->name
        ]);

        return response()->json([
            "status" => "success",
            "topic" => $topic
        ],200);

    }

    public function retrieveTopics(){
        
        $topics = Topic::all();

        return response()->json([
            "status" => "success",
            "data" => $topics 
        ],200);
    }
}
