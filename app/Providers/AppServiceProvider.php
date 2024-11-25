<?php

namespace App\Providers;

use App\Enum\MyNetworkID;
use App\Models\User;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\AliasLoader;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // Get the AliasLoader instance
        $loader = AliasLoader::getInstance();

        $loader->alias('LaravelPwa', \Ladumor\LaravelPwa\LaravelPwa::class,);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(Request $request): void
    {
        // $scheme = $request->getScheme();
        // $host = $request->getHost();
        // $hostname = explode('.', $host);
        // $id_network = Network::where('slug', $hostname)->first();

        Gate::define('owner', function (User $user) {
            return $user->level === 'owner';
        });

        Gate::define('admin', function (User $user) {
            return $user->level === 'admin';
        });

        // GLOBAL SETTING
        view()->share('setting', Setting::where('id_network', MyNetworkID::ID->value)->first());
    }
}
