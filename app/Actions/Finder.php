<?php

namespace App\Actions;

use App\Models\Client;
use App\Models\Conclusion;
use App\Models\Engagement;
use App\Models\EngagementNote;
use App\Models\Execution;
use App\Models\Message;
use App\Models\Planning;
use Illuminate\Http\Exceptions\HttpResponseException;
use Symfony\Component\HttpFoundation\Response;

class Finder
{

    public static function client($clientId)
    {
        $client = Client::with('company', 'directors', 'groups')->where('id', $clientId)->when(auth()->check(), function ($query) {
            return $query->where('company_id', auth()->user()->company_id);
        })->select('id', 'company_id', 'name', 'email', 'phone', 'address', 'registered_address', 'is_public_entity', 'nature_of_business', 'status')->first();
        if ($client == null) {
            throw new HttpResponseException(response()->error(Response::HTTP_NOT_FOUND, 'Client does not exist'));
        } else {
            return $client;
        }
    }

    public static function message($messageId)
    {
        $message = Message::with('documents:id,message_id,url')->where([['id', $messageId], ['company_id', auth()->user()->company_id]])->first();
        if ($message == null) {
            throw new HttpResponseException(response()->error(Response::HTTP_NOT_FOUND, 'Message does not exist'));
        } else {
            return $message;
        }
    }

    public static function engagement($engagementId)
    {
        $engagement = Engagement::with(['client', 'planning', 'execution', 'conclusion', 'status', 'teamMembers' => function ($query) {
            $query->with('role', 'user');
        }])->where([['id', $engagementId], ['company_id', auth()->user()->company_id]])->first();
        if ($engagement == null) {
            throw new HttpResponseException(response()->error(Response::HTTP_NOT_FOUND, 'Engagement does not exist'));
        } else {
            return $engagement;
        }
    }

    public static function planning($planningId)
    {
        $planning = Planning::where([['id', $planningId], ['company_id', auth()->user()->company_id]])->first();
        if ($planning == null) {
            throw new HttpResponseException(response()->error(Response::HTTP_NOT_FOUND, 'Planning does not exist'));
        } else {
            return $planning;
        }
    }

    public static function execution($executionId)
    {
        $execution = Execution::where([['id', $executionId], ['company_id', auth()->user()->company_id]])->first();
        if ($execution == null) {
            throw new HttpResponseException(response()->error(Response::HTTP_NOT_FOUND, 'Execution does not exist'));
        } else {
            return $execution;
        }
    }

    public static function conclusion($conclusionId)
    {
        $conclusion = Conclusion::where([['id', $conclusionId], ['company_id', auth()->user()->company_id]])->first();
        if ($conclusion == null) {
            throw new HttpResponseException(response()->error(Response::HTTP_NOT_FOUND, 'Conclusion does not exist'));
        } else {
            return $conclusion;
        }
    }

    public static function note($noteId)
    {
        $note = EngagementNote::with('user:id,first_name,last_name', 'engagement:id,name:year', 'flag:id,name,description', 'stage:id,name,description')
            ->where('id', $noteId)->first();
        if ($note == null) {
            throw new HttpResponseException(response()->error(Response::HTTP_NOT_FOUND, 'Note does not exist'));
        } else {
            return $note;
        }
    }
}
