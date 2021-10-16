<?php
/**
 * Created by PhpStorm.
 * User: dtv
 * Date: 10/16/2021
 * Time: 4:40 PM
 */

namespace Juzaweb\ImageSlider\Actions;

use Juzaweb\Abstracts\Action;
use Juzaweb\Facades\HookAction;

class MenuAction extends Action
{
    public function handle()
    {
        $this->addAction(self::BACKEND_CALL_ACTION, [$this, 'registerMenu']);
    }

    public function registerMenu()
    {
        HookAction::addAdminMenu(
            trans('juim::content.sliders'),
            'sliders',
            [
                'icon' => 'fa fa-film',
                'position' => 6,
                'parent' => 'appearance',
            ]
        );
    }
}
