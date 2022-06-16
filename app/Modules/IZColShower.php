<?php
/**
 * Created by PhpStorm.
 * User: ilyazakruta
 * Date: 11.02.2019
 * Time: 0:23
 */

namespace App\Modules;


use Illuminate\Database\Eloquent\Collection;

class IZColShower
{
    public $class;
    public $header;
    public $description;
    public $cols;
    public $items;
    public $item;
    public $breadcrumbs;
    public $actions;
    public $headerActions;

    public function __construct(string $header, array $cols = [], array $data = [], array $actions = [])
    {
        $this->header = $header;
        $this->cols = $cols;

        if(count($data) > 0)
        {
            if($data['type'] == 'collect')
            {
                $this->items = $data['items']->map(function ($item)use($actions){
                    $item = $item->toArray();
                    $item['actions'] = $this->renderActions($actions, $item['id']);

                    return $item;
                });
            }
            else
            {
                $item = $data['item']->toArray();
                $item['actions'] = $this->renderActions($actions, $item['id']);

                $this->item = $item;
            }
        }

        return $this;
    }

    public function setHeader(string $header)
    {
        return $this->header = $header;
    }
    public function setHeaderActions(array $data)
    {
        $headerActions = [];
        if(count($data) == 1)
        {
            $item = array_pop($data);
            $headerActions = $this->renderActions($item['routers'], $item['id']);
        }
        foreach ($data as $item) {
            $headerActions[] = $this->renderLink($item['route'], $item['class'], $item['icon'], $item['text']);
        }

        return $this->headerActions = $headerActions;
    }

    public function setDescription(string $description)
    {
        return $this->description = $description;
    }

    public function setCols(array $cols)
    {
        return $this->cols = $cols;
    }

    public function setItems(Collection $items)
    {
        return $this->items = $items;
    }

    public function setBreadcrumbs(array $data)
    {
        $breadcrumbs = [];
        foreach ($data as $breadcrumb) {

            $item = '<li>';
            if(gettype($breadcrumb) !== 'array')
            {
                $item .= $breadcrumb;
            }
            else
            {
                $item .= "<a href='{$breadcrumb['link']}'>{$breadcrumb['text']}</a>";
            }
            $item .= '</li>';

            $breadcrumbs[] = $item;
        }
        return $this->breadcrumbs = $breadcrumbs;
    }

    public function renderActions(array $routing, $id)
    {
        if(count($routing) > 0)
        {
            $actions = [];

            foreach ($routing as $type => $route)
            {
                switch ($type)
                {
                    case 'show' : {
                        $actions[] = $this->renderLink(route($route, ['id' => $id]), 'btn btn-primary', 'i-Eye');
                        break;
                    }
                    case 'edit' : {
                        $actions[] = $this->renderLink(route($route, ['id' => $id]), 'btn btn-warning', 'i-Pen-4');
                        break;
                    }
                    case 'destroy' : {
                        $btn['title'] = trans('panel.btn.confirm.destroy');
                        $btn['text'] = trans('panel.btn.confirm.destroy');
                        $btn['confirm'] = trans('panel.btn.confirm.ok');
                        $btn['cancel'] = trans('panel.btn.confirm.cancel');
                        $btn['name'] = 'destroy';
                        $btn['type'] = 'warning';
                        $btn['class'] = 'btn btn-danger';
                        $btn['color'] = '#3c8dbc';
                        $btn['text'] = '';
                        $btn['icon'] = 'i-Paint-Bucket';
                        $btn['id'] = $id;
                        $btn['url'] = route($route);
                        $actions[] = $this->renderSweetBtn($btn);
//                        $actions[] = $this->renderLink(route($route, ['id' => $id]), 'btn btn-danger', 'i-Paint-Bucket');
                        break;
                    }
                    case 'new' : {
                        $actions[] = $this->renderLink(route($route), 'btn btn-success', 'i-Add');
                        break;
                    }
                }
            }

            return $actions;
        }
        return null;
    }

    public function renderLink($route, $class, $icon, $text = '', $script = '')
    {
        if($script !== '')
        {
            $script = "<script type='application/javascript'>$(document).ready(function(){ $script })</script>";
        }
        return "<a href='$route' class='$class'><i class='$icon'></i>$text</a> $script";
    }

    public function renderBtn($class, $icon, $text = '', $id = '', array $data = [])
    {
        $dataStr = '';
        foreach ($data as $k=>$item) {
            $dataStr .= "data-$k='$item'";
        }
        return "<button id='$id' class='$class' $dataStr><i class='$icon'></i>$text</button>";
    }

    public function renderSweetBtn($btn)
    {
        return $this->renderBtn(
            "alert-confirm-destroy {$btn['class']}",
            "{$btn['icon']}",
            "{$btn['text']}",
            "alert-confirm-destroy-" . $btn['id'],
            [
                'id' => $btn['id'],
                'url' => $btn['url'],
                'title' => $btn['title'],
                'text' => $btn['text'],
            ]
        );
    }
}