<?php

namespace App\Http\Controllers;

use App\Http\Requests\EventParticipantRequest;
use App\Http\Resources\EventParticipantResource;
use App\Models\Event;
use App\Models\EventParticipant;
use Illuminate\Http\Request;

class EventParticipantController extends Controller
{
    public function index(Event $event)
    {
        $participants = $event->participants()->latest()->get();

        return EventParticipantResource::collection($participants);
    }

    public function store(EventParticipantRequest $request, Event $event)
    {
        $participant = $event->participants()->create($request->validated());

        return new EventParticipantResource($participant);
    }

    public function updateStatus(Request $request, Event $event, EventParticipant $participant)
    {
        // Ensure the participant belongs to the specified event
        if ($participant->event_id !== $event->id) {
            return response()->json(['message' => 'Participant does not belong to this event.'], 422);
        }

        $request->validate([
            'status' => 'required|in:registered,attended',
        ]);

        $participant->update(['status' => $request->status]);

        return new EventParticipantResource($participant);
    }

    public function scanQr(Event $event, string $participantCode)
    {
        // Check if event is active/valid for check-in
        if ($event->status === 'cancelled') {
            return response()->json(['message' => 'This event has been cancelled.'], 422);
        }

        if ($event->status === 'draft') {
            return response()->json(['message' => 'This event is still in draft and not open for check-in.'], 422);
        }

        // Find participant by code globally first to give better feedback
        $participant = EventParticipant::where('participant_code', $participantCode)->first();

        if (! $participant) {
            return response()->json(['message' => 'Invalid participant code.'], 404);
        }

        // Validate event ownership
        if ($participant->event_id !== $event->id) {
            return response()->json([
                'message' => 'This participant is registered for a different event: '.$participant->event->name,
                'registered_event' => $participant->event->name,
            ], 422);
        }

        if ($participant->status === 'attended') {
            return response()->json([
                'message' => 'Participant already checked in.',
                'participant' => new EventParticipantResource($participant),
            ], 422);
        }

        $participant->update(['status' => 'attended']);

        return (new EventParticipantResource($participant))->additional([
            'message' => 'Check-in successful! Welcome, '.$participant->name,
        ]);
    }
}
