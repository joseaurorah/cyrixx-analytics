<?php
/*
 * @copyright Copyright (c) 2021 AltumCode (https://altumcode.com/)
 *
 * This software is exclusively sold through https://altumcode.com/ by the AltumCode author.
 * Downloading this product from any other sources and running it without a proper license is illegal,
 *  except the official ones linked from https://altumcode.com/.
 */

namespace Altum\Controllers;


class Websites extends Controller {

    public function index() {

        \Altum\Authentication::guard();

        /* Get available custom domains */
        $domains = (new \Altum\Models\Domain())->get_available_domains_by_user_id($this->user->user_id);

        /* Prepare the filtering system */
        $filters = (new \Altum\Filters(['is_enabled', 'tracking_type'], ['name', 'host'], ['date', 'name']));
        $filters->set_default_order_by('website_id', settings()->main->default_order_type);
        $filters->set_default_results_per_page(settings()->main->default_results_per_page);

        /* Prepare the paginator */
        $total_rows = database()->query("SELECT COUNT(*) AS `total` FROM `websites` WHERE `user_id` = {$this->user->user_id} {$filters->get_sql_where()}")->fetch_object()->total ?? 0;
        $paginator = (new \Altum\Paginator($total_rows, $filters->get_results_per_page(), $_GET['page'] ?? 1, url('websites?' . $filters->get_get() . '&page=%d')));

        /* Get the websites list for the user */
        $websites = [];
        $websites_result = database()->query("
            SELECT 
                `websites`.*, 
                COUNT(DISTINCT `websites_heatmaps`.`heatmap_id`) AS `heatmaps`, 
                COUNT(DISTINCT `websites_goals`.`goal_id`) AS `goals`
            FROM 
                 `websites`
            LEFT JOIN 
                `websites_heatmaps` ON `websites_heatmaps`.`website_id` = `websites`.`website_id` 
            LEFT JOIN 
                `websites_goals` ON `websites_goals`.`website_id` = `websites`.`website_id`
            WHERE 
                  `websites`.`user_id` = {$this->user->user_id}
                  {$filters->get_sql_where('websites')}
            GROUP BY 
                `websites`.`website_id`
                {$filters->get_sql_order_by('websites')}
            
            {$paginator->get_sql_limit()}
        ");
        while($row = $websites_result->fetch_object()) $websites[] = $row;

        /* Prepare the pagination view */
        $pagination = (new \Altum\View('partials/pagination', (array) $this))->run(['paginator' => $paginator]);

        /* Prepare the View */
        $data = [
            'websites' => $websites,
            'pagination' => $pagination,
            'filters' => $filters,
            'domains' => $domains,
        ];

        $view = new \Altum\View('websites/index', (array) $this);

        $this->add_view_content('content', $view->run($data));

    }

}
