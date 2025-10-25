<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Medicine;
use Illuminate\Support\Facades\Storage;

class MedicineSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
    // Use the provided CSV file (semicolon-delimited, Indonesian headers)
    // Use absolute path on Windows; do not prefix with base_path
    $csvPath = 'E:/TUGAS/Data obat tst.csv';
        
        // Create data directory if it doesn't exist
        if (!file_exists(database_path('seeders/data'))) {
            mkdir(database_path('seeders/data'), 0755, true);
        }

        // Process the CSV file
        if (file_exists($csvPath)) {
            if (($handle = fopen($csvPath, 'r')) !== false) {
                // Read the entire file
                $content = file_get_contents($csvPath);
                // Remove any BOM
                $content = preg_replace('/^\xEF\xBB\xBF/', '', $content);
                // Normalize line endings
                $content = str_replace(["\r\n", "\r"], "\n", $content);
                
                // Create a memory stream with the normalized content
                $stream = fopen('php://memory', 'r+');
                fwrite($stream, $content);
                rewind($stream);
                
                $header = null;
                $lineNum = 0;

                // semicolon delimiter for this CSV
                while (($row = fgetcsv($stream, 10000, ';')) !== false) {
                    $lineNum++;
                    
                    if (!$header) {
                        // Convert header to lowercase, replace spaces with underscores and trim
                        $header = array_map(function($item) {
                            $h = strtolower(trim($item));
                            $h = str_replace([' ', '\r', '\n'], ['_', '', ''], $h);
                            return $h;
                        }, $row);
                        continue;
                    }

                    // Skip empty rows
                    if (count(array_filter($row)) === 0) continue;
                    
                    // Combine header with row data
                    $data = array_combine($header, array_map('trim', $row));

                    // Normalize header keys mapping (Indonesian -> model keys)
                    $normalized = [];
                    foreach ($data as $k => $v) {
                        $kk = $k;
                        // map common Indonesian headers to English/model keys
                        $map = [
                            'kelas_terapi' => 'therapy_class',
                            'sub_kelas_terapi' => 'sub_therapy_class',
                            'nama_obat' => 'name',
                            'sediaan' => 'sediaan',
                            'kekuatan' => 'kekuatan',
                            'satuan' => 'satuan',
                            'peresepan_maksimal' => 'peresepan_maksimal',
                            'restriksi_kelas_terapi' => 'restriksi_kelas_terapi',
                            'indikasi' => 'indications',
                            'kontraindikasi' => 'contraindications',
                            'efek_samping' => 'side_effects',
                            'petunjuk_penggunaan' => 'dosage_instructions',
                            'deskripsi' => 'description',
                            'manufacturer' => 'manufacturer',
                            'kategori' => 'category',
                        ];

                        if (isset($map[$kk])) {
                            $normalized[$map[$kk]] = $v;
                        } else {
                            // keep as-is for unknown headers
                            $normalized[$kk] = $v;
                        }
                    }

                    try {
                        // Map CSV (normalized) to database columns
                        $medicineData = [
                            'name' => $normalized['name'] ?? ($normalized['nama_obat'] ?? null),
                            'therapy_class' => $normalized['therapy_class'] ?? ($normalized['kelas_terapi'] ?? null),
                            'sub_therapy_class' => $normalized['sub_therapy_class'] ?? ($normalized['sub_kelas_terapi'] ?? null),
                            'generic_name' => $normalized['generic_name'] ?? $normalized['name'] ?? null,
                            'category' => $normalized['category'] ?? ($normalized['therapy_class'] ?? 'Uncategorized'),
                            'sediaan' => $normalized['sediaan'] ?? null,
                            'kekuatan' => $normalized['kekuatan'] ?? null,
                            'satuan' => $normalized['satuan'] ?? null,
                            'peresepan_maksimal' => !empty($normalized['peresepan_maksimal']) ? intval($normalized['peresepan_maksimal']) : null,
                            'restriksi_kelas_terapi' => $normalized['restriksi_kelas_terapi'] ?? null,
                            'description' => $normalized['description'] ?? ($normalized['deskripsi'] ?? null),
                            'dosage_form' => $normalized['sediaan'] ?? null,
                            'strength' => isset($normalized['kekuatan']) ? trim($normalized['kekuatan'] . ' ' . ($normalized['satuan'] ?? '')) : null,
                            'manufacturer' => $normalized['manufacturer'] ?? null,
                            // expiry_date is required in DB migration; use default 2 years from now when missing
                            'expiry_date' => !empty($normalized['expiry_date']) ? date('Y-m-d', strtotime($normalized['expiry_date'])) : date('Y-m-d', strtotime('+2 years')),
                            'indications' => $normalized['indications'] ?? ($normalized['indikasi'] ?? null),
                            'contraindications' => $normalized['contraindications'] ?? ($normalized['kontraindikasi'] ?? null),
                            'side_effects' => $normalized['side_effects'] ?? ($normalized['efek_samping'] ?? null),
                            'dosage_instructions' => $normalized['dosage_instructions'] ?? ($normalized['petunjuk_penggunaan'] ?? null),
                            'created_by' => 1,
                            'updated_by' => 1,
                        ];

                        // Skip if name is empty (required field)
                        if (empty($medicineData['name'])) {
                            $this->command->warn("Skipping row $lineNum: Empty medicine name");
                            continue;
                        }

                        // Find existing medicine or create new one
                        $medicine = Medicine::firstOrNew(['name' => $medicineData['name']]);

                        // Fill and save
                        $medicine->fill($medicineData);
                        if (empty($medicine->category)) {
                            $medicine->category = $medicine->therapy_class ?? 'Uncategorized';
                        }

                        try {
                            $medicine->save();
                        } catch (\Exception $e) {
                            $this->command->error("Error saving medicine (row $lineNum): " . $e->getMessage());
                        }

                    } catch (\Exception $e) {
                        $this->command->error("Error on row $lineNum: " . $e->getMessage());
                        continue;
                    }
                }
                fclose($handle);
                $this->command->info('Medicine data seeded successfully!');
            }
        } else {
            $this->command->error("CSV file not found at: $csvPath");
        }
    }
}