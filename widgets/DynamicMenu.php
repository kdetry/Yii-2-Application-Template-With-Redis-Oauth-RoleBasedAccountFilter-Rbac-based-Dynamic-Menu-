<?php

namespace app\widgets;

use Yii;
use yii\base\Widget;
use yii\widgets\Menu;

class DynamicMenu extends Widget
{
    /*
      public function __construct()
      {
      print_r($this->getRaporKategorileri());exit;
      }
     */

    public $message;
	public $items;

    public function init()
    {
        parent::init();
		
        $this->items = [
            // Important: you need to specify url as 'controller/action',
            // not just as 'controller' even if default action is used.
            ['label' => '<i class="fa fa-home"></i> <span>Anasayfa</span>', 'url' => Yii::$app->urlManager->createUrl(['site/index'])],
            ['label' => '<i class="fa fa-map-pin"></i> <span>Device', 'url' => '#', 'options' => ['class' => 'treeview active'], 'items' => [
                    ['label' => 'Device List', 'url' => Yii::$app->urlManager->createUrl(['Device/index'])],
                    ['label' => 'Device Create', 'url' => Yii::$app->urlManager->createUrl(['Device/create'])],
				]
			],
			['label' => '<i class="fa fa-bolt"></i> <span>LDAP Yetki', 'url' => '#', 'options' => ['class' => 'treeview active'], 'items' => [
                    ['label' => 'Yetki Sorgula / Değiştir', 'url' => Yii::$app->urlManager->createUrl(['ldap/index'])],
				]
			],
			['label' => '<i class="fa fa-sign-out"></i> <span>Çıkış</span>', 'url' => 'site/logout']
        ];


    }

	public function setItemsByPermission() {
		$items = $this->items;
		//print_r($items);exit;
		//print_r(Yii::$app->OAuth2->getPermissions());exit;
		//exit;
		$cItems = count($items);
		for($i = 0; $i < $cItems; $i++){
			$url = ltrim($items[$i]['url'],  '/');
			if ($items[$i]['url'] !== '#' && $this->checkPermissionOf($url) === false) {
				unset($items[$i]);
			}
			if(isset($items[$i]['items'])){
				$cItemsSecond = count($items[$i]['items']);
				for($zeta = 0; $zeta < $cItemsSecond; $zeta++){
					$urlB = ltrim($items[$i]['items'][$zeta]['url'],  '/');

					if ($this->checkPermissionOf($urlB) === false) {
						unset($items[$i]['items'][$zeta]);
					}
				}
			}
			if(isset($items[$i]['items']) && empty($items[$i]['items'])){
				unset($items[$i]);
			}
		}
		//print_r($items);exit;
		return $items;
	}
	
	private function checkPermissionOf($url){
		return Yii::$app->OAuth2->checkPermission($url);
	}
	
	private function setContent(){
		return Menu::widget([
			'options' => ['class' => 'sidebar-menu'],
			'items' => $this->setItemsByPermission(),
			'submenuTemplate' => "\n<ul class='treeview-menu'>\n{items}\n</ul>\n",
			'encodeLabels' => false
        ]);
	}
	
    public function run()
    {
		return $this->setContent();
    }

}
