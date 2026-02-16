<?php

namespace App\Console\Commands;

use App\Models\Property;
use Illuminate\Console\Command;

class CheckExpiredListings extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'listings:check-expired';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check and unpublish expired property listings';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Checking for expired listings...');

        // Find all published and approved properties that have expired
        $expiredCount = Property::query()
            ->where('is_published', true)
            ->where('is_approved', true)
            ->whereNotNull('listing_expires_at')
            ->where('listing_expires_at', '<', now())
            ->update([
                'is_published' => false,
                'is_approved' => false,
                'approved_at' => null,
                'approved_by' => null,
            ]);

        $this->info("Processed {$expiredCount} expired listings.");

        return Command::SUCCESS;
    }
}
