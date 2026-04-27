<?php

namespace App\Http\Controllers;

use App\Http\Requests\EventParticipantRequest;
use App\Http\Resources\EventParticipantResource;
use App\Models\Event;

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
}
