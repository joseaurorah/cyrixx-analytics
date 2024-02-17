<?php
/*
 * @copyright Copyright (c) 2021 AltumCode (https://altumcode.com/)
 *
 * This software is exclusively sold through https://altumcode.com/ by the AltumCode author.
 * Downloading this product from any other sources and running it without a proper license is illegal,
 *  except the official ones linked from https://altumcode.com/.
 */

namespace Altum\Controllers;

use Altum\Date;
use Altum\Response;

class WebsitesAjax extends Controller {

    public function index() {

        \Altum\Authentication::guard();

        /* Make sure its not a request from a team member */
        if($this->team) {
            die();
        }

        //ALTUMCODE:DEMO if(DEMO) if($this->user->user_id == 1) Response::json('Please create an account on the demo to test out this function.', 'error');

        if(!empty($_POST) && (\Altum\Csrf::check() || \Altum\Csrf::check('global_token')) && isset($_POST['request_type'])) {

            switch($_POST['request_type']) {

                /* Create */
                case 'create': $this->create(); break;

                /* Update */
                case 'update': $this->update(); break;

                /* Delete */
                case 'delete': $this->delete(); break;

            }

        }

        die();
    }

    private function create() {
        $_POST['name'] = trim(query_clean($_POST['name']));
        $_POST['scheme'] = in_array($_POST['scheme'], ['https://', 'http://']) ? query_clean($_POST['scheme']) : 'https://';
        $_POST['host'] = mb_strtolower(trim($_POST['host']));
        $_POST['tracking_type'] = in_array($_POST['tracking_type'], ['lightweight', 'normal']) ? query_clean($_POST['tracking_type']) : 'lightweight';
        $_POST['events_children_is_enabled'] = (int) isset($_POST['events_children_is_enabled']);
        $_POST['sessions_replays_is_enabled'] = (int) isset($_POST['sessions_replays_is_enabled']);
        $_POST['email_reports_is_enabled'] = (int) isset($_POST['email_reports_is_enabled']);
        $is_enabled = 1;

        /* Get available custom domains */
        $domain_id = null;
        if(isset($_POST['domain_id'])) {
            $domain = (new \Altum\Models\Domain())->get_domain_by_domain_id($_POST['domain_id']);

            if($domain && $domain->user_id == $this->user->user_id) {
                $domain_id = $domain->domain_id;
            }
        }

        /* Check for possible errors */
        if(empty($_POST['name']) || empty($_POST['host'])) {
            Response::json(l('global.error_message.empty_fields'), 'error');
        }

        /* Domain checking */
        $pslManager = new \Pdp\PublicSuffixListManager();
        $parser = new \Pdp\Parser($pslManager->getList());
        $url = $parser->parseUrl($_POST['host']);
        $punnnycode = new \TrueBV\Punycode();
        $host = query_clean($punnnycode->encode($url->getHost()));
        $path = query_clean($url->getPath()) ? preg_replace('/\/+$/', '', query_clean($url->getPath())) : null;

        /* Generate an unique pixel key for the website */
        $pixel_key = string_generate(16);
        while(db()->where('pixel_key', $pixel_key)->getOne('websites', ['pixel_key'])) {
            $pixel_key = string_generate(16);
        }

        /* Make sure that the user didn't exceed the limit */
        $total_rows = db()->where('user_id', $this->user->user_id)->getValue('websites', 'count(`website_id`)');
        if($this->user->plan_settings->websites_limit != -1 && $total_rows >= $this->user->plan_settings->websites_limit) {
            Response::json(l('global.info_message.plan_feature_limit'), 'error');
        }

        /* Database query */
        $website_id = db()->insert('websites', [
            'user_id' => $this->user->user_id,
            'domain_id' => $domain_id,
            'pixel_key' => $pixel_key,
            'name' => $_POST['name'],
            'scheme' => $_POST['scheme'],
            'host' => $host,
            'path' => $path,
            'tracking_type' => $_POST['tracking_type'],
            'events_children_is_enabled' => $_POST['events_children_is_enabled'],
            'sessions_replays_is_enabled' => $_POST['sessions_replays_is_enabled'],
            'email_reports_is_enabled' => $_POST['email_reports_is_enabled'],
            'email_reports_last_date' => Date::$date,
            'is_enabled' => $is_enabled,
            'date' => Date::$date,
        ]);

        /* Clear cache */
        \Altum\Cache::$adapter->deleteItem('websites_' . $this->user->user_id);
        \Altum\Cache::$adapter->deleteItemsByTag('website_id=' . $website_id);

        Response::json(sprintf(l('global.success_message.create1'), '<strong>' . $_POST['name'] . '</strong>'), 'success');
    }

    private function update() {
        $_POST['website_id'] = (int) $_POST['website_id'];
        $_POST['name'] = trim(query_clean($_POST['name']));
        $_POST['scheme'] = in_array($_POST['scheme'], ['https://', 'http://']) ? query_clean($_POST['scheme']) : 'https://';
        $_POST['host'] = mb_strtolower(trim($_POST['host']));
        $_POST['events_children_is_enabled'] = (int) isset($_POST['events_children_is_enabled']);
        $_POST['sessions_replays_is_enabled'] = (int) isset($_POST['sessions_replays_is_enabled']);
        $_POST['email_reports_is_enabled'] = (int) isset($_POST['email_reports_is_enabled']);
        $_POST['is_enabled'] = (int) isset($_POST['is_enabled']);
        $_POST['excluded_ips'] = implode(',', array_map(function($value) {
            return query_clean(trim($value));
        }, explode(',', $_POST['excluded_ips'])));

        /* Get available custom domains */
        $domain_id = null;
        if(isset($_POST['domain_id'])) {
            $domain = (new \Altum\Models\Domain())->get_domain_by_domain_id($_POST['domain_id']);

            if($domain && $domain->user_id == $this->user->user_id) {
                $domain_id = $domain->domain_id;
            }
        }

        /* Check for possible errors */
        if(empty($_POST['name']) || empty($_POST['host'])) {
            Response::json(l('global.error_message.empty_fields'), 'error');
        }

        /* Domain checking */
        $pslManager = new \Pdp\PublicSuffixListManager();
        $parser = new \Pdp\Parser($pslManager->getList());
        $url = $parser->parseUrl($_POST['host']);
        $punnnycode = new \TrueBV\Punycode();
        $host = query_clean($punnnycode->encode($url->getHost()));
        $path = query_clean($url->getPath()) ? preg_replace('/\/+$/', '', query_clean($url->getPath())) : null;

        /* Database query */
        db()->where('website_id', $_POST['website_id'])->where('user_id', $this->user->user_id)->update('websites', [
            'domain_id' => $domain_id,
            'name' => $_POST['name'],
            'scheme' => $_POST['scheme'],
            'host' => $host,
            'path' => $path,
            'excluded_ips' => $_POST['excluded_ips'],
            'events_children_is_enabled' => $_POST['events_children_is_enabled'],
            'sessions_replays_is_enabled' => $_POST['sessions_replays_is_enabled'],
            'email_reports_is_enabled' => $_POST['email_reports_is_enabled'],
            'is_enabled' => $_POST['is_enabled'],
        ]);

        /* Clear cache */
        \Altum\Cache::$adapter->deleteItem('websites_' . $this->user->user_id);
        \Altum\Cache::$adapter->deleteItemsByTag('website_id=' . $_POST['website_id']);

        Response::json(sprintf(l('global.success_message.update1'), '<strong>' . $_POST['name'] . '</strong>'), 'success');
    }

    private function delete() {
        $_POST['website_id'] = (int) $_POST['website_id'];

        /* Make sure of the owner */
        if(!db()->where('website_id', $_POST['website_id'])->where('user_id', $this->user->user_id)->getOne('websites', ['website_id'])) {
            die();
        }

        /* Database query */
        db()->where('website_id', $_POST['website_id'])->where('user_id', $this->user->user_id)->delete('websites');

        /* Clear cache */
        \Altum\Cache::$adapter->deleteItem('websites_' . $this->user->user_id);
        \Altum\Cache::$store_adapter->deleteItemsByTag('session_replay_website_' . $_POST['website_id']);
        \Altum\Cache::$adapter->deleteItemsByTag('website_id=' . $_POST['website_id']);

        Response::json(l('global.success_message.delete2'), 'success');

    }

}
