<?php

use \Sef\Validator\ConfigurationValidator;
use Mock\Module\Configuration\ModulesConfigurationMock;
use Mock\Module\Configuration\BadConfigurationMock;

class ConfigurationValidatorTest extends PHPUnit_Framework_TestCase
{
    /**
     * @covers \Sef\Validator\ConfigurationValidator::validateModulesConfiguration
     * @expectedException Exception
     */
    public function testValidateModulesConfigurationThrowsExceptionOnNoModulesArrayGiven()
    {
        $mockConf = new ModulesConfigurationMock();
        $validator = new ConfigurationValidator();
        $validator->validateModulesConfiguration($mockConf->getNoModulesConfiguration());
    }

    /**
     * @covers \Sef\Validator\ConfigurationValidator::validateModulesConfiguration
     * @expectedException Exception
     */
    public function testValidateModulesConfigurationThrowsExceptionOnModulesArrayEmpty()
    {
        $mockConf = new ModulesConfigurationMock();
        $validator = new ConfigurationValidator();
        $validator->validateModulesConfiguration($mockConf->getEmptyModulesConfiguration());
    }

    /**
     * @covers \Sef\Validator\ConfigurationValidator::validateModulesConfiguration
     * @expectedException Exception
     */
    public function testValidateModulesConfigurationThrowsExceptionOnNoFallbackArrayGiven()
    {
        $mockConf = new ModulesConfigurationMock();
        $validator = new ConfigurationValidator();
        $validator->validateModulesConfiguration($mockConf->getNoFallbackConfiguration());
    }

    /**
     * @covers \Sef\Validator\ConfigurationValidator::validateModulesConfiguration
     * @expectedException Exception
     */
    public function testValidateModulesConfigurationThrowsExceptionOnFallbackArrayEmpty()
    {
        $mockConf = new ModulesConfigurationMock();
        $validator = new ConfigurationValidator();
        $validator->validateModulesConfiguration($mockConf->getEmptyFallbackConfiguration());
    }

    /**
     * @covers \Sef\Validator\ConfigurationValidator::validateModuleConfiguration
     * @expectedException Exception
     */
    public function testValidateModuleConfigurationThrowsExceptionOnNoControllerGiven()
    {
        $mockConf = new BadConfigurationMock();
        $validator = new ConfigurationValidator();
        $validator->validateModuleConfiguration($mockConf->getConfigurationNoController(), false, 'regexp\/for\/the\/path\/?');
    }

    /**
     * @covers \Sef\Validator\ConfigurationValidator::validateModuleConfiguration
     * @expectedException Exception
     */
    public function testValidateModuleConfigurationThrowsExceptionOnEmptyControllerGiven()
    {
        $mockConf = new BadConfigurationMock();
        $validator = new ConfigurationValidator();
        $validator->validateModuleConfiguration($mockConf->getConfigurationEmptyController(), false, 'regexp\/for\/the\/path\/?');
    }

    /**
     * @covers \Sef\Validator\ConfigurationValidator::validateModuleConfiguration
     * @expectedException Exception
     */
    public function testValidateModuleConfigurationThrowsExceptionOnEmptyControllerForAllFunctionsGiven()
    {
        $mockConf = new BadConfigurationMock();
        $validator = new ConfigurationValidator();
        $validator->validateModuleConfiguration($mockConf->getConfigurationEmptyControllerForAllFunctions(), false, 'regexp\/for\/the\/path\/?');
    }

    /**
     * @covers \Sef\Validator\ConfigurationValidator::validateModuleConfiguration
     * @expectedException Exception
     */
    public function testValidateModuleConfigurationThrowsExceptionOnNoFallbackGiven()
    {
        $mockConf = new BadConfigurationMock();
        $validator = new ConfigurationValidator();
        $validator->validateModuleConfiguration($mockConf->getConfigurationNoFallback(), false, 'regexp\/for\/the\/path\/?');
    }

    /**
     * @covers \Sef\Validator\ConfigurationValidator::validateModuleConfiguration
     * @expectedException Exception
     */
    public function testValidateModuleConfigurationThrowsExceptionOnEmptyFallbackGiven()
    {
        $mockConf = new BadConfigurationMock();
        $validator = new ConfigurationValidator();
        $validator->validateModuleConfiguration($mockConf->getConfigurationEmptyFallback(), false, 'regexp\/for\/the\/path\/?');
    }

    /**
     * @covers \Sef\Validator\ConfigurationValidator::validateControllerExistence
     */
    public function testValidateControllerExistenceReturnsTrue()
    {
        $conf = new \Mock\Module\Configuration\ForumConfigurationMock();
        $validator = new ConfigurationValidatorProxy();
        $result = $validator->validateControllerExistence($conf->getConfigurationWithControllerDefinedForAllFunctions());
        $this->assertTrue($result);
    }

    public function testValidateControllerExistenceReturnsFalse()
    {
        $conf = new \Mock\Module\Configuration\ForumConfigurationMock();
        $validator = new ConfigurationValidatorProxy();
        $result = $validator->validateControllerExistence($conf->getConfiguration());
        $this->assertFalse($result);
    }
}

class ConfigurationValidatorProxy extends ConfigurationValidator
{
    public function validateControllerExistence(array $configuration)
    {
        return parent::validateControllerExistence($configuration);
    }
}