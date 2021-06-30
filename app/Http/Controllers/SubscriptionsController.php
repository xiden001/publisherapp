<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Topic;
use App\Models\Subscription;


class SubscriptionsController extends Controller
{
    public function subscribe(Request $request, $topic){
        //validate incoming input
        $validator = Validator::make($request->all(), [
            'url' => 'required|url'
        ]);
        //get topic passed in request
        $findTopic = Topic::where("name",$topic);
        //throw error message if topic is not found
        if($findTopic->count() == 0) return response()->json(["status" => "error","message" => "Topic not found!"],404);
        //create a new subscription with payload if topic is found
        $topic = $findTopic->first();
        $subscription = new Subscription();
        $subscription->topic_id = $topic->id;
        $subscription->url = $request->url;
        $subscription->save();
        //return data if created successfully
        return response()->json([
            "url" => $request->url,
            "topic" => $topic->name
        ],200);
    }
}
