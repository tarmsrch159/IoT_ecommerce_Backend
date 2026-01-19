<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class SupabaseStorageService
{
    public function upload(
        UploadedFile $file,
        string $bucket,
        string $folder
    ): string {
        $fileName = Str::uuid() . '.' . $file->getClientOriginalExtension();
        $path = trim($folder, '/') . '/' . $fileName;
        
        /** @var \Illuminate\Http\Client\Response $response */
        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . config('services.supabase.service_key'),
            'apikey' => config('services.supabase.service_key'),
            'Content-Type' => $file->getMimeType(),
        ])->withBody(
            fopen($file->getRealPath(), 'r'),
            $file->getMimeType()
        )->post(
            config('services.supabase.url')
            . "/storage/v1/object/$bucket/$path"
        );

        if (!$response->successful()) {
            throw new \Exception($response->body());
        }

        return config('services.supabase.url')
            . "/storage/v1/object/public/$bucket/$path";
    }

    public function delete(string $publicUrl): void
    {
        $base = config('services.supabase.url') . '/storage/v1/object/public/';
        $objectPath = str_replace($base, '', $publicUrl);

        Http::withHeaders([
            'Authorization' => 'Bearer ' . config('services.supabase.service_key'),
            'apikey' => config('services.supabase.service_key'),
        ])->delete(
            config('services.supabase.url')
            . "/storage/v1/object/$objectPath"
        );
    }
}
