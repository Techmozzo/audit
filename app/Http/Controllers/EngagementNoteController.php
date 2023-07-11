<?php

namespace App\Http\Controllers;

use App\Actions\Finder;
use App\Http\Requests\EngagementNoteRequest;
use App\Models\EngagementNote;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EngagementNoteController extends Controller
{

    public function index($engagementId)
    {
        $engagement = Finder::engagement($engagementId);
        $notes = EngagementNote::where('engagement_id', $engagement->id)->get();
        return response()->success(Response::HTTP_OK, 'Request Successful', ['notes' => $notes]);
    }


    public function store(EngagementNoteRequest $request, $engagementId)
    {
        $user = auth()->user();
        $engagement = Finder::engagement($engagementId);
        $note = $engagement->note()->create(['message' => $request->message, 'engagement_stage_id' => $engagement->status_id, 'engagement_note_flag_id' => $request->engagement_note_flag_id, 'user_id' => $user->id, 'company_id' => $user->company_id]);
        return response()->success(Response::HTTP_CREATED, 'Request Successful', ['note' => $note]);
    }


    public function show($noteId)
    {
        $note = Finder::note($noteId);
        return response()->success(Response::HTTP_CREATED, 'Request Successful', ['note' => $note]);
    }

    public function update(Request $request, $noteId)
    {
        $note = Finder::note($noteId);
        $note->update($request->except(['company_id', 'user_id', 'engagement_id']));
        return response()->success(Response::HTTP_CREATED, 'Request Successful', ['note' => $note]);
    }


    public function destroy($engagementId, $noteId)
    {
        //
    }
}
