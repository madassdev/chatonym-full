<?php

namespace App\Http\Controllers;

use App\Http\Resources\FeedResource;
use App\Models\Feed;
use Illuminate\Http\Request;

class FeedController extends Controller
{
    public function index()
    {
        return view('interface.feed');
    }
    public function fetchFeeds()
    {
        $feeds = Feed::latest()->whereNull('parent_id')->with('user')->with('replies')->with('reactions')->withCount('reactions')
            ->paginate(30);

        return response()->json(['success' => true, 'data' => ['feeds' => FeedResource::collection($feeds)]]);
    }


    public function showFeed(Feed $feed)
    {
        // return Feed::whereHas('replies')->get();
        $feed->load('replies');

        return $feed;
    }

    public function reactToFeed(Request $request, Feed $feed)
    {
        $user = auth()->user();
        $request->validate([
            "reaction" => "required|string",
        ]);

        $feed->reactions()->updateOrCreate(["feed_id" => $feed->id, "user_id" => $user->id], [
            "reaction" => $request->reaction,
            "user_id" => $user->id
        ]);

        return response()->json([
            "success" => true,
            "data" => $feed
        ]);
    }

    public function updateFeedImage(Request $request, Feed $feed)
    {
        $request->validate(
            [
                'image_url' => 'array',
            ]
        );

        $feed->load('replies');
        // $feed->message="updated";
        $feed->image_url = $request->image_url;
        $feed->save();
        return response()->json([
            'success' => true,
            'data' => $feed->load('replies')
        ]);
    }

    public function create(Request $request)
    {
        $request->validate(
            [
                'message' => 'required_without:image_url',
            ]
        );

        $status = 'submitted';
        $media_type = 'text';

        if ($request->has('image_url')) {

            $request->validate(
                [
                    'image_url' => 'array',
                ]
            );

            $status = 'submitted-with-image';
            $media_type = 'text-and-image';

            json_encode($request->image_url);
        }

        $message = nl2br(strip_tags($request->message));

        $feed = Feed::create(
            [
                'message' => $message,
                'user_id' => auth()->id(),

                'user_ip' => $request->ip(),
                'user_agent' => $request->header('User-Agent'),

                'media_type' => $media_type,

                'image_url' => $request->image_url,

                'audio_url' => $request->audio_url,
                'warped_audio_url' => $request->warped_audio_url,
                'warp_effect' => $request->warp_effect,

                'status' => $status
            ]
        );

        // $feed = Feed::find(3629);

        return response()->json([
            'success' => true,
            'data' => $feed->load('replies')
        ]);
    }

    public function replyFeed(Request $request, Feed $feed)
    {

        $request->validate(
            [
                'message' => 'required_without:image_url',
            ]
        );

        $status = 'submitted';
        $media_type = 'text';

        if ($request->has('image_url')) {

            $request->validate(
                [
                    'image_url' => 'array',
                ]
            );

            $status = 'submitted-with-image';
            $media_type = 'text-and-image';

            json_encode($request->image_url);
        }

        $message = nl2br(strip_tags($request->message));
        // return nl2br($request->message);


        $reply = $feed->replies()->create(
            [
                'message' => $message,
                'user_id' => auth()->id(),
                'parent_id' => $feed->id,

                'user_ip' => $request->ip(),
                'user_agent' => $request->header('User-Agent'),

                'media_type' => $media_type,

                'image_url' => $request->image_url,

                'audio_url' => $request->audio_url,
                'warped_audio_url' => $request->warped_audio_url,
                'warp_effect' => $request->warp_effect,

                'status' => $status
            ]
        );

        return response()->json([
            'success' => 'true',
            'data' => $reply
        ]);
    }
}
