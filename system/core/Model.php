<?php
/**
 * Created by PhpStorm.
 * User: roger.s
 * Date: 2017/6/6
 * Time: 15:48
 */

namespace Core;

use Illuminate\Database\Capsule\Manager as DatabaseCapsule;
use LaravelArdent\Ardent\Ardent;
use Illuminate\Events\Dispatcher;
use Illuminate\Container\Container;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Translation\FileLoader;
use Illuminate\Translation\Translator;
use Illuminate\Validation\Factory as ValidationFactory;
use Illuminate\Validation\DatabasePresenceVerifier;
use Illuminate\Hashing\BcryptHasher;

class Model extends Ardent
{
    public $throwOnValidation = true;

    public static function configureAsExternal(array $connection, $lang = 'zh-CN') {
        $db = new DatabaseCapsule;
        foreach ($connection as $name => $config) {
            $db->addConnection($config, $name);
        }
        $db->setEventDispatcher(new Dispatcher(new Container));
        $db->setAsGlobal();
        $db->bootEloquent();

        $file = new Filesystem();
        $fileLoader = new FileLoader($file, dirname(__FILE__).DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'lang'.DIRECTORY_SEPARATOR.$lang.DIRECTORY_SEPARATOR.'validation.php');
        $translator = new Translator($fileLoader, $lang);

        self::$external = true;
        self::$validationFactory = new ValidationFactory($translator);
        self::$validationFactory->setPresenceVerifier(new DatabasePresenceVerifier($db->getDatabaseManager()));

        self::$hasher = new BcryptHasher();
    }

    /**
     * @param mixed $id
     * @param array $columns
     *
     * @return static
     */
    public static function find($id, $columns = array('*')) {
        return parent::find($id, $columns);
    }

}
