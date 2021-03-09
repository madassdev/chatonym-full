<?php

namespace App\Http\Controllers;

use App\Http\Resources\FeedResource;
use App\Models\Feed;
use Illuminate\Http\Request;

class FeedController extends Controller
{
    public function index()
    {
        return view('interface.index');
    }
    public function fetchFeeds()
    {
        $feeds = Feed::whereNull('parent_id')->with('user')->with('replies')
            ->paginate(30);

        return response()->json(['success' => true, 'data' => ['feeds' => FeedResource::collection($feeds)]]);
    }


    public function showFeed(Feed $feed)
    {
        // return Feed::whereHas('replies')->get();
        $feed->load('replies');

        return $feed;
    }


}
