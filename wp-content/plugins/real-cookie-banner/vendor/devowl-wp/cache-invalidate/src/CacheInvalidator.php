<?php

namespace DevOwl\RealCookieBanner\Vendor\DevOwl\CacheInvalidate;

use DevOwl\RealCookieBanner\Vendor\DevOwl\CacheInvalidate\caches\AssetCleanupCacheImpl;
use DevOwl\RealCookieBanner\Vendor\DevOwl\CacheInvalidate\caches\AutoptimizeCacheImpl;
use DevOwl\RealCookieBanner\Vendor\DevOwl\CacheInvalidate\caches\BorlabsCacheImpl;
use DevOwl\RealCookieBanner\Vendor\DevOwl\CacheInvalidate\caches\BreezeImpl;
use DevOwl\RealCookieBanner\Vendor\DevOwl\CacheInvalidate\caches\CacheEnablerImpl;
use DevOwl\RealCookieBanner\Vendor\DevOwl\CacheInvalidate\caches\CometCacheImpl;
use DevOwl\RealCookieBanner\Vendor\DevOwl\CacheInvalidate\caches\HummingbirdImpl;
use DevOwl\RealCookieBanner\Vendor\DevOwl\CacheInvalidate\caches\LiteSpeedCacheImpl;
use DevOwl\RealCookieBanner\Vendor\DevOwl\CacheInvalidate\caches\MergeMinifyRefreshImpl;
use DevOwl\RealCookieBanner\Vendor\DevOwl\CacheInvalidate\caches\NginxHelperImpl;
use DevOwl\RealCookieBanner\Vendor\DevOwl\CacheInvalidate\caches\NitroPackImpl;
use DevOwl\RealCookieBanner\Vendor\DevOwl\CacheInvalidate\caches\SGOptimizeImpl;
use DevOwl\RealCookieBanner\Vendor\DevOwl\CacheInvalidate\caches\W3TotalCacheImpl;
use DevOwl\RealCookieBanner\Vendor\DevOwl\CacheInvalidate\caches\WpFastestCacheImpl;
use DevOwl\RealCookieBanner\Vendor\DevOwl\CacheInvalidate\caches\WpOptimizeImpl;
use DevOwl\RealCookieBanner\Vendor\DevOwl\CacheInvalidate\caches\WpRocketImpl;
use DevOwl\RealCookieBanner\Vendor\DevOwl\CacheInvalidate\caches\WpSuperCacheImpl;
use DevOwl\RealCookieBanner\Vendor\DevOwl\CacheInvalidate\caches\SwiftPerformanceCacheImpl;
use DevOwl\RealCookieBanner\Vendor\DevOwl\CacheInvalidate\caches\ThemifyImpl;
use DevOwl\RealCookieBanner\Vendor\DevOwl\CacheInvalidate\caches\CloudflareImpl;
use DevOwl\RealCookieBanner\Vendor\DevOwl\CacheInvalidate\caches\IonosPerformanceCacheImpl;
use DevOwl\RealCookieBanner\Vendor\DevOwl\CacheInvalidate\caches\OneComImpl;
use DevOwl\RealCookieBanner\Vendor\DevOwl\CacheInvalidate\caches\RaidboxesImpl;
use DevOwl\RealCookieBanner\Vendor\DevOwl\CacheInvalidate\caches\BunnyCDNCacheImpl;
use DevOwl\RealCookieBanner\Vendor\DevOwl\CacheInvalidate\caches\PerfmattersCacheImpl;
use DevOwl\RealCookieBanner\Vendor\DevOwl\CacheInvalidate\caches\PoweredCacheImpl;
use Exception;
/**
 * Use this class to detect used caching plugins / mechanism and trigger
 * an invalidate.
 */
class CacheInvalidator
{
    const CACHE_IMPLEMENTATIONS = [AutoptimizeCacheImpl::IDENTIFIER => AutoptimizeCacheImpl::class, WpSuperCacheImpl::IDENTIFIER => WpSuperCacheImpl::class, WpRocketImpl::IDENTIFIER => WpRocketImpl::class, W3TotalCacheImpl::IDENTIFIER => W3TotalCacheImpl::class, WpFastestCacheImpl::IDENTIFIER => WpFastestCacheImpl::class, LiteSpeedCacheImpl::IDENTIFIER => LiteSpeedCacheImpl::class, BreezeImpl::IDENTIFIER => BreezeImpl::class, WpOptimizeImpl::IDENTIFIER => WpOptimizeImpl::class, SGOptimizeImpl::IDENTIFIER => SGOptimizeImpl::class, HummingbirdImpl::IDENTIFIER => HummingbirdImpl::class, CacheEnablerImpl::IDENTIFIER => CacheEnablerImpl::class, NginxHelperImpl::IDENTIFIER => NginxHelperImpl::class, CometCacheImpl::IDENTIFIER => CometCacheImpl::class, BorlabsCacheImpl::IDENTIFIER => BorlabsCacheImpl::class, SwiftPerformanceCacheImpl::IDENTIFIER => SwiftPerformanceCacheImpl::class, MergeMinifyRefreshImpl::IDENTIFIER => MergeMinifyRefreshImpl::class, ThemifyImpl::IDENTIFIER => ThemifyImpl::class, NitroPackImpl::IDENTIFIER => NitroPackImpl::class, CloudflareImpl::IDENTIFIER => CloudflareImpl::class, OneComImpl::IDENTIFIER => OneComImpl::class, RaidboxesImpl::IDENTIFIER => RaidboxesImpl::class, IonosPerformanceCacheImpl::IDENTIFIER => IonosPerformanceCacheImpl::class, BunnyCDNCacheImpl::IDENTIFIER => BunnyCDNCacheImpl::class, AssetCleanupCacheImpl::IDENTIFIER => AssetCleanupCacheImpl::class, PoweredCacheImpl::IDENTIFIER => PoweredCacheImpl::class, PerfmattersCacheImpl::IDENTIFIER => PerfmattersCacheImpl::class];
    /**
     * Singleton instance.
     *
     * @var CacheInvalidator
     */
    private static $me = null;
    /**
     * C'tor.
     *
     * @codeCoverageIgnore
     */
    private function __construct()
    {
        // Silence is golden.
    }
    /**
     * Get implementations as instances.
     *
     * @codeCoverageIgnore
     */
    public function getImplementations()
    {
        $result = [];
        foreach (self::CACHE_IMPLEMENTATIONS as $id => $clazz) {
            $result[$id] = new $clazz();
        }
        return $result;
    }
    /**
     * Get all available caches.
     *
     * @return AbstractCache[]
     */
    public function getCaches()
    {
        $result = [];
        foreach ($this->getImplementations() as $id => $instance) {
            if ($instance->isActive()) {
                $result[$id] = $instance;
            }
        }
        return $result;
    }
    /**
     * Get all available caches with label.
     *
     * @return string[]
     */
    public function getLabels()
    {
        $result = [];
        foreach ($this->getCaches() as $key => $instance) {
            $result[$key] = $instance->label();
        }
        return $result;
    }
    /**
     * See `AbstractCache#excludeHtmlAttribute()`.
     *
     * @return string
     */
    public function getExcludeHtmlAttributesString()
    {
        $result = [];
        foreach ($this->getCaches() as $instance) {
            $result[] = $instance->excludeHtmlAttribute();
        }
        return \join(' ', $result);
    }
    /**
     * Invalidate all available caches.
     *
     * @param boolean $objectCache
     */
    public function invalidate($objectCache = \false)
    {
        $result = [];
        if ($objectCache) {
            $result['wp_cache_flush'] = \wp_cache_flush();
        }
        foreach ($this->getCaches() as $cache => $value) {
            try {
                $result[$cache] = $value->invalidate();
            } catch (Exception $e) {
                $result[$cache] = \false;
            }
        }
        return $result;
    }
    /**
     * Get singleton instance.
     *
     * @codeCoverageIgnore
     */
    public static function getInstance()
    {
        return self::$me === null ? self::$me = new CacheInvalidator() : self::$me;
    }
}
