<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ClaimGaransiResource\Pages;
use App\Models\ClaimGaransi;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Support\Colors\Color;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Storage;

class ClaimGaransiResource extends Resource
{
    // Tentukan model yang akan digunakan
    protected static ?string $model = ClaimGaransi::class;

    // Ubah ikon navigasi dan label yang lebih sesuai
    protected static ?string $navigationIcon = 'heroicon-o-shield-check'; 
    protected static ?string $navigationLabel = 'Klaim Garansi';
    protected static ?int $navigationSort = 3;

    public static function getModelLabel(): string
    {
        return 'Klaim Garansi';
    }

    // Menonaktifkan halaman Create karena klaim dibuat oleh pelanggan
    public static function canCreate(): bool
    {
        return false;
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Card::make([
                    // Data read-only dari klaim
                    Forms\Components\TextInput::make('transaksi_id')
                        ->label('ID Transaksi')
                        ->disabled(), 
                    Forms\Components\TextInput::make('nama_pembeli')
                        ->label('Nama Pembeli')
                        ->disabled(),
                    Forms\Components\Textarea::make('alasan')
                        ->label('Alasan Klaim')
                        ->rows(5)
                        ->disabled()
                        ->columnSpanFull(),
                    
                    // Field untuk mengubah Status
                    Forms\Components\Select::make('status')
                        ->label('Status Klaim')
                        ->options([
                            'Menunggu Konfirmasi' => 'Menunggu Konfirmasi',
                            'Diterima' => 'Diterima',
                            'Ditolak' => 'Ditolak',
                            'Selesai' => 'Selesai',
                        ])
                        ->default('Menunggu Konfirmasi')
                        ->required()
                        ->columnSpanFull(),
                ])->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('transaksi_id')
                    ->label('ID Transaksi')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('nama_pembeli')
                    ->label('Pembeli')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('alasan')
                    ->label('Alasan Singkat')
                    ->limit(50) 
                    ->tooltip(fn ($record) => $record->alasan), 
                
                // Kolom Status dengan badge warna
                Tables\Columns\TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'Menunggu Konfirmasi' => 'warning',
                        'Ditolak' => 'danger',
                        'Diterima' => 'info',
                        'Selesai' => 'success',
                        default => 'secondary',
                    })
                    ->searchable()
                    ->sortable(),

                // Kolom untuk melihat bukti (link ke file)
                Tables\Columns\TextColumn::make('bukti')
                    ->label('Bukti')
                    // Membuat URL menggunakan helper asset() dan prefix 'storage/'
                    ->url(fn (ClaimGaransi $record): string => asset('storage/' . $record->bukti))
                    ->openUrlInNewTab()
                    ->icon('heroicon-o-document-magnifying-glass') 
                    ->placeholder('Tidak Ada Bukti'),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Tanggal Klaim')
                    ->dateTime('d M Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                // Filter berdasarkan Status
                Tables\Filters\SelectFilter::make('status')
                    ->options([
                        'Menunggu Konfirmasi' => 'Menunggu Konfirmasi',
                        'Diterima' => 'Diterima',
                        'Ditolak' => 'Ditolak',
                        'Selesai' => 'Selesai',
                    ])
                    ->label('Filter Status'),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListClaimGaransis::route('/'),
            // Hapus 'create' karena canCreate() diatur ke false
            'edit' => Pages\EditClaimGaransi::route('/{record}/edit'),
  ];
}
}