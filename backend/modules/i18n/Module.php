<?php

namespace backend\modules\i18n;
use backend\modules\i18n\models\I18nSourceMessage;
use backend\modules\i18n\models\I18nMessage;

class Module extends \yii\base\Module
{
    public $controllerNamespace = 'backend\modules\i18n\controllers';

    public function init()
    {
        parent::init();
    }

    /**
     * @param \yii\i18n\MissingTranslationEvent $event
     */
    public static function missingTranslation($event)
    {
        // do something with missing translation
        $messageSourceModel = new I18nSourceMessage();
        $source = $messageSourceModel->findOne(['category'=>$event->category,'message'=>$event->message]);
        if(!empty($source) && $source->id){
            $MessageModel = new I18nMessage();
            $target = $MessageModel->findOne(['id'=>$source->id,'language'=>$event->language]);
            if(!empty($target) && $target->translation){
                $event->translatedMessage = $target->translation;
            }
        }
    }
}
