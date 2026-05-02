<?php

namespace App\Http\Controllers;

use App\Http\Requests\EventParticipantRequest;
use App\Http\Resources\EventParticipantResource;
use App\Models\Event;
use App\Models\EventParticipant;
use App\Models\Massa;
use App\Services\TicketImageGenerator;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;

class EventParticipantController extends Controller
{
    public function index(Event $event)
    {
        $participants = $event->participants()->with('massa')->latest()->get();

        return EventParticipantResource::collection($participants);
    }

    public function store(EventParticipantRequest $request, Event $event)
    {
        $validated = $request->validated();

        $massaData = Arr::except($validated, ['photo', 'message']);
        $massaData['status'] = 'active';

        $massa = Massa::where('nik', $validated['nik'])->first();

        if ($massa) {
            $massa->update($massaData);
        } else {
            $massa = Massa::create($massaData);
        }

        if ($request->hasFile('photo')) {
            if ($massa->photo) {
                $massa->deletePhoto();
            }
            $massa->photo = Massa::uploadPhoto($request->file('photo'), $massa->nik);
            $massa->save();
        }

        $participant = $event->participants()->create([
            'massa_id' => $massa->id,
            'message' => $validated['message'] ?? null,
        ]);

        return new EventParticipantResource($participant->load('massa'));
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

        $participant->update([
            'status' => $request->status,
            'attended_at' => $request->status === 'attended' ? now() : null,
        ]);

        return new EventParticipantResource($participant->load('massa'));
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
        $participant = EventParticipant::with('massa')->where('participant_code', $participantCode)->first();

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

        $participant->update([
            'status' => 'attended',
            'attended_at' => now(),
        ]);

        return (new EventParticipantResource($participant))->additional([
            'message' => 'Check-in successful! Welcome, '.$participant->massa->full_name,
        ]);
    }

    public function downloadTicket(string $participantCode)
    {
        $participant = EventParticipant::with(['massa', 'event'])->where('participant_code', $participantCode)->firstOrFail();

        $generator = new TicketImageGenerator($participant);
        $imageData = $generator->generate();

        return response($imageData)
            ->header('Content-Type', 'image/png')
            ->header('Content-Disposition', 'attachment; filename="Ticket_'.$participant->participant_code.'.png"');
    }
}
