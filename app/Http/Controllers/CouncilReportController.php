<?php

namespace App\Http\Controllers;

use App\Http\Requests\CouncilReportRequest;
use App\Http\Resources\CouncilReportResource;
use App\Models\CouncilReport;
use App\Models\CouncilReportMedia;

class CouncilReportController extends Controller
{
    public function index()
    {
        $reports = CouncilReport::with(['user', 'media'])->withCount('media')->latest()->get();

        return CouncilReportResource::collection($reports);
    }

    public function store(CouncilReportRequest $request)
    {
        $data = $request->validated();
        $data['user_id'] = $request->user()->id;

        unset($data['media'], $data['media_captions']);

        $report = CouncilReport::create($data);

        $this->uploadMedia($request, $report);

        $report->load(['user', 'media']);

        return new CouncilReportResource($report);
    }

    public function show(CouncilReport $councilReport)
    {
        $councilReport->load(['user', 'media'])->loadCount('media');

        return new CouncilReportResource($councilReport);
    }

    public function update(CouncilReportRequest $request, CouncilReport $councilReport)
    {
        $data = $request->validated();

        unset($data['media'], $data['media_captions']);

        $councilReport->update($data);

        $this->uploadMedia($request, $councilReport);

        $councilReport->load(['user', 'media']);

        return new CouncilReportResource($councilReport);
    }

    public function destroy(CouncilReport $councilReport)
    {
        $councilReport->media->each->deleteMedia();
        $councilReport->delete();

        return response()->json(['message' => 'Council report deleted successfully']);
    }

    /**
     * Delete a specific media file from a council report.
     */
    public function deleteMedia(CouncilReport $councilReport, CouncilReportMedia $media)
    {
        if ($media->council_report_id !== $councilReport->id) {
            abort(404);
        }

        $media->deleteMedia();
        $media->delete();

        return response()->json(['message' => 'Media deleted successfully']);
    }

    /**
     * Handle uploading multiple media files for a report.
     */
    private function uploadMedia(CouncilReportRequest $request, CouncilReport $report): void
    {
        if (! $request->hasFile('media')) {
            return;
        }

        $captions = $request->input('media_captions', []);
        $currentMaxSort = $report->media()->max('sort_order') ?? 0;

        foreach ($request->file('media') as $index => $file) {
            $filePath = CouncilReportMedia::uploadMedia($file, $report->id);

            $report->media()->create([
                'file_path' => $filePath,
                'file_name' => $file->getClientOriginalName(),
                'media_type' => CouncilReportMedia::resolveMediaType($file),
                'caption' => $captions[$index] ?? null,
                'sort_order' => $currentMaxSort + $index + 1,
            ]);
        }
    }
}
