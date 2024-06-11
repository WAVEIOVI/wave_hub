<?php

namespace App\Http\Controllers\Api\WaveFire\Inventory;

use App\Models\Park;
use App\Models\Client;
use App\Models\ClAddress;
use Orion\Http\Controllers\Controller;
use Orion\Http\Requests\Request;
use Orion\Concerns\DisableAuthorization;
use App\Events\ParkCreated;



class ParksController extends Controller
{
    use DisableAuthorization;

    /**
     * Fully-qualified model class name
     */
    protected $model = Park::class; // or "App\Models\Park"

    public function searchableBy(): array
    {
        return [
            'park_id',
            'client_name',
            'park_title',
            'park_address',
            'park_postcode',
            'park_city',
            'park_country'
        ];
    }
    public function filterableBy(): array
    {
        return ['client_name', 'park_city', 'park_type'];
    }
    public function sortableBy(): array
    {
        return ['created_at'];
    }
    protected function beforeStore(Request $request, $park)
    {
        $client = Client::find($request->input('client_id'));
        $park->park_client_id = $client->client_id;
        $park->client_name = $client->client_name;
        $cl_address = ClAddress::find($request->input('park_title'));
        $park->park_title = $cl_address->cl_address_title;
        $park->park_address = $cl_address->cl_address_description;
        $park->park_postcode = $cl_address->cl_address_postcode;
        $park->park_city = $cl_address->cl_address_city;
        $park->park_country = $cl_address->cl_address_country;
    }
    protected function afterStore(Request $request, $park)
    {
        event(new ParkCreated($park));

        return $park;
    }
}
