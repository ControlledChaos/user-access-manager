<?php
/**
 * ControllerFactory.php
 *
 * The ControllerFactory class file.
 *
 * PHP versions 5
 *
 * @author    Alexander Schneider <alexanderschneider85@gmail.com>
 * @copyright 2008-2017 Alexander Schneider
 * @license   http://www.gnu.org/licenses/gpl-2.0.html  GNU General Public License, version 2
 * @version   SVN: $id$
 * @link      http://wordpress.org/extend/plugins/user-access-manager/
 */
namespace UserAccessManager\Controller;

use UserAccessManager\AccessHandler\AccessHandler;
use UserAccessManager\Cache\Cache;
use UserAccessManager\Config\MainConfig;
use UserAccessManager\Controller\Backend\AboutController;
use UserAccessManager\Controller\Backend\BackendController;
use UserAccessManager\Controller\Backend\DynamicGroupsController;
use UserAccessManager\Controller\Backend\ObjectController;
use UserAccessManager\Controller\Backend\PostObjectController;
use UserAccessManager\Controller\Backend\SettingsController;
use UserAccessManager\Controller\Backend\SetupController;
use UserAccessManager\Controller\Backend\TermObjectController;
use UserAccessManager\Controller\Backend\UserGroupController;
use UserAccessManager\Controller\Backend\UserObjectController;
use UserAccessManager\Controller\Frontend\FrontendController;
use UserAccessManager\Controller\Frontend\PostController;
use UserAccessManager\Controller\Frontend\RedirectController;
use UserAccessManager\Controller\Frontend\ShortCodeController;
use UserAccessManager\Controller\Frontend\TermController;
use UserAccessManager\Database\Database;
use UserAccessManager\FileHandler\FileHandler;
use UserAccessManager\FileHandler\FileObjectFactory;
use UserAccessManager\Form\FormFactory;
use UserAccessManager\Form\FormHelper;
use UserAccessManager\ObjectHandler\ObjectHandler;
use UserAccessManager\SetupHandler\SetupHandler;
use UserAccessManager\UserGroup\UserGroupFactory;
use UserAccessManager\Util\Util;
use UserAccessManager\Wrapper\Php;
use UserAccessManager\Wrapper\Wordpress;

/**
 * Class ControllerFactory
 *
 * @package UserAccessManager\Controller
 */
class ControllerFactory
{
    /**
     * @var Php
     */
    private $php;

    /**
     * @var Wordpress
     */
    private $wordpress;

    /**
     * @var Database
     */
    private $database;

    /**
     * @var MainConfig
     */
    private $config;

    /**
     * @var Util
     */
    private $util;

    /**
     * @var Cache
     */
    private $cache;

    /**
     * @var ObjectHandler
     */
    private $objectHandler;

    /**
     * @var AccessHandler
     */
    private $accessHandler;

    /**
     * @var UserGroupFactory
     */
    private $userGroupFactory;

    /**
     * @var FileHandler
     */
    private $fileHandler;

    /**
     * @var FileObjectFactory
     */
    private $fileObjectFactory;

    /**
     * @var SetupHandler
     */
    private $setupHandler;

    /**
     * @var FormFactory
     */
    private $formFactory;

    /**
     * @var FormHelper
     */
    private $formHelper;

    /**
     * ControllerFactory constructor.
     *
     * @param Php               $php
     * @param Wordpress         $wordpress
     * @param Database          $database
     * @param MainConfig        $config
     * @param Util              $util
     * @param Cache             $cache
     * @param ObjectHandler     $objectHandler
     * @param AccessHandler     $accessHandler
     * @param UserGroupFactory  $userGroupFactory
     * @param FileHandler       $fileHandler
     * @param FileObjectFactory $fileObjectFactory
     * @param SetupHandler      $setupHandler
     * @param FormFactory       $formFactory
     * @param FormHelper        $formHelper
     */
    public function __construct(
        Php $php,
        Wordpress $wordpress,
        Database $database,
        MainConfig $config,
        Util $util,
        Cache $cache,
        ObjectHandler $objectHandler,
        AccessHandler $accessHandler,
        UserGroupFactory $userGroupFactory,
        FileHandler $fileHandler,
        FileObjectFactory $fileObjectFactory,
        SetupHandler $setupHandler,
        FormFactory $formFactory,
        FormHelper $formHelper
    ) {
        $this->php = $php;
        $this->wordpress = $wordpress;
        $this->database = $database;
        $this->config = $config;
        $this->util = $util;
        $this->cache = $cache;
        $this->objectHandler = $objectHandler;
        $this->accessHandler = $accessHandler;
        $this->userGroupFactory = $userGroupFactory;
        $this->fileHandler = $fileHandler;
        $this->fileObjectFactory = $fileObjectFactory;
        $this->setupHandler = $setupHandler;
        $this->formFactory = $formFactory;
        $this->formHelper = $formHelper;
    }

    /**
     * Creates and returns a new backend controller.
     *
     * @return BackendController
     */
    public function createBackendController()
    {
        return new BackendController(
            $this->php,
            $this->wordpress,
            $this->config,
            $this->accessHandler,
            $this->fileHandler
        );
    }

    /**
     * Creates and returns a new backend about controller.
     *
     * @return AboutController
     */
    public function createBackendAboutController()
    {
        return new AboutController(
            $this->php,
            $this->wordpress,
            $this->config
        );
    }

    /**
     * Creates and returns a new backend object controller.
     *
     * @return ObjectController
     */
    public function createBackendObjectController()
    {
        return new ObjectController(
            $this->php,
            $this->wordpress,
            $this->config,
            $this->database,
            $this->cache,
            $this->objectHandler,
            $this->accessHandler,
            $this->userGroupFactory
        );
    }

    /**
     * Creates and returns a new backend post object controller.
     *
     * @return PostObjectController
     */
    public function createBackendPostObjectController()
    {
        return new PostObjectController(
            $this->php,
            $this->wordpress,
            $this->config,
            $this->database,
            $this->cache,
            $this->objectHandler,
            $this->accessHandler,
            $this->userGroupFactory
        );
    }

    /**
     * Creates and returns a new backend term object controller.
     *
     * @return TermObjectController
     */
    public function createBackendTermObjectController()
    {
        return new TermObjectController(
            $this->php,
            $this->wordpress,
            $this->config,
            $this->database,
            $this->cache,
            $this->objectHandler,
            $this->accessHandler,
            $this->userGroupFactory
        );
    }

    /**
     * Creates and returns a new backend user object controller.
     *
     * @return UserObjectController
     */
    public function createBackendUserObjectController()
    {
        return new UserObjectController(
            $this->php,
            $this->wordpress,
            $this->config,
            $this->database,
            $this->cache,
            $this->objectHandler,
            $this->accessHandler,
            $this->userGroupFactory
        );
    }

    /**
     * Creates and returns a new backend dynamic group controller.
     *
     * @return DynamicGroupsController
     */
    public function createBackendDynamicGroupsController()
    {
        return new DynamicGroupsController(
            $this->php,
            $this->wordpress,
            $this->config,
            $this->database,
            $this->cache,
            $this->objectHandler,
            $this->accessHandler,
            $this->userGroupFactory
        );
    }

    /**
     * Creates and returns a new backend setup controller.
     *
     * @return SettingsController
     */
    public function createBackendSettingsController()
    {
        return new SettingsController(
            $this->php,
            $this->wordpress,
            $this->config,
            $this->cache,
            $this->objectHandler,
            $this->fileHandler,
            $this->formFactory,
            $this->formHelper
        );
    }

    /**
     * Creates and returns a new backend setup controller.
     *
     * @return SetupController
     */
    public function createBackendSetupController()
    {
        return new SetupController(
            $this->php,
            $this->wordpress,
            $this->config,
            $this->database,
            $this->setupHandler
        );
    }

    /**
     * Creates and returns a new backend user group controller.
     *
     * @return UserGroupController
     */
    public function createBackendUserGroupController()
    {
        return new UserGroupController(
            $this->php,
            $this->wordpress,
            $this->config,
            $this->accessHandler,
            $this->userGroupFactory,
            $this->formHelper
        );
    }

    /**
     * Creates and returns a new frontend controller.
     *
     * @return FrontendController
     */
    public function createFrontendController()
    {
        return new FrontendController(
            $this->php,
            $this->wordpress,
            $this->config,
            $this->accessHandler
        );
    }

    /**
     * Creates and returns a new frontend post controller.
     *
     * @return PostController
     */
    public function createFrontendPostController()
    {
        return new PostController(
            $this->php,
            $this->wordpress,
            $this->config,
            $this->database,
            $this->util,
            $this->cache,
            $this->objectHandler,
            $this->accessHandler
        );
    }

    /**
     * Creates and returns a new frontend redirect controller.
     *
     * @return RedirectController
     */
    public function createFrontendRedirectController()
    {
        return new RedirectController(
            $this->php,
            $this->wordpress,
            $this->config,
            $this->database,
            $this->util,
            $this->cache,
            $this->objectHandler,
            $this->accessHandler,
            $this->fileHandler,
            $this->fileObjectFactory
        );
    }

    /**
     * Creates and returns a new frontend short code controller.
     *
     * @return ShortCodeController
     */
    public function createFrontendShortCodeController()
    {
        return new ShortCodeController(
            $this->php,
            $this->wordpress,
            $this->config,
            $this->accessHandler
        );
    }

    /**
     * Creates and returns a new frontend term controller.
     *
     * @return TermController
     */
    public function createFrontendTermController()
    {
        return new TermController(
            $this->php,
            $this->wordpress,
            $this->config,
            $this->util,
            $this->objectHandler,
            $this->accessHandler
        );
    }
}