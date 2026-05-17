<?php
// app/Helpers/ApiCacheHelper.php
namespace App\Helpers;

use Illuminate\Support\Facades\Cache;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;

class ApiCacheHelper
{
    /**
     * Generate cache key for API endpoints
     */
    public static function key($endpoint, Request $request = null, $userId = null)
    {
        $key = "api_{$endpoint}";
        
        // Add user context if logged in
        if ($userId) {
            $key .= "_user_{$userId}";
        } else {
            $key .= "_guest";
        }
        
        // Add request parameters (except sensitive data)
        if ($request) {
            $params = $request->except(['password', 'token', 'authorization', '_token']);
            
            // Always include branch_id if present (important for your app)
            if ($request->has('branch_id')) {
                $params['branch_id'] = $request->branch_id;
            }
            
            if (!empty($params)) {
                // Sort params for consistent key generation
                ksort($params);
                $key .= '_' . md5(json_encode($params));
            }
        }
        
        return $key;
    }
    
    /**
     * Cache API response with error handling
     */
    public static function remember($endpoint, $ttl, callable $callback, Request $request = null, $userId = null)
    {
        $key = self::key($endpoint, $request, $userId);

        try {
            return Cache::tags([$endpoint])->remember($key, $ttl, $callback);
        } catch (\Exception $e) {
            \Log::error("Cache failed for key {$key}: " . $e->getMessage());
            return $callback();
        }
    }

    public static function clearCache($endpoint)
    {
        try {
            Cache::tags([$endpoint])->flush();
        } catch (\Exception $e) {
            \Log::error("Cache clear failed for {$endpoint}: " . $e->getMessage());
        }
    }
    
    /**
     * Clear cache for specific endpoint
     */
    public static function clear($endpoint, $userId = null, $params = [])
    {
        $pattern = "api_{$endpoint}";
        
        if ($userId) {
            $pattern .= "_user_{$userId}";
        } else {
            $pattern .= "_guest";
        }
        
        // Add params to pattern if provided
        if (!empty($params)) {
            ksort($params);
            $pattern .= '_' . md5(json_encode($params));
        }
        
        self::clearByPattern($pattern . '*');
        
        \Log::info("Cleared cache for pattern: {$pattern}");
    }
    
    /**
     * Clear cache by pattern (for file driver)
     */
    public static function clearByPattern($pattern)
    {
        try {
            // Laravel prefixes keys automatically
            $prefix = config('database.redis.options.prefix') ?? '';

            $fullPattern = $prefix . $pattern;

            $keys = Redis::keys($fullPattern);

            if (!empty($keys)) {
                Redis::del($keys);
            }

            \Log::info('Cleared ' . count($keys) . " redis keys for pattern {$pattern}");

            return count($keys);
        } catch (\Exception $e) {
            \Log::error("Failed to clear redis cache pattern {$pattern}: " . $e->getMessage());
            return 0;
        }
    }
    
    /**
     * Clear all cache for a specific user
     */
    public static function clearUserCache($userId)
    {
        return self::clearByPattern("*_user_{$userId}_*");
    }
    
    /**
     * Clear all cache for a specific branch
     */
    public static function clearBranchCache($branchId)
    {
        // Clear cache for any endpoint with this branch_id
        $endpoints = ['home_items', 'categories', 'category_items', 'deals', 'sliders'];
        $cleared = 0;
        
        foreach ($endpoints as $endpoint) {
            $cleared += self::clearByPattern("api_{$endpoint}*branch_id={$branchId}*");
            $cleared += self::clearByPattern("api_{$endpoint}*branch_id%3D{$branchId}*");
        }
        
        return $cleared;
    }
    
    /**
     * Get cache statistics
     */
    public static function stats()
    {
        try {
            $info = Redis::info();

            return [
                'used_memory' => $info['used_memory_human'] ?? null,
                'total_keys' => Redis::dbsize(),
                'driver' => 'redis',
            ];
        } catch (\Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }

}