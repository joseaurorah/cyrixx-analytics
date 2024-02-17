<?php
/*
 * @copyright Copyright (c) 2021 AltumCode (https://altumcode.com/)
 *
 * This software is exclusively sold through https://altumcode.com/ by the AltumCode author.
 * Downloading this product from any other sources and running it without a proper license is illegal,
 *  except the official ones linked from https://altumcode.com/.
 */

namespace Altum\Controllers;

use Altum\Alerts;
use Altum\AnalyticsFilters;

class Replays extends Controller {

    public function index() {

        \Altum\Authentication::guard();

        if(!$this->website || !settings()->analytics->sessions_replays_is_enabled || ($this->website && $this->website->tracking_type == 'lightweight')) {
            redirect('websites');
        }

        /* Establish the start and end date for the statistics */
        list($start_date, $end_date) = AnalyticsFilters::get_date();

        $datetime = \Altum\Date::get_start_end_dates_new($start_date, $end_date);

        /* Filters */
        $active_filters = AnalyticsFilters::get_filters('websites_visitors');
        $filters = AnalyticsFilters::get_filters_sql($active_filters);

        /* Delete Modal */
        $view = new \Altum\View('replays/replays_delete_modal', (array) $this);
        \Altum\Event::add_content($view->run(['datetime' => $datetime]), 'modals');

        /* Prepare the paginator */
        $replays_data = database()->query("
            SELECT 
                COUNT(DISTINCT `sessions_replays`.`session_id`) AS `total`,
                AVG(`sessions_replays`.`events`) AS `average_events`
            FROM 
                `visitors_sessions` 
            LEFT JOIN
                `sessions_replays` ON `sessions_replays`.`session_id` = `visitors_sessions`.`session_id`
            LEFT JOIN
            	`websites_visitors` ON `visitors_sessions`.`visitor_id` = `websites_visitors`.`visitor_id`
            WHERE 
                `visitors_sessions`.`website_id` = {$this->website->website_id} 
                AND `sessions_replays`.`session_id` IS NOT NULL 
                AND (`visitors_sessions`.`date` BETWEEN '{$datetime['query_start_date']}' AND '{$datetime['query_end_date']}') 
                AND {$filters}
        ")->fetch_object();
        $paginator = (new \Altum\Paginator($replays_data->total ?? 0, settings()->main->default_results_per_page, $_GET['page'] ?? 1, url('replays?page=%d')));

        /* Duration average */
        $total_duration = 0;

        /* Get the websites list for the user */
        $replays = [];
        $replays_result = database()->query("
            SELECT
                `visitors_sessions`.`session_id`,
                `websites_visitors`.`visitor_uuid`,
                `websites_visitors`.`custom_parameters`,
                `websites_visitors`.`country_code`,
                `websites_visitors`.`visitor_id`,
                `websites_visitors`.`date`,
                
                `sessions_replays`.`events`,
                `sessions_replays`.`date`,
                `sessions_replays`.`last_date`            
            FROM
            	`visitors_sessions`
            LEFT JOIN
                `sessions_replays` ON `sessions_replays`.`session_id` = `visitors_sessions`.`session_id`
            LEFT JOIN
            	`websites_visitors` ON `visitors_sessions`.`visitor_id` = `websites_visitors`.`visitor_id`
            WHERE
			     `visitors_sessions`.`website_id` = {$this->website->website_id}
			     AND `sessions_replays`.`session_id` IS NOT NULL
			     AND (`visitors_sessions`.`date` BETWEEN '{$datetime['query_start_date']}' AND '{$datetime['query_end_date']}')
			     AND {$filters}
			GROUP BY
				`visitors_sessions`.`session_id`
			ORDER BY
				`visitors_sessions`.`session_id` DESC
            
            {$paginator->get_sql_limit()}
        ");
        while($row = $replays_result->fetch_object()) {
            $row->duration = (new \DateTime($row->last_date))->getTimestamp() - (new \DateTime($row->date))->getTimestamp();
            $total_duration += $row->duration;
            $replays[] = $row;
        }

        /* Calculate average duration */
        $average_duration = count($replays) ? $total_duration / count($replays) : 0;

        /* Prepare the pagination view */
        $pagination = (new \Altum\View('partials/pagination', (array) $this))->run(['paginator' => $paginator]);

        /* Prepare the View */
        $data = [
            'datetime' => $datetime,
            'replays_data' => $replays_data,
            'replays' => $replays,
            'pagination' => $pagination,
            'average_duration' => $average_duration,
        ];

        $view = new \Altum\View('replays/index', (array) $this);

        $this->add_view_content('content', $view->run($data));

    }

    public function delete() {

        \Altum\Authentication::guard();

        if(empty($_POST)) {
            redirect('replays');
        }

        if(!\Altum\Csrf::check()) {
            Alerts::add_error(l('global.error_message.invalid_csrf_token'));
            redirect('replays');
        }

        /* Delete one replay session */
        if(isset($_POST['session_id'])) {
            $_POST['session_id'] = (int) $_POST['session_id'];

            /* Database query */
            db()->where('session_id', $_POST['session_id'])->where('website_id', $this->website->website_id)->delete('sessions_replays');

            /* Clear cache */
            \Altum\Cache::$store_adapter->deleteItem('session_replay_' . $_POST['session_id']);

            /* Set a nice success message */
            Alerts::add_success(l('global.success_message.delete2'));

        }

        /* Delete all replay sessions within date range */
        else {

            /* Make sure the user has access to the website */
            if(!array_key_exists($_POST['website_id'], $this->websites)) {
                die();
            }

            /* Date parsing  */
            $start_date = isset($_POST['start_date']) ? query_clean($_POST['start_date']) : (new \DateTime())->modify('-30 day')->format('Y-m-d');
            $end_date = isset($_POST['end_date']) ? query_clean($_POST['end_date']) : (new \DateTime())->format('Y-m-d');

            $date = \Altum\Date::get_start_end_dates($start_date, $end_date);

            /* Filters */
            $active_filters = AnalyticsFilters::get_filters('websites_visitors');
            $filters = AnalyticsFilters::get_filters_sql($active_filters);

            /* Select all the session id's to delete from the file system */
            $stmt = database()->query("
                SELECT 
                    `session_id`
                FROM 
                    `sessions_replays`
                LEFT JOIN
                    `websites_visitors` ON `sessions_replays`.`visitor_id` = `websites_visitors`.`visitor_id`
                WHERE 
                    (`sessions_replays`.`date` BETWEEN '{$date->start_date_query}' AND '{$date->end_date_query}')
                    AND {$filters}
                    AND `sessions_replays`.`website_id` = '{$_POST['website_id']}'
            ");

            while($row = $stmt->fetch_object()) {

                /* Clear cache */
                \Altum\Cache::$store_adapter->deleteItem('session_replay_' . $row->session_id);

            }

            /* Database query */
            $stmt = database()->prepare("
                DELETE 
                    `sessions_replays`
                FROM 
                    `sessions_replays`
                LEFT JOIN
                    `websites_visitors` ON `sessions_replays`.`visitor_id` = `websites_visitors`.`visitor_id`
                WHERE 
                    (`sessions_replays`.`date` BETWEEN '{$date->start_date_query}' AND '{$date->end_date_query}')
                    AND {$filters}
                    AND `sessions_replays`.`website_id` = ?
            ");
            $stmt->bind_param('s', $_POST['website_id']);
            $stmt->execute();
            $stmt->close();

            /* Set a nice success message */
            Alerts::add_success(l('replays_delete_modal.success_message'));

        }

        redirect('replays');
    }

}
