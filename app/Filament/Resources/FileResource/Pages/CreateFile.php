<?php

namespace App\Filament\Resources\FileResource\Pages;

use App\Filament\Resources\FileResource;
use App\Models\File;
use Filament\Resources\Pages\CreateRecord;
use Filament\Schemas\Schema;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class CreateFile extends CreateRecord
{
    protected static string $resource = FileResource::class;

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                FileUpload::make('file')
                    ->label('Upload File')
                    ->required()
                    ->disk('public')
                    ->directory('files')
                    ->preserveFilenames(true)  // Keep original filename
                    ->maxSize(10240)
                    ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/gif', 'image/webp'])
                    ->helperText('Max size: 10MB. Allowed: JPG, PNG, GIF, WEBP')
                    ->columnSpanFull(),
                
                Select::make('collection')
                    ->label('Collection')
                    ->options([
                        'products' => 'Products',
                        'posts' => 'Posts',
                        'avatars' => 'Avatars',
                        'general' => 'General',
                    ])
                    ->required(),
                
                Textarea::make('description')
                    ->label('Description')
                    ->rows(3)
                    ->columnSpanFull(),
            ]);
    }

    protected function handleRecordCreation(array $data): \Illuminate\Database\Eloquent\Model
    {
        $user = Auth::user();
        
        // Get the file path from form data
        $fileInput = $data['file'] ?? null;
        
        if (!$fileInput) {
            throw new \Exception('No file was uploaded.');
        }
        
        // Handle different file input formats
        $filePath = null;
        
        if (is_string($fileInput)) {
            $filePath = $fileInput;
        } elseif (is_array($fileInput) && isset($fileInput[0])) {
            $filePath = $fileInput[0];
        } else {
            throw new \Exception('Invalid file upload format');
        }
        
        // Get file details
        $fullPath = Storage::disk('public')->path($filePath);
        $originalName = basename($filePath);
        $extension = pathinfo($filePath, PATHINFO_EXTENSION);
        $mimeType = mime_content_type($fullPath);
        $size = filesize($fullPath);
        
        return File::create([
            'name' => pathinfo($originalName, PATHINFO_FILENAME),
            'original_name' => $originalName,
            'path' => $filePath,  // Keep the original path
            'type' => $extension,
            'mime_type' => $mimeType,
            'size' => $size,
            'collection' => $data['collection'],
            'description' => $data['description'] ?? null,
            'user_id' => $user->id,
        ]);
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}