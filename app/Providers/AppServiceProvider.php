<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Observers\MissionFolderObserver;
use App\Models\MissionFolder;
use App\Observers\InterventionObserver;
use App\Models\Intervention;
use App\Observers\WorkshopObserver;
use App\Models\Workshop;
use App\Observers\MissionEventObserver;
use App\Models\MissionEvent;
use App\Observers\EquipmentObserver;
use App\Models\Equipment;
use App\Observers\EqAccessoryObserver;
use App\Models\EqAccessory;


class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        MissionFolder::observe(MissionFolderObserver::class);
        Intervention::observe(InterventionObserver::class);
        Workshop::observe(WorkshopObserver::class);
        MissionEvent::observe(MissionEventObserver::class);
        EqAccessory::observe(EqAccessoryObserver::class);
    }
}
