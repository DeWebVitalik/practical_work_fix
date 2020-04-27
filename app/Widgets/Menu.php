<?php

namespace App\Widgets;

use Arrilot\Widgets\AbstractWidget;

class Menu extends AbstractWidget
{
    /**
     * The configuration array.
     *
     * @var array
     */
    protected $config = [];
    protected array $menu;

    /**
     * Treat this method as a controller action.
     * Return view() or other content to display.
     */
    public function run()
    {
        $this->setActiveElement();

        return view('widgets.menu.menu', [
            'menu' => $this->menu,
        ]);
    }

    protected function setActiveElement():void
    {
        foreach ($this->config as $item) {
            $active = false;

            if (request()->url() === $item['link']) {
                $active = true;
            }

            $this->menu[] = array_merge($item, ['active' => $active]);
        }
    }
}
