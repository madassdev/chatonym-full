<?php

namespace App\Http\Controllers;

use App\Http\Resources\FeedResource;
use App\Models\Thread;
use App\Models\ThreadMessage;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ThreadController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        return $user->threads;
    }

    public function trendingThreads()
    {
        $threads = Thread::whereVisibility('public')->withCount('messages')->orderBy('messages_count', 'desc')->paginate(10);

        return response()->json(['success'=>true, 'data'=>$threads],$this->successStatus);
    }

    public function showThread(Thread $thread)
    {
        $thread->loadCount('messages');
        return view('interface.thread', compact('thread'));
    }

    public function fetchMessages(Thread $thread)
    {
        // abort(403);
        $messages = ThreadMessage::whereThreadId($thread->id)->latest()->with('reactions')->with('parent')->withCount('reactions')->with('parent')->latest()
            ->paginate(30);

        return response()->json(['success' => true, 'data' => ['messages' => FeedResource::collection($messages)]]);
    }


    public function create(Request $request)
    {
        $user = auth()->user();
        $secret = null;
        $request->validate([
            'name' => 'required|max:50',
            'description' => 'required|max:100',
            'visibility' => 'required|in:private,public',

        ]);

        if ($user->threads->count() > 9) {
            return response()->json(
                [
                    'success' => false,
                    'data' => [
                        'message' => 'You cannot create more than 10 threads.'
                    ]
                ],
                403
            );
        }
        $token = '';
        if ($request->visibility == 'private') {
            $secret = Str::random(6);
            $token = 'tk-' . Str::random(10) . '-' . Str::random(10) . '_' . Str::random(10);
        }

        $thread = $user->threads()->create([
            'name' => $request->name,
            'description' => $request->description,
            'secret' => $secret,
            'token' => $token,
            'visibility' => $request->visibility,
        ]);
        $thread = $thread->load('user');
        $thread->threads_count = $user->threads->count();
        $thread->messages()->create([
            "message" => "<div class='pt-12'><b>Welcome to anonymous thread</b> <br/>".
                            "Feel free to discuss and have conversations on this thread while we keep you completely ".
                            "<b>ANONYMOUS</b> <br/><br/><b>Important:</b>  AVOID SPAMMING!!! to avoid your account being blocked."
        ]);
        $thread->messages()->create([
            "message" => "<b>".$thread->name."</b><br>".$thread->description
        ]);
        return response()->json(
            [
                'success' => true,
                'data' => $thread
            ],
        );
    }

    public function showThreads()
    {
        $threads = auth()->user()->threads();
        return $threads;
    }

    public function sendThreadMessage(Request $request, Thread $thread)
    {
        // if($thread->visibility == 'private'){

        //     if(! $this->authorizePrivateThread($request, $thread)){

        //         return response()->json([
        //                                     'success'=>false,
        //                                     'data'=>[
        //                                         'message'=>'Thread requires a correct secret or token'
        //                                         ]
        //                                     ],
        //                                     $this->validationFailed);
        //     }
        // }
        $thread->load('messages');

        $request->validate([
            "message" => "required_without:image_url"
        ]);


        if ($request->message_id) {
            $parentMessage = $thread->messages->where('id',$request->message_id)->first();
            abort_unless($parentMessage,403,"Invalid message on thread");
        }

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


        $tmessage = ThreadMessage::create(
            [
                'message' => $message,
                'thread_id' => $thread->id,
                'parent_id' => $request->message_id,

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



        return response()->json(['success' => true, 'data' => $tmessage->load('parent')]);
    }
}
