<?php

namespace App\Console\Commands;

use App\Http\Helpers\GeoCodeHelper;
use App\Models\ListingAddress;
use Illuminate\Console\Command;

class GeoAddressUpdate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = "geo:address_update {--listing_id=} {--limit=50}";
    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = "Save each tenant's latitude and longitude by their address";

    /**
     * Create a new command instance.
     *
     * @return void
     */

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $query = ListingAddress::query();

        if ($listing_id = $this->option('listing_id')) {
            $query->where('listing_id', $listing_id);
        } else {
            $query->where('sync_geo', 1)->where('sync_geo_failed', '<', 5);
        }

        $listing_addresses = $query->limit($this->option('limit'))->get();
        $i = 1;
        $total = $listing_addresses->count();

        foreach ($listing_addresses as $address) {
            try {
                $message = "{$i}/{$total} Geo updates #{$address->id}: ";
                $search_addr = implode(',', array_filter([$address->street, $address->city, $address->country, $address->postcode]));
                $message .= $search_addr;
                if ($search_addr) {
                    $result = GeoCodeHelper::getCoordinatesForAddress($search_addr);

                    if ($result['lat'] && $result['lng']) {
                        $address->longitude = $result['lng'];
                        $address->latitude = $result['lat'];
                        $address->sync_geo = 0;
                        $address->sync_geo_failed = 0;
                        $message .= " successfully";
                    } else {
                        $message .= " failed";
                        $address->sync_geo_failed = $address->sync_geo_failed + 1;
                    }
                }
            } catch (\Exception $e) {
                $address->sync_geo_failed = $address->sync_geo_failed + 1;
                $message .= " failed";
            } finally {
                $address->saveWithoutEvents();
            }
            $this->info($message);
            $i++;
        }
        $this->info('lattitude and longitude set successfully');
    }
}
