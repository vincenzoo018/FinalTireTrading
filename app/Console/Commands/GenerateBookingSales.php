<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Booking;
use App\Models\Sale;

class GenerateBookingSales extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sales:generate-bookings';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate sales records for all completed bookings';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Generating sales from completed bookings...');

        $completedBookings = Booking::with('service')
            ->where('status', 'completed')
            ->get();

        $this->info("Found {$completedBookings->count()} completed bookings");

        $created = 0;
        $skipped = 0;

        foreach ($completedBookings as $booking) {
            // Check if sale already exists
            $existingSale = Sale::where('booking_id', $booking->booking_id)->first();
            
            if ($existingSale) {
                $this->warn("Booking #{$booking->booking_id} already has a sale record (Sale #{$existingSale->sale_id})");
                $skipped++;
                continue;
            }

            if (!$booking->service) {
                $this->warn("Booking #{$booking->booking_id} has no service attached. Skipping.");
                $skipped++;
                continue;
            }

            try {
                $totalAmount = $booking->service->service_price;
                
                $sale = Sale::create([
                    'order_id' => null,
                    'booking_id' => $booking->booking_id,
                    'user_id' => $booking->user_id,
                    'subtotal' => $totalAmount - ($totalAmount * 0.12),
                    'tax' => $totalAmount * 0.12,
                    'shipping' => 0,
                    'total_amount' => $totalAmount,
                    'payment_method' => $booking->payment_method ?? 'Cash',
                    'created_at' => $booking->served_date ?? $booking->updated_at,
                    'updated_at' => now(),
                ]);

                $this->info("✓ Created sale #{$sale->sale_id} for booking #{$booking->booking_id} (₱" . number_format($totalAmount, 2) . ")");
                $created++;
            } catch (\Exception $e) {
                $this->error("✗ Error creating sale for booking #{$booking->booking_id}: {$e->getMessage()}");
            }
        }

        $this->newLine();
        $this->info("========================================");
        $this->info("Summary:");
        $this->info("Total completed bookings: {$completedBookings->count()}");
        $this->info("Sales created: {$created}");
        $this->info("Skipped: {$skipped}");
        $this->info("========================================");

        $totalBookingSales = Sale::whereNotNull('booking_id')->count();
        $totalRevenue = Sale::whereNotNull('booking_id')->sum('total_amount');
        
        $this->newLine();
        $this->info("Total booking sales in database: {$totalBookingSales}");
        $this->info("Total booking revenue: ₱" . number_format($totalRevenue, 2));

        return Command::SUCCESS;
    }
}
