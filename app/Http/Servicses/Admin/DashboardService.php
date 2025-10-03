<?php

namespace App\Http\Servicses\Admin;

use App\Enums\RoleUserEnum;
use App\Models\User;
use App\Models\Category;

class DashboardService
{
    /**
     * Get dashboard statistics
     *
     * @return array
     */
    public function getDashboardStats(): array
    {
        // Get user statistics
        $totalUsers = $this->getTotalUsers();
        $adminUsers = $this->getAdminUsersCount();
        $clientUsers = $this->getClientUsersCount();
        $providerUsers = $this->getProviderUsersCount();

        // Get recent users
        $recentUsers = $this->getRecentUsers();

        // Get category statistics
        $totalCategories = $this->getTotalCategories();

        // Get system stats (you can add more as needed)
        return [
            'total_users' => $totalUsers,
            'admin_users' => $adminUsers,
            'client_users' => $clientUsers,
            'provider_users' => $providerUsers,
            'total_categories' => $totalCategories,
            'recent_users' => $recentUsers,
        ];
    }

    /**
     * Get total users count
     *
     * @return int
     */
    public function getTotalUsers(): int
    {
        return User::count();
    }

    /**
     * Get admin users count
     *
     * @return int
     */
    public function getAdminUsersCount(): int
    {
        return User::where('role', RoleUserEnum::Admin)->count();
    }

    /**
     * Get client users count
     *
     * @return int
     */
    public function getClientUsersCount(): int
    {
        return User::where('role', RoleUserEnum::Client)->count();
    }

    /**
     * Get provider users count
     *
     * @return int
     */
    public function getProviderUsersCount(): int
    {
        return User::where('role', RoleUserEnum::Provider)->count();
    }

    /**
     * Get recent users (latest 5)
     *
     * @param int $limit
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getRecentUsers(int $limit = 5)
    {
        return User::latest()->take($limit)->get();
    }

    /**
     * Get total categories count
     *
     * @return int
     */
    public function getTotalCategories(): int
    {
        return Category::count();
    }

    /**
     * Get user role distribution
     *
     * @return array
     */
    public function getUserRoleDistribution(): array
    {
        return [
            'admin' => $this->getAdminUsersCount(),
            'client' => $this->getClientUsersCount(),
            'provider' => $this->getProviderUsersCount(),
        ];
    }
}
