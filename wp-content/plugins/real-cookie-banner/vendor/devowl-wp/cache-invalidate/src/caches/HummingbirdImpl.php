<?php

namespace DevOwl\RealCookieBanner\Vendor\DevOwl\CacheInvalidate\caches;

use DevOwl\RealCookieBanner\Vendor\DevOwl\CacheInvalidate\AbstractCache;
use Hummingbird\WP_Hummingbird;
/**
 * Hummingbird.
 *
 * @see https://wordpress.org/plugins/hummingbird-performance/
 * @see https://premium.wpmudev.org/docs/api-plugin-development/hummingbird-api-docs/#action-wphb_clear_page_cache
 * @codeCoverageIgnore
 */
class HummingbirdImpl extends AbstractCache
{
    const IDENTIFIER = 'hummingbird-performance';
    // Documented in AbstractCache
    public function isActive()
    {
        return \class_exists(WP_Hummingbird::class);
    }
    // Documented in AbstractCache
    public function invalidate()
    {
        \do_action('wphb_clear_page_cache');
    }
    // Documented in AbstractCache
    public function label()
    {
        return 'Hummingbird';
    }
}
