<?php

namespace funson86\auth;

use yii\base\BootstrapInterface;

/**
 * Blogs module bootstrap class.
 */
class Bootstrap implements BootstrapInterface
{
    /**
     * @inheritdoc
     */
    public function bootstrap($app)
    {
        // Add module I18N category.
        if (!isset($app->i18n->translations['funson86/auth']) && !isset($app->i18n->translations['funson86/*'])) {
            $app->i18n->translations['funson86/auth'] = [
                'class' => 'yii\i18n\PhpMessageSource',
                'basePath' => '@funson86/auth/messages',
                'forceTranslation' => true,
                'fileMap' => [
                    'funson86/auth' => 'auth.php',
                ]
            ];
        }
    }
}
