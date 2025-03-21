<?php

namespace DevOwl\RealCookieBanner\view;

use DevOwl\RealCookieBanner\Vendor\DevOwl\FastHtmlTag\Utils as FastHtmlTagUtils;
use DevOwl\RealCookieBanner\Vendor\DevOwl\Multilingual\Iso3166OneAlpha2;
use DevOwl\RealCookieBanner\base\UtilsProvider;
use DevOwl\RealCookieBanner\Core;
use DevOwl\RealCookieBanner\lite\settings\TcfVendorConfiguration;
use DevOwl\RealCookieBanner\settings\Consent;
use DevOwl\RealCookieBanner\settings\Cookie;
use DevOwl\RealCookieBanner\settings\CookieGroup;
use DevOwl\RealCookieBanner\settings\TCF;
use DevOwl\RealCookieBanner\Utils;
use DevOwl\RealCookieBanner\view\checklist\Scanner;
use DevOwl\RealCookieBanner\Vendor\MatthiasWeb\Utils\KeyValueMapOption;
use DevOwl\RealCookieBanner\Vendor\MatthiasWeb\Utils\Utils as UtilsUtils;
// @codeCoverageIgnoreStart
\defined('ABSPATH') or die('No script kiddies please!');
// Avoid direct file request
// @codeCoverageIgnoreEnd
/**
 * Notices management.
 */
class Notices
{
    use UtilsProvider;
    const OPTION_NAME = RCB_OPT_PREFIX . '-notice-states';
    const NOTICE_SCANNER_RERUN_AFTER_PLUGIN_TOGGLE = 'scanner-rerun-after-plugin-toggle';
    const NOTICE_GET_PRO_MAIN_BUTTON = 'get-pro-main-button';
    const NOTICE_GET_PRO_MAIN_BUTTON_NEXT = 60 * 60 * 24 * 30;
    // 30 days
    const NOTICE_REVISON_REQUEST_NEW_CONSENT_PREFIX = 'revision-request-new-consent-';
    const NOTICE_SERVICE_DATA_PROCESSING_IN_UNSAFE_COUNTRIES = 'service-data-processing-in-unsafe-countries';
    const CHECKLIST_PREFIX = 'checklist-';
    const MODAL_HINT_PREFIX = 'modal-hint-';
    const SCANNER_IGNORE_ADMIN_BAR_PREFIX = 'scanner-ignore-admin-bar-';
    private $states;
    /**
     * C'tor.
     *
     * @param Core $core
     */
    public function __construct($core)
    {
        $this->states = new KeyValueMapOption(self::OPTION_NAME, $core);
        $this->createStates();
    }
    /**
     * Create the notice states key-value option with migrations from older Real Cookie Banner versions.
     */
    protected function createStates()
    {
        $this->states->registerModifier(function ($key, $value) {
            return $key === self::NOTICE_GET_PRO_MAIN_BUTTON && $value === \true ? \time() + self::NOTICE_GET_PRO_MAIN_BUTTON_NEXT : $value;
        })->registerMigrationForKey(self::NOTICE_SCANNER_RERUN_AFTER_PLUGIN_TOGGLE, function () {
            $optionName = RCB_OPT_PREFIX . '-any-plugin-toggle-state';
            $result = \boolval(\get_option($optionName));
            \delete_option($optionName);
            return $result;
        })->registerMigrationForKey(self::NOTICE_GET_PRO_MAIN_BUTTON, function () {
            $optionName = RCB_OPT_PREFIX . '-config-next-pro-notice';
            $result = \get_option($optionName, \false);
            if ($result !== \false) {
                $result = \intval($result);
            }
            \delete_option($optionName);
            return $result;
        })->registerMigration(function ($result) {
            global $wpdb;
            $table_name = $wpdb->options;
            // phpcs:disable WordPress.DB.PreparedSQL
            $checklistItems = $wpdb->get_col($wpdb->prepare("SELECT option_name FROM {$table_name} WHERE option_value = '1' AND option_name LIKE %s", RCB_OPT_PREFIX . '-checklist-%'));
            // phpcs:enable WordPress.DB.PreparedSQL
            foreach ($checklistItems as $checklistItem) {
                $name = \substr($checklistItem, \strlen(RCB_OPT_PREFIX . '-checklist-'));
                $result[self::CHECKLIST_PREFIX . $name] = \true;
            }
            // phpcs:disable WordPress.DB.PreparedSQL
            $checklistItems = $wpdb->query($wpdb->prepare("DELETE FROM {$table_name} WHERE option_name LIKE %s OR option_name LIKE %s", RCB_OPT_PREFIX . '-checklist-%', RCB_OPT_PREFIX . '-revision-dismissed-hash-%'));
            // phpcs:enable WordPress.DB.PreparedSQL
            return $result;
        })->registerMigration(function ($result) {
            $optionName = RCB_OPT_PREFIX . '-modal-hints';
            $modalHints = \json_decode(\get_option($optionName, '[]'), ARRAY_A);
            foreach ($modalHints as $modalHint) {
                $result[self::MODAL_HINT_PREFIX . $modalHint] = \true;
            }
            \delete_option($optionName);
            return $result;
        })->registerMigration(function ($result) {
            $optionName = RCB_OPT_PREFIX . '-scanner-notice-dismissed';
            $scannerIgnoreAdminBar = \get_option($optionName, []);
            foreach ($scannerIgnoreAdminBar as $service) {
                $result[self::SCANNER_IGNORE_ADMIN_BAR_PREFIX . $service] = \true;
            }
            \delete_option($optionName);
            return $result;
        })->registerRestForKey(Core::MANAGE_MIN_CAPABILITY, \sprintf('/%s[a-z_-]+/', self::MODAL_HINT_PREFIX), ['type' => 'boolean'])->registerRestForKey(Core::MANAGE_MIN_CAPABILITY, self::NOTICE_SCANNER_RERUN_AFTER_PLUGIN_TOGGLE, ['type' => 'boolean'])->registerRestForKey(Core::MANAGE_MIN_CAPABILITY, self::NOTICE_GET_PRO_MAIN_BUTTON, ['type' => 'boolean'])->registerRestForKey(Core::MANAGE_MIN_CAPABILITY, self::NOTICE_SERVICE_DATA_PROCESSING_IN_UNSAFE_COUNTRIES, ['type' => 'boolean']);
    }
    /**
     * When a plugin got toggled show scanner notice.
     *
     * @param string $plugin Plugin slug
     * @param bool $network_wide Is it activated network wide
     */
    public function anyPluginToggledState($plugin, $network_wide)
    {
        $isScannerChecked = \DevOwl\RealCookieBanner\view\Checklist::getInstance()->isChecked(Scanner::IDENTIFIER);
        if (!Utils::startsWith($plugin, RCB_SLUG) && $isScannerChecked) {
            if ($network_wide) {
                $network_blogs = \get_sites(['number' => 0, 'fields' => 'ids']);
                foreach ($network_blogs as $blog) {
                    $blogId = \intval($blog);
                    \switch_to_blog($blogId);
                    $this->getStates()->set(self::NOTICE_SCANNER_RERUN_AFTER_PLUGIN_TOGGLE, \true);
                    \restore_current_blog();
                }
            } else {
                $this->getStates()->set(self::NOTICE_SCANNER_RERUN_AFTER_PLUGIN_TOGGLE, \true);
            }
        }
    }
    /**
     * When a service / TCF vendor got updated check if the service is now processing data in unsafe countries.
     *
     * @param null|boolean $check
     * @param int $object_id
     * @param string $meta_key
     * @param mixed $meta_value
     */
    public function update_post_meta_data_processing_in_unsafe_countries($check, $object_id, $meta_key, $meta_value)
    {
        $postType = \get_post_type($object_id);
        if (\in_array($meta_key, [Cookie::META_NAME_DATA_PROCESSING_IN_COUNTRIES, Cookie::META_NAME_DATA_PROCESSING_IN_COUNTRIES_SPECIAL_TREATMENTS], \true) && ($postType === Cookie::CPT_NAME || $this->isPro() && $postType === TcfVendorConfiguration::CPT_NAME)) {
            $prev_value = \get_post_meta($object_id, Cookie::META_NAME_DATA_PROCESSING_IN_COUNTRIES, \true);
            if (empty($prev_value)) {
                return $check;
            }
            // Reset the notice at the end of the request, as we need to get special treatments meta, too
            \add_action('shutdown', function () use($meta_value, $prev_value, $object_id) {
                $currentCountries = UtilsUtils::isJson($meta_value, []);
                $oldCountries = UtilsUtils::isJson($prev_value, []);
                $specialTreatments = UtilsUtils::isJson(\get_post_meta($object_id, Cookie::META_NAME_DATA_PROCESSING_IN_COUNTRIES_SPECIAL_TREATMENTS, \true));
                $addedCountries = \array_values(\array_diff($currentCountries, $oldCountries));
                $addedUnsafeCountries = $this->calculateUnsafeCountries($addedCountries, $specialTreatments === \false ? [] : $specialTreatments);
                if (\count($addedUnsafeCountries) > 0) {
                    $this->getStates()->set(self::NOTICE_SERVICE_DATA_PROCESSING_IN_UNSAFE_COUNTRIES, \true);
                }
            });
        }
        return $check;
    }
    /**
     * When a service / TCF vendor got created check if the services does processing data in unsafe countries.
     *
     * @param int $meta_id
     * @param int $object_id
     * @param string $meta_key
     * @param mixed $meta_value
     */
    public function added_post_meta_data_processing_in_unsafe_countries($meta_id, $object_id, $meta_key, $meta_value)
    {
        $postType = \get_post_type($object_id);
        if (\in_array($meta_key, [Cookie::META_NAME_DATA_PROCESSING_IN_COUNTRIES, Cookie::META_NAME_DATA_PROCESSING_IN_COUNTRIES_SPECIAL_TREATMENTS], \true) && ($postType === Cookie::CPT_NAME || $this->isPro() && $postType === TcfVendorConfiguration::CPT_NAME)) {
            // Reset the notice at the end of the request, as we need to get special treatments meta, too
            \add_action('shutdown', function () use($meta_value, $object_id) {
                $currentCountries = UtilsUtils::isJson($meta_value, []);
                $specialTreatments = UtilsUtils::isJson(\get_post_meta($object_id, Cookie::META_NAME_DATA_PROCESSING_IN_COUNTRIES_SPECIAL_TREATMENTS, \true));
                $unsafeCountries = $this->calculateUnsafeCountries($currentCountries, $specialTreatments === \false ? [] : $specialTreatments);
                if (\count($unsafeCountries)) {
                    $this->getStates()->set(self::NOTICE_SERVICE_DATA_PROCESSING_IN_UNSAFE_COUNTRIES, \true);
                }
            });
        }
    }
    /**
     * Calculate unsafe countries from a given array of countries.
     *
     * See also `frontend-packages/react-cookie-banner/src/components/common/groups/cookiePropertyList.tsx` method
     * `calculateUnsafeCountries` method.
     *
     * @param string[] $countries
     * @param string[] $specialTreatments See `api-packages/api-real-cookie-banner/src/entity/template/service/service.ts` the enum `EServiceTemplateDataProcessingInCountriesSpecialTreatment`
     * @return string[]
     */
    protected function calculateUnsafeCountries($countries, $specialTreatments = [])
    {
        if (\in_array('standard-contractual-clauses', $specialTreatments, \true)) {
            return [];
        }
        $safeCountries = [];
        foreach (Consent::PREDEFINED_DATA_PROCESSING_IN_SAFE_COUNTRIES_LISTS as $listCountries) {
            $safeCountries = \array_merge($safeCountries, $listCountries);
        }
        $unsafeCountries = [];
        // Check if one service country is not safe
        foreach ($countries as $country) {
            if (!\in_array($country, $safeCountries, \true) || $country === 'US' && !\in_array('provider-is-self-certified-trans-atlantic-data-privacy-framework', $specialTreatments, \true)) {
                $unsafeCountries[] = $country;
            }
        }
        return $unsafeCountries;
    }
    /**
     * Checks if the notice about services which are processing data in unsafe countries should be shown,
     * and returns the titles of the services which process data in unsafe countries
     */
    public function servicesDataProcessingInUnsafeCountriesNoticeHtml()
    {
        $noticeState = $this->getStates()->get(self::NOTICE_SERVICE_DATA_PROCESSING_IN_UNSAFE_COUNTRIES, null);
        // Should it be recalculated by metadata change or should it be initially checked?
        if (($noticeState === \true || $noticeState === null) && !Consent::getInstance()->isDataProcessingInUnsafeCountries()) {
            $safeCountries = [];
            foreach (Consent::PREDEFINED_DATA_PROCESSING_IN_SAFE_COUNTRIES_LISTS as $listCountries) {
                $safeCountries = \array_merge($safeCountries, $listCountries);
            }
            $servicesHtml = [];
            $iso3166OneAlpha2 = Iso3166OneAlpha2::getSortedCodes();
            $candidates = [];
            foreach (CookieGroup::getInstance()->getOrdered() as $group) {
                foreach (Cookie::getInstance()->getOrdered($group->term_id) as $cookie) {
                    $candidates[] = ['dataProcessingInCountries' => $cookie->metas[Cookie::META_NAME_DATA_PROCESSING_IN_COUNTRIES], 'dataProcessingInCountriesSpecialTreatments' => $cookie->metas[Cookie::META_NAME_DATA_PROCESSING_IN_COUNTRIES_SPECIAL_TREATMENTS], 'name' => $cookie->post_title];
                }
            }
            // List also TCF vendors
            if (TCF::getInstance()->isActive()) {
                $tcfQuery = Core::getInstance()->getTcfVendorListNormalizer()->getQuery();
                $vendorIds = [];
                foreach (TcfVendorConfiguration::getInstance()->getOrdered() as $vendor) {
                    $vendorId = $vendor->metas[TcfVendorConfiguration::META_NAME_VENDOR_ID];
                    $candidates[] = ['dataProcessingInCountries' => $vendor->metas[TcfVendorConfiguration::META_NAME_DATA_PROCESSING_IN_COUNTRIES], 'dataProcessingInCountriesSpecialTreatments' => $vendor->metas[TcfVendorConfiguration::META_NAME_DATA_PROCESSING_IN_COUNTRIES_SPECIAL_TREATMENTS], 'name' => $vendorId, 'tcf' => \true];
                    $vendorIds[] = $vendorId;
                }
                // Read TCF vendor names
                if (\count($vendorIds) > 0) {
                    $vendors = $tcfQuery->vendors(['in' => $vendorIds])['vendors'];
                    foreach ($candidates as $key => $candidate) {
                        if (isset($candidate['tcf'])) {
                            $candidates[$key]['name'] = $vendors[$candidate['name']]['name'];
                        }
                    }
                }
            }
            foreach ($candidates as $candidate) {
                $unsafeCountries = $this->calculateUnsafeCountries($candidate['dataProcessingInCountries'], $candidate['dataProcessingInCountriesSpecialTreatments']);
                if (\count($unsafeCountries) > 0) {
                    $servicesHtml[] = \sprintf(
                        // translators:s
                        \__('<strong>%1$s</strong> is processing data to %2$s', RCB_TD),
                        \esc_html($candidate['name']),
                        \join(', ', \array_map(function ($country) use($iso3166OneAlpha2) {
                            return $iso3166OneAlpha2[$country] ?? $country;
                        }, $unsafeCountries))
                    );
                }
            }
            if (\count($servicesHtml) > 0) {
                return \sprintf('<p>%s</p><ul><li>%s</li></ul>', \__('Some services carries out data processing in insecure third countries as defined by data protection regulations. You should obtain specific consent for this or only use services with data processing in secure countries as defined by the European Commission.', RCB_TD), \join('</li><li>', $servicesHtml));
            }
        }
        return null;
    }
    /**
     * Check if the Pro notice should be shown in config page. See `proHeadlineButton.tsx`.
     */
    public function isConfigProNoticeVisible()
    {
        $next = $this->getStates()->get(self::NOTICE_GET_PRO_MAIN_BUTTON, 0);
        if ($next === 0) {
            $this->getStates()->set(self::NOTICE_GET_PRO_MAIN_BUTTON, \true);
            return \false;
        }
        return \time() > $next;
    }
    /**
     * Create an notice that the scanner should be rerun after any plugin got toggled.
     */
    public function admin_notice_scanner_rerun_after_plugin_toggle()
    {
        if ($this->getStates()->get(self::NOTICE_SCANNER_RERUN_AFTER_PLUGIN_TOGGLE, \false)) {
            echo \sprintf('<div class="notice notice-warning" style="position:relative"><p>%s &bull; <a onClick="%s" href="#">%s</a></p>%s</div>', \__('You have enabled or disabled plugins on your website, which may require your cookie banner to be adjusted. Please scan your website again as soon as you have finished the changes!', RCB_TD), \esc_js($this->getStates()->noticeDismissOnClickHandler(self::NOTICE_SCANNER_RERUN_AFTER_PLUGIN_TOGGLE, 'false', Core::getInstance()->getConfigPage()->getUrl() . '#/scanner?start=1')), \__('Scan website again', RCB_TD), \sprintf('<button type="button" class="notice-dismiss" onClick="%s"></button>', \esc_js($this->getStates()->noticeDismissOnClickHandler(self::NOTICE_SCANNER_RERUN_AFTER_PLUGIN_TOGGLE, 'false'))));
        }
    }
    /**
     * Set checklist item as open/closed.
     *
     * @param string $id
     * @param boolean $state
     */
    public function setChecklistItem($id, $state)
    {
        return $this->getStates()->set(\DevOwl\RealCookieBanner\view\Notices::CHECKLIST_PREFIX . $id, $state);
    }
    /**
     * Get checklist item state.
     *
     * @param string $id
     * @param boolean $state
     */
    public function isChecklistItem($id)
    {
        return $this->getStates()->get(\DevOwl\RealCookieBanner\view\Notices::CHECKLIST_PREFIX . $id);
    }
    /**
     * Get list of clicked modal hints.
     *
     * @return string[]
     */
    public function getClickedModalHints()
    {
        return \array_keys($this->getStates()->getKeysStartingWith(self::MODAL_HINT_PREFIX));
    }
    /**
     * Getter.
     *
     * @codeCoverageIgnore
     */
    public function getStates()
    {
        return $this->states;
    }
}
