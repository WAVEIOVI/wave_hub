<?php

namespace App\Observers;

use App\Models\MissionFolder;
use App\Models\Intervention;
use App\Models\Workshop;
use App\Models\MissionEvent;
use Carbon\Carbon;

class MissionFolderObserver
{
    /**
     * Handle the MissionFolder "created" event.
     */
    public function created(MissionFolder $missionFolder): void
    {
        // Create the first mission event
        $mission_event = new MissionEvent([

            'title' => $missionFolder->mission_id,
            'mission_id' => $missionFolder->mission_id,
            'mission_frequency' => $missionFolder->mission_frequency,
            'client' => $missionFolder->client_name,
            'city' => $missionFolder->park_city,
            'mission_type' => $missionFolder->mission_type,
            'calendar' => 'pending',
        ]);
        $mission_event->save();
        if ($missionFolder->mission_type === 'intervention') {
            $intervention = new Intervention();
            $intervention->mission_folder_id = $missionFolder->id;
            $intervention->intervention_id = $missionFolder->mission_id;
            $intervention->intervention_date = $missionFolder->mission_date;
            $intervention->intervention_duration = $missionFolder->mission_duration;
            $intervention->mission_frequency = $missionFolder->mission_frequency;
            // data client
            $intervention->mission_client_id = $missionFolder->mission_client_id;
            $intervention->client_name = $missionFolder->client_name;
            $intervention->client_website = $missionFolder->client_website;
            $intervention->main_phone_number = $missionFolder->main_phone_number;
            $intervention->client_email = $missionFolder->client_email;
            $intervention->address = $missionFolder->address;
            $intervention->postcode = $missionFolder->postcode;
            $intervention->city = $missionFolder->city;
            $intervention->country = $missionFolder->country;
            // data Park
            $intervention->park = $missionFolder->park;
            $intervention->park_id = $missionFolder->park_id;
            $intervention->park_type = $missionFolder->park_type;
            $intervention->park_title = $missionFolder->park_title;
            $intervention->park_address = $missionFolder->park_address;
            $intervention->park_postcode = $missionFolder->park_postcode;
            $intervention->park_city = $missionFolder->park_city;
            $intervention->park_country = $missionFolder->park_country;
            $intervention->save();
        }
        if ($missionFolder->mission_type === 'workshop') {
            $workshop = new Workshop();
            $workshop->mission_folder_id = $missionFolder->id;
            $workshop->workshop_id = $missionFolder->mission_id;
            $workshop->workshop_date = $missionFolder->mission_date;
            $workshop->workshop_duration = $missionFolder->mission_duration;
            $workshop->mission_frequency = $missionFolder->mission_frequency;
            // data client
            $workshop->mission_client_id = $missionFolder->mission_client_id;
            $workshop->client_name = $missionFolder->client_name;
            $workshop->client_website = $missionFolder->client_website;
            $workshop->main_phone_number = $missionFolder->main_phone_number;
            $workshop->client_email = $missionFolder->client_email;
            $workshop->address = $missionFolder->address;
            $workshop->postcode = $missionFolder->postcode;
            $workshop->city = $missionFolder->city;
            $workshop->country = $missionFolder->country;
            $workshop->save();
        }
    }

    /**
     * Handle the MissionFolder "updated" event.
     */
    public function updated(MissionFolder $missionFolder): void
    {
        // Update the mission event
        $missionEvent = MissionEvent::where('mission_id', $missionFolder->mission_id)
            ->where('calendar', 'pending')
            ->first();

        if ($missionEvent) {
            $missionEvent->mission_frequency = $missionFolder->mission_frequency;
            $missionEvent->start = $missionFolder->mission_date;
            $missionEvent->end = Carbon::parse($missionFolder->mission_date)->addDays($missionFolder->mission_duration);
            $missionEvent->calendar = $missionFolder->mission_status === 'completed' ? 'completed' : 'pending';

            // Update extendedProps
            $extendedProps = $missionEvent->extendedProps ?? [];
            $extendedProps['client'] = $missionEvent->client;
            $extendedProps['city'] = $missionEvent->city;
            $extendedProps['mission_type'] = $missionEvent->mission_type;
            $extendedProps['calendar'] = $missionEvent->calendar;

            $missionEvent->extendedProps = $extendedProps;

            $missionEvent->save();
        }
        if ($missionFolder->mission_type === 'intervention') {
            // Get the corresponding Intervention model and update it
            $intervention = Intervention::where('mission_folder_id', $missionFolder->id)->first();
            if ($intervention) {
                $intervention->intervention_id = $missionFolder->mission_id;
                $intervention->intervention_date = $missionFolder->mission_date;
                $intervention->intervention_duration = $missionFolder->mission_duration;
                $intervention->mission_frequency = $missionFolder->mission_frequency;
                $intervention->intervention_status = $missionFolder->mission_status;
                $intervention->team_leader = $missionFolder->team_leader;
                $intervention->team_driver = $missionFolder->team_driver;
                $intervention->team_members = $missionFolder->team_members;
                $intervention->team_total = $missionFolder->team_total;
                $intervention->vehicle_model = $missionFolder->vehicle_model;
                $intervention->fuel_price_100km = $missionFolder->fuel_price_100km;
                $intervention->target_in_km = $missionFolder->target_in_km;
                $intervention->fuel_transportation = $missionFolder->fuel_transportation;
                $intervention->accommodation_night = $missionFolder->accommodation_night;
                $intervention->accommodation = $missionFolder->accommodation;
                $intervention->meals_cost_member_day = $missionFolder->meals_cost_member_day;
                $intervention->meals_food = $missionFolder->meals_food;
                $intervention->miscellaneous_expenses = $missionFolder->miscellaneous_expenses;
                $intervention->intervention_finance_total = $missionFolder->mission_finance_total;

                // Save the changes to the Intervention model
                $intervention->save();
            }
        }
        if ($missionFolder->mission_type === 'workshop') {
            // Get the corresponding Workshop model and update it
            $workshop = Workshop::where('mission_folder_id', $missionFolder->id)->first();
            if ($workshop) {
                $workshop->workshop_id = $missionFolder->mission_id;
                $workshop->workshop_date = $missionFolder->mission_date;
                $workshop->workshop_duration = $missionFolder->mission_duration;
                $workshop->mission_frequency = $missionFolder->mission_frequency;
                $workshop->workshop_status = $missionFolder->mission_status;
                $workshop->workshop_leader = $missionFolder->team_leader;
                $workshop->team_members = $missionFolder->team_members;
                // Save the changes to the workshop model
                $workshop->save();
            }
        }
    }

    /**
     * Handle the MissionFolder "deleted" event.
     */
    public function deleted(MissionFolder $missionFolder): void
    {
        // Delete associated MissionEvent
        MissionEvent::where('mission_id', $missionFolder->mission_id)->delete();
    }

    /**
     * Handle the MissionFolder "restored" event.
     */
    public function restored(MissionFolder $missionFolder): void
    {
        //
    }

    /**
     * Handle the MissionFolder "force deleted" event.
     */
    public function forceDeleted(MissionFolder $missionFolder): void
    {
        //
    }
}
