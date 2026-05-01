<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

#[Fillable([
    'council_report_id', 'file_path', 'file_name',
    'media_type', 'caption', 'sort_order',
])]
class CouncilReportMedia extends Model
{
    /**
     * Upload a media file and return the stored filename.
     */
    public static function uploadMedia(UploadedFile $file, int $reportId): string
    {
        $filename = time().'-'.$reportId.'-'.uniqid().'.'.$file->getClientOriginalExtension();
        $file->storeAs('council-reports', $filename, 'public');

        return $filename;
    }

    /**
     * Determine the media type based on file MIME type.
     */
    public static function resolveMediaType(UploadedFile $file): string
    {
        $mime = $file->getMimeType();

        if (str_starts_with($mime, 'image/')) {
            return 'photo';
        }

        if (str_starts_with($mime, 'video/')) {
            return 'video';
        }

        return 'document';
    }

    /**
     * Delete the media file from storage.
     */
    public function deleteMedia(): void
    {
        if ($this->file_path && Storage::disk('public')->exists('council-reports/'.$this->file_path)) {
            Storage::disk('public')->delete('council-reports/'.$this->file_path);
        }
    }

    /**
     * Get the council report that owns the media.
     */
    public function councilReport(): BelongsTo
    {
        return $this->belongsTo(CouncilReport::class);
    }
}
