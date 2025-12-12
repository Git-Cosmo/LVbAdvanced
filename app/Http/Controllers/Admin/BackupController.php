<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Storage;
use Spatie\Backup\BackupDestination\BackupDestination;
use Spatie\Backup\Tasks\Monitor\BackupDestinationStatusFactory;

class BackupController extends Controller
{
    public function index()
    {
        $backupDestinations = BackupDestinationStatusFactory::create()->backupDestinationStatuses();

        $backups = [];
        foreach ($backupDestinations as $backupDestination) {
            foreach ($backupDestination->backups() as $backup) {
                $backups[] = [
                    'path' => $backup->path(),
                    'date' => $backup->date(),
                    'size' => $backup->sizeInBytes(),
                    'disk' => $backupDestination->diskName(),
                ];
            }
        }

        // Sort by date descending
        usort($backups, function($a, $b) {
            return $b['date'] <=> $a['date'];
        });

        $stats = [
            'total_backups' => count($backups),
            'total_size' => array_sum(array_column($backups, 'size')),
            'latest_backup' => $backups[0] ?? null,
            'health_status' => $this->getHealthStatus($backupDestinations),
        ];

        return view('admin.backups.index', compact('backups', 'stats'));
    }

    public function create(Request $request)
    {
        $onlyFiles = $request->input('only_files', false);

        try {
            if ($onlyFiles) {
                Artisan::call('backup:run', ['--only-files' => true]);
            } else {
                Artisan::call('backup:run');
            }

            return redirect()->route('admin.backups.index')
                ->with('success', 'Backup created successfully');
        } catch (\Exception $e) {
            return redirect()->route('admin.backups.index')
                ->with('error', 'Backup failed: ' . $e->getMessage());
        }
    }

    public function download($disk, $path)
    {
        $storage = Storage::disk($disk);

        if (!$storage->exists($path)) {
            abort(404, 'Backup file not found');
        }

        return $storage->download($path);
    }

    public function destroy($disk, $path)
    {
        $storage = Storage::disk($disk);

        if ($storage->exists($path)) {
            $storage->delete($path);
        }

        return redirect()->route('admin.backups.index')
            ->with('success', 'Backup deleted successfully');
    }

    public function clean()
    {
        try {
            Artisan::call('backup:clean');

            return redirect()->route('admin.backups.index')
                ->with('success', 'Old backups cleaned successfully');
        } catch (\Exception $e) {
            return redirect()->route('admin.backups.index')
                ->with('error', 'Cleanup failed: ' . $e->getMessage());
        }
    }

    private function getHealthStatus($backupDestinations)
    {
        $healthy = true;
        
        foreach ($backupDestinations as $destination) {
            if (!$destination->isHealthy()) {
                $healthy = false;
                break;
            }
        }

        return $healthy ? 'healthy' : 'unhealthy';
    }
}
