<?php

namespace App\Filament\Resources;

use App\Filament\Resources\VideoResource\Pages;
use App\Models\Video;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables\Table;
use Filament\Forms\Components\TextInput; 
use Filament\Forms\Components\FileUpload; // PENTING: Untuk form
use Filament\Tables\Columns\TextColumn; 
use Filament\Tables\Columns\ImageColumn; // PENTING: Untuk tabel
use Filament\Tables\Actions;

class VideoResource extends Resource
{
    protected static ?string $model = Video::class;
    protected static ?string $navigationIcon = 'heroicon-o-camera';

    // ----------------------------------------------------
    // 1. FORM (Digunakan saat Edit atau Create)
    // ----------------------------------------------------
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('judul')
                    ->required()
                    ->maxLength(255),
                
                // Field untuk Media File (Foto atau Video)
                FileUpload::make('video_path')
                    ->label('Media File (Foto atau Video)')
                    ->disk('public') // Harus sesuai dengan disk penyimpanan
                    ->acceptedFileTypes(['image/', 'video/']) // Menerima kedua tipe file
                    ->image() // Mengaktifkan pratinjau gambar
                    ->previewable(true)
                    ->downloadable()
                    ->maxSize(500000), // Maksimal 500MB
            ]);
    }

    // ----------------------------------------------------
    // 2. TABLE (Digunakan di halaman daftar utama admin)
    // ----------------------------------------------------
    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')
                    ->sortable(),
                TextColumn::make('judul')
                    ->searchable()
                    ->sortable(),
                
                // Kolom untuk pratinjau FOTO (akan kosong jika file adalah video)
                ImageColumn::make('video_path') 
                    ->label('Foto Preview')
                    ->disk('public') 
                    ->height(80),

                // Kolom untuk Tautan Video/Media (berguna untuk file non-gambar)
                TextColumn::make('video_path')
                    ->searchable()
                    ->label('Tautan Video/File')
                    ->url(fn (Video $record) => asset('storage/' . $record->video_path), true)
                    ->openUrlInNewTab()
                    ->toggleable(isToggledHiddenByDefault: true),
                
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                Actions\EditAction::make(),
                Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Actions\BulkActionGroup::make([
                    Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    // ----------------------------------------------------
    // 3. RELATIONS & PAGES
    // ----------------------------------------------------
    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListVideos::route('/'),
            'create' => Pages\CreateVideo::route('/create'),
            'edit' => Pages\EditVideo::route('/{record}/edit'),
  ];
}
}