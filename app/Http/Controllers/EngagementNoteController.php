<?php

namespace App\Http\Controllers;

use App\Actions\FindEngagement;
use App\Http\Requests\EngagementNoteRequest;
use App\Models\EngagementNote;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EngagementNoteController extends Controller
{

    public function index($engagementId)
    {
        $engagement = FindEngagement::find($engagementId);
        $notes = EngagementNote::where('engagement_id', $engagement->id)->get();
        return response()->success(Response::HTTP_OK, 'Request Successful', ['notes' => $notes]);
    }


    public function store(EngagementNoteRequest $request, $engagementId)
    {
        $user = auth()->user();
        $engagement = FindEngagement::find($engagementId);
        $note = $engagement->note()->create(['message' => $request->message, 'engagement_stage_id' => $engagement->status, 'engagement_note_flag_id' => $request->engagement_note_flag_id, 'user_id' => $user->id, 'company_id' => $user->company_id]);
        return response()->success(Response::HTTP_CREATED, 'Request Successful', ['note' => $note]);
    }


    public function show($engagementId, $noteId)
    {
        $note = $this->find($engagementId, $noteId);
        return response()->success(Response::HTTP_CREATED, 'Request Successful', ['note' => $note]);
    }

    public function update(Request $request, $engagementId, $noteId)
    {
        $note = $this->find($engagementId, $noteId);
        $note->update($request->except(['company_id', 'user_id', 'engagement_id']));
        return response()->success(Response::HTTP_CREATED, 'Request Successful', ['note' => $note]);
    }


    public function destroy($engagementId, $noteId)
    {
        //
    }

    private function find($engagementId, $noteId)
    {
        $note = EngagementNote::with('user:id,first_name,last_name', 'engagement:id,name:year', 'flag:id,name,description', 'stage:id,name,description')
            ->where([['id', $noteId], ['engagement_id', $engagementId], ['company_id', auth()->user()->company_id]])->first();
        if ($note == null) {
            throw new HttpResponseException(response()->error(Response::HTTP_NOT_FOUND, 'Note does not exist'));
        } else {
            return $note;
        }
    }
}
