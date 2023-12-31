<?php

namespace App\Base\Providers;

use Laravel\Passport\Passport;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        \App\Project\Models\Project::class       => \App\Project\Policies\ProjectPolicy::class,
        \App\Project\Models\Asset::class       => \App\Project\Policies\AssetPolicy::class,
        \App\Team\Models\Team::class             => \App\Team\Policies\TeamPolicy::class,
        \App\Office\Models\Office::class         => \App\Office\Policies\OfficePolicy::class,
        \App\TaskManager\Models\Task::class      => \App\TaskManager\Policies\TaskPolicy::class,
        \App\Base\Models\Tag::class              => \App\Base\Policies\TagPolicy::class,
        \App\Discussion\Models\Discussion::class => \App\Discussion\Policies\DiscussionPolicy::class,
        \App\Base\Models\Comment::class          => \App\Base\Policies\CommentPolicy::class,
        \App\Chat\Models\Message::class          => \App\Chat\Policies\MessagePolicy::class,
        \App\Chat\Models\DirectMessage::class    => \App\Chat\Policies\DirectMessagePolicy::class,
        \App\Base\Models\Permission::class       => \App\Base\Policies\PermissionPolicy::class,
        \App\Base\Models\User::class             => \App\Base\Policies\UserPolicy::class,
        \App\Base\Models\Cycle::class            => \App\Base\Policies\CyclePolicy::class,
        \App\Base\Models\File::class             => \App\Base\Policies\FilePolicy::class,
        \App\Base\Models\UserRequest::class      => \App\Base\Policies\UserRequestPolicy::class,
        \App\Base\Models\AppSetting::class       => \App\Base\Policies\AppSettingPolicy::class,
        \App\SalesPipeline\Models\Deals::class   => \App\SalesPipeline\Policies\DealsPolicy::class,
        \App\Base\Models\Notification::class       => \App\Base\Policies\NotificationPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Passport::routes();
    }
}
