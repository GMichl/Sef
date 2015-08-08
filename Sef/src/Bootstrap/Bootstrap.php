<?php

namespace Sef\Bootstrap;

use DI\ContainerBuilder;
use Sef\Configuration\ConfigurationInterface;
use Sef\Controller\ControllerInterface;
use Sef\Router\Router;
use Sef\Validator\ConfigurationValidator;
use Symfony\Component\HttpFoundation\Request;

class Bootstrap
{
    /**
     * @var \DI\Container $moduleDiContainer
     */
    private $moduleDiContainer;

    /**
     * @var ControllerInterface $controller
     */
    private $controller;

    /**
     * @var $method
     */
    private $method;

    /**
     * set up all necessary variables for the module
     *
     * @param ConfigurationInterface $modulesConfiguration configuration that defines all modules
     */
    public function setUp(ConfigurationInterface $modulesConfiguration)
    {
        $configurationValidator = new ConfigurationValidator();
        $router = new Router();
        $router->setRequest(Request::createFromGlobals());

        $configurationValidator->validateModulesConfiguration($modulesConfiguration->getConfiguration());
        $router->resolvePath();
        $router->setModules($modulesConfiguration->getConfiguration());
        $router->resolveModule();
        $configurationValidator->validateModuleConfiguration($router->getModuleConfiguration());
        $router->process();
        $configurationValidator->validateModuleConfiguration($router->getModuleConfiguration(), $router->getModuleIsFallback());
        $moduleConfiguration = $router->getModuleConfiguration();
        $this->controller = $moduleConfiguration['controller'];
        $this->method = $moduleConfiguration[$router->getMatchingRegexp()]['method'];

        $diArr = $this->mergeDi($moduleConfiguration['dependencies'], $modulesConfiguration['functions'][$router->getMatchingRegexp()]['dependencies']);
        $this->moduleDiContainer = $this->initDI($diArr);
    }

    /**
     * start the user application
     */
    public function run()
    {
        /**
         * @var ControllerInterface $controller
         */
        $controller = new $this->controller;
        $controller->setDic($this->moduleDiContainer);
        $method = $this->method;
        $controller->$method();
    }

    /**
     * initialize the dependency injection container
     *
     * @param array $configuration
     * @return \DI\Container
     */
    protected function initDI(array $configuration)
    {
        $builder = new ContainerBuilder();
        $builder->addDefinitions($configuration);
        return $builder->build();
    }

    /**
     * merge both configurations
     *
     * @param array $moduleDi
     * @param array $functionDi
     * @return array
     */
    private function mergeDi(array $moduleDi, array $functionDi)
    {
        return array_merge($moduleDi, $functionDi);
    }
}
