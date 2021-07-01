<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Topic;
use App\Models\Subscription;
use App\Jobs\PublishTopic;


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

        //check if url has already been subscribed to topic
        $checkUrl = Subscription::where("topic_id", $topic->id)->where("url",$request->url)->count();
        
        if($checkUrl == 0){
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

         //data exists return error
        return response()->json([
            "status" => "error",
            "message" => "Already subscribed to this topic!"
        ],422);
    }


    public function publish(Request $request, $topic){
        //validate incoming input is json
        
        $validator = $request->isJson();
        //check if content type is application/json
        if(!$validator) return response()->json(["status"=>"error","message"=>"JSON payload required"],422);
        //parse json content to verify if it is really json content 
        $content = json_decode($request->getContent());
        if($content != null){

             //get topic passed in request
        $findTopic = Topic::where("name",$topic);
         //throw error message if topic is not found
         if($findTopic->count() == 0) return response()->json(["status" => "error","message" => "Topic not found!"],404);

         $topic = $findTopic->first();

        //get subscribers
        $subscribers = Subscription::where("topic_id", $topic->id)->get();
        $counter = 0;
        //loop through subscribers and fire notification job
        foreach($subscribers as $subscriber){
            try{

            PublishTopic::dispatchSync($subscriber->url,$topic->name, $request->getContent());
            $counter++;

            }catch(Exception $e){
              
            }
        }
        
        return response()->json([
            "status" => "success",
            "message" => "Topic published to ".$counter." subscribers!"
        ],200);

        }

       return response()->json([
        "status" => "error",
        "message" => "Invalid JSON content!"
    ],422);
    }
}
