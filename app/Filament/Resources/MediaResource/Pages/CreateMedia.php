<?php

namespace App\Filament\Resources\MediaResource\Pages;

use App\Filament\Resources\MediaResource;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Form;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Auth;

class CreateMedia extends CreateRecord
{
    protected static string $resource = MediaResource::class;

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                FileUpload::make('file')
                    ->label('Select File')
                    ->required()
                    ->disk('public')
                    ->directory('media')
                    ->preserveFilenames()
                    ->maxSize(10240) // 10MB max
                    ->acceptedFileTypes(['image/*', 'application/pdf', 'application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document'])
                    ->helperText('Max file size: 10MB. Allowed: Images, PDF, DOC, DOCX')
                    ->columnSpanFull(),
                
                Select::make('collection_name')
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
        
        // Get the uploaded file
        $file = $data['file'];
        
        // Create media record
        $media = $user->addMedia($file)
            ->usingName(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME))
            ->usingFileName($file->getClientOriginalName())
            ->withCustomProperties([
                'description' => $data['description'] ?? null,
                'uploaded_by' => $user->name,
                'uploaded_by_id' => $user->id,
            ])
            ->toMediaCollection($data['collection_name']);
        
        return $media;
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function getCreatedNotificationTitle(): string
    {
        return 'File uploaded successfully!';
    }
}