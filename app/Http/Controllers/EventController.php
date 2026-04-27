<?php

namespace App\Http\Controllers;

use App\Http\Requests\EventRequest;
use App\Http\Resources\EventResource;
use App\Models\Event;

class EventController extends Controller
{
    public function index()
    {
        $events = Event::with('category')->withCount('participants')->latest()->get();

        return EventResource::collection($events);
    }

    public function store(EventRequest $request)
    {
        $event = Event::create($request->validated());
        $event->load('category');

        return new EventResource($event);
    }

    public function show(Event $event)
    {
        $event->load(['category', 'participants'])->loadCount('participants');

        return new EventResource($event);
    }

    public function update(EventRequest $request, Event $event)
    {
        $event->update($request->validated());
        $event->load('category');

        return new EventResource($event);
    }

    public function destroy(Event $event)
    {
        $event->delete();

        return response()->json(['message' => 'Event deleted successfully']);
    }
}
