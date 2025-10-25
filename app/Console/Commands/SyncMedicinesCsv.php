<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Medicine;

class SyncMedicinesCsv extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'medicines:sync-csv {--prune : Delete medicines not present in the CSV}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sync medicines table with the CSV data file (E:\\TUGAS\\Data obat tst.csv)';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        // delegate to callable-friendly runner so routes/console.php can invoke it
        return $this->runFromConsole($this->getOutput(), $this->option('prune'));
    }

    /**
     * Run the sync logic. Returns exit code.
     */
    public function runFromConsole($output, bool $prune = false): int
    {
        $csvPath = 'E:/TUGAS/Data obat tst.csv';

        if (!file_exists($csvPath)) {
            $output->writeln("<error>CSV file not found at: $csvPath</error>");
            return 1;
        }

        $content = file_get_contents($csvPath);
        // strip BOM if present
        $content = preg_replace('/^\xEF\xBB\xBF/', '', $content);
        $content = str_replace(["\r\n", "\r"], "\n", $content);

        $stream = fopen('php://memory', 'r+');
        fwrite($stream, $content);
        rewind($stream);

        $header = null;
        $lineNum = 0;
        $seenNames = [];
        $inserted = 0;
        $updated = 0;

        while (($row = fgetcsv($stream, 10000, ';')) !== false) {
            $lineNum++;
            if (!$header) {
                $header = array_map(function ($item) {
                    $h = strtolower(trim($item));
                    $h = str_replace([' ', '\r', '\n'], ['_', '', ''], $h);
                    return $h;
                }, $row);
                continue;
            }

            if (count(array_filter($row)) === 0) continue;

            $data = array_combine($header, array_map('trim', $row));

            // mapping
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
                'expiry_date' => 'expiry_date',
            ];

            $normalized = [];
            foreach ($data as $k => $v) {
                if (isset($map[$k])) {
                    $normalized[$map[$k]] = $v;
                } else {
                    $normalized[$k] = $v;
                }
            }

            $medicineData = [
                'name' => $normalized['name'] ?? ($normalized['nama_obat'] ?? null),
                'therapy_class' => $normalized['therapy_class'] ?? null,
                'sub_therapy_class' => $normalized['sub_therapy_class'] ?? null,
                'generic_name' => $normalized['generic_name'] ?? ($normalized['name'] ?? null),
                'category' => $normalized['category'] ?? ($normalized['therapy_class'] ?? 'Uncategorized'),
                'sediaan' => $normalized['sediaan'] ?? null,
                'kekuatan' => $normalized['kekuatan'] ?? null,
                'satuan' => $normalized['satuan'] ?? null,
                'peresepan_maksimal' => !empty($normalized['peresepan_maksimal']) ? intval($normalized['peresepan_maksimal']) : null,
                'restriksi_kelas_terapi' => $normalized['restriksi_kelas_terapi'] ?? null,
                'description' => $normalized['description'] ?? null,
                'dosage_form' => $normalized['sediaan'] ?? null,
                'strength' => isset($normalized['kekuatan']) ? trim($normalized['kekuatan'] . ' ' . ($normalized['satuan'] ?? '')) : null,
                'manufacturer' => $normalized['manufacturer'] ?? null,
                'expiry_date' => !empty($normalized['expiry_date']) ? date('Y-m-d', strtotime($normalized['expiry_date'])) : date('Y-m-d', strtotime('+2 years')),
                'indications' => $normalized['indications'] ?? null,
                'contraindications' => $normalized['contraindications'] ?? null,
                'side_effects' => $normalized['side_effects'] ?? null,
                'dosage_instructions' => $normalized['dosage_instructions'] ?? null,
            ];

            if (empty($medicineData['name'])) {
                $output->writeln("<comment>Skipping row $lineNum: empty name</comment>");
                continue;
            }

            $seenNames[] = $medicineData['name'];

            $medicine = Medicine::firstOrNew(['name' => $medicineData['name']]);
            $wasRecently = !$medicine->exists;
            // assign allowed fields via fill
            $medicine->fill($medicineData);
            // ensure created_by/updated_by are explicitly set to avoid mass-assignment restrictions
            $medicine->created_by = $medicine->created_by ?? 1;
            $medicine->updated_by = 1;
            if (empty($medicine->category)) $medicine->category = $medicine->therapy_class ?? 'Uncategorized';
            try {
                $medicine->save();
                if ($wasRecently) $inserted++; else $updated++;
            } catch (\Exception $e) {
                $output->writeln("<error>Failed saving row $lineNum (" . $medicineData['name'] . "): " . $e->getMessage() . "</error>");
            }
        }

        fclose($stream);

        $output->writeln("Inserted: $inserted, Updated: $updated");

        if ($prune) {
            $output->writeln('<info>Prune enabled: removing medicines not present in CSV</info>');
            $deleted = Medicine::whereNotIn('name', $seenNames)->delete();
            $output->writeln("Deleted: $deleted");
        } else {
            $output->writeln('Prune not enabled; no deletions performed.');
        }

    return 0;
    }

}
