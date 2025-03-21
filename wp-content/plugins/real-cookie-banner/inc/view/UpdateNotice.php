<?php

namespace DevOwl\RealCookieBanner\view;

use DevOwl\RealCookieBanner\base\UtilsProvider;
use DevOwl\RealCookieBanner\Core;
use DevOwl\RealCookieBanner\settings\Blocker;
use DevOwl\RealCookieBanner\settings\Cookie;
use DevOwl\RealCookieBanner\settings\CookieGroup;
use DevOwl\RealCookieBanner\templates\StorageHelper;
use DevOwl\RealCookieBanner\templates\TemplateConsumers;
// @codeCoverageIgnoreStart
\defined('ABSPATH') or die('No script kiddies please!');
// Avoid direct file request
// @codeCoverageIgnoreEnd
/**
 * Let the user know when a template got updated through a plugin update. This is not part of `Notices`
 * as the visibility of the notice is calculated of each posts' `presetId` meta key.
 */
class UpdateNotice
{
    use UtilsProvider;
    const DISMISS_PARAM = 'rcb-dismiss-upgrade-notice';
    /**
     * Creates an admin notice when there is an update for template'able entry.
     */
    public function admin_notices()
    {
        $needsUpdate = $this->needsUpdate();
        if (isset($_GET[self::DISMISS_PARAM])) {
            $this->dismiss($needsUpdate);
            return;
        }
        if (\current_user_can(Core::MANAGE_MIN_CAPABILITY) && \count($needsUpdate) > 0 && !Core::getInstance()->getConfigPage()->isVisible()) {
            echo $this->getNotice($needsUpdate);
        }
    }
    /**
     * Dismiss the notice by updating the template version in database.
     *
     * @param array $needsUpdate
     */
    protected function dismiss($needsUpdate)
    {
        foreach ($needsUpdate as $update) {
            \update_post_meta($update->post_id, Blocker::META_NAME_PRESET_VERSION, $update->should);
        }
    }
    /**
     * Get the notice HTML.
     *
     * @param boolean $reviewInNewWindow
     * @param array $needsUpdate
     * @param string $context Can be `notice` or `tile-migration`
     */
    public function getNotice($needsUpdate, $reviewInNewWindow = \true, $context = 'notice')
    {
        $configPage = Core::getInstance()->getConfigPage();
        $output = $context === 'notice' ? '<div class="notice notice-warning"><p>' . \__('Changes have been made to the templates you use in Real Cookie Banner. You should review the proposed changes and adjust your services if necessary to be able to remain legally compliant. The following services are affected:', RCB_TD) . '</p><ul>' : '<ul>';
        foreach ($needsUpdate as $update) {
            $configPageUrl = $configPage->getUrl();
            switch ($update->post_type) {
                case Blocker::CPT_NAME:
                    $typeLabel = \__('Content Blocker', RCB_TD);
                    $editLink = $configPageUrl . '#/blocker/edit/' . $update->post_id;
                    break;
                case Cookie::CPT_NAME:
                    $groupIds = \wp_get_post_terms($update->post_id, CookieGroup::TAXONOMY_NAME, ['fields' => 'ids']);
                    $typeLabel = \__('Service (Cookie)', RCB_TD);
                    $editLink = $configPageUrl . '#/cookies/' . $groupIds[0] . '/edit/' . $update->post_id;
                    break;
                default:
                    break;
            }
            $output .= \sprintf('<li><strong>%s</strong> (%s) - <a target="%s" href="%s">%s</a></li>', \esc_html($update->post_title), $typeLabel, $reviewInNewWindow ? '_blank' : '_self', $editLink, \__('Review changes', RCB_TD));
        }
        $dismissLink = \add_query_arg(self::DISMISS_PARAM, '1', $configPage->getUrl());
        $output .= $context === 'notice' ? '</ul><p><a href="' . \esc_url($dismissLink) . '">' . \__('Dismiss this notice', RCB_TD) . '</a></p></div>' : '</ul>';
        return $output;
    }
    /**
     * Read all updates from database.
     * It uses a very cheap SQL on each page request.
     */
    public function needsUpdate()
    {
        global $wpdb;
        $table_name = $this->getTableName(StorageHelper::TABLE_NAME);
        // Probably refresh template cache
        $serviceConsumer = TemplateConsumers::getCurrentServiceConsumer();
        if ($serviceConsumer->getStorage()->shouldInvalidate()) {
            $serviceConsumer->retrieve();
        }
        $needsUpdate = $wpdb->get_results(
            // phpcs:disable WordPress.DB.PreparedSQL
            $wpdb->prepare("SELECT\n                    pm.meta_id AS post_version_meta_id,\n                    pm.post_id,\n                    pm.meta_value AS post_template_version,\n                    prid.meta_value AS post_template_identifier,\n                    p.post_title, p.post_type,\n                    templates.version as should\n                FROM {$wpdb->postmeta} pm\n                INNER JOIN {$wpdb->postmeta} prid\n                    ON prid.post_id = pm.post_id\n                INNER JOIN {$wpdb->posts} p\n                    ON p.ID = pm.post_id\n                INNER JOIN {$table_name} templates\n                    ON BINARY templates.identifier = BINARY prid.meta_value\n                    AND templates.context = %s\n                    AND templates.is_outdated = 0\n                    AND templates.type = (\n                        CASE\n                            WHEN p.post_type = %s THEN %s\n                            ELSE %s\n                        END\n                    )\n                WHERE pm.meta_key = %s\n                    AND pm.meta_value > 0\n                    AND prid.meta_key = %s\n                    AND p.post_type IN (%s, %s)\n                    AND templates.version <> pm.meta_value", TemplateConsumers::getContext(), Cookie::CPT_NAME, StorageHelper::TYPE_SERVICE, StorageHelper::TYPE_BLOCKER, Blocker::META_NAME_PRESET_VERSION, Blocker::META_NAME_PRESET_ID, Blocker::CPT_NAME, Cookie::CPT_NAME)
        );
        // Remove rows of languages other than current and cast to correct types
        foreach ($needsUpdate as $key => &$row) {
            $row->post_version_meta_id = \intval($row->post_version_meta_id);
            $row->post_id = \intval($row->post_id);
            $row->post_template_version = \intval($row->post_template_version);
            $row->should = \intval($row->should);
            if (\intval(Core::getInstance()->getCompLanguage()->getCurrentPostId($row->post_id, $row->post_type)) !== \intval($row->post_id)) {
                unset($needsUpdate[$key]);
            }
        }
        return \array_values($needsUpdate);
    }
}
