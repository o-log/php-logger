<?php

namespace LoggerDemo;

use OLOG\ActionInterface;
use OLOG\GET;
use OLOG\HTML;
use OLOG\Layouts\AdminLayoutSelector;
use OLOG\Logger\Admin\EntriesListAction;
use OLOG\Logger\Admin\ObjectEntriesListAction;
use OLOG\Model\FullObjectId;
use OLOG\Redirects;

class DemoMainPageAction implements ActionInterface
{
    const ACTION_ADD_MODEL = 'ACTION_ADD_MODEL';
    const ACTION_UPDATE_MODEL = 'ACTION_UPDATE_MODEL';

    public function url(){
        return '/';
    }

    public function action()
    {
        if (GET::optional('a', '') == self::ACTION_ADD_MODEL){
            $new_model_obj = new LoggerDemoModel();
            $new_model_obj->save();
            Redirects::redirectToSelfNoGetForm();
        }

        if (GET::optional('a', '') == self::ACTION_UPDATE_MODEL){
            $model_id = GET::required('model_id');

            $new_model_obj = LoggerDemoModel::factory($model_id);
            $new_model_obj->setTitle(rand(100, 9999999));
            $new_model_obj->save();
            Redirects::redirectToSelfNoGetForm();
        }

        $html = '';

        $html .= '<p>set full access cookie (see config) before entering admin</p>';

        $html .= HTML::div('', '', function () {
            echo HTML::a((new EntriesListAction())->url(), 'all entries list');
        });

        $html .= HTML::div('', '', function () {
            echo HTML::a('/?a=' . self::ACTION_ADD_MODEL, 'add model');
        });

        $model_ids_arr = LoggerDemoModel::getAllIdsArrByCreatedAtDesc();

        foreach ($model_ids_arr as $model_id){
            $html .= \OLOG\HTML::div('', '', function () use ($model_id){
                $model_obj = LoggerDemoModel::factory($model_id);

                echo $model_obj->getId();
                echo ' ';

                echo $model_obj->getTitle();
                echo ' ';

                echo HTML::a('/?a=' . self::ACTION_UPDATE_MODEL . "&model_id=" . $model_id, 'update model');
                echo ' ';

                $model_fullid = FullObjectId::getFullObjectId($model_obj);
                echo HTML::a((new ObjectEntriesListAction(urlencode($model_fullid)))->url(), 'log');
            });
        }

        AdminLayoutSelector::render($html, $this);
    }

}
