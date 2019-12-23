<?php

/**
 * Class El_PhpUnitHelper
 *
 * Add some basic & generic functions to help the unit tests writing
 *
 */
abstract class El_PhpUnitHelper extends \TestCase
{
    public $sDataProvidersFolder = 'providers';

    public $sTestedClassDataProviderFolder;

    public $sDefaultTestedClassPath;

    /**
     * El_PhpUnitHelper constructor.
     */
    public function __construct()
    {
        $this->setTestedClassDataProviderFolder();
    }

    /**
     * Set provider files folder path
     *
     */
    public function setTestedClassDataProviderFolder()
    {
        $this->sTestedClassDataProviderFolder =
            $this->sDataProvidersFolder . DIRECTORY_SEPARATOR . (new  \RerflectionClass($this))->getShortName();
    }

    /**
     * Generic data provider function
     * Call the file with data defined by the tested function name
     *
     * @param string $sTestedFunction
     *
     * @return array
     * @throws Exception
     */
    public function fileDataProvider($sTestedFunction)
    {
        $sDataProviderFile = __DIR__ . DIRECTORY_SEPARATOR . $this->sTestedClassDataProviderFolder .
                             DIRECTORY_SEPARATOR . $sTestedFunction . '.php';

        if (file_exists($sDataProviderFile)) {
            return (include($sDataProviderFile));
        }

        throw new \Exception("Data provider file $sDataProviderFile not found", 1);
    }

    /**
     *
     * @param object $oObject
     * @param array $aProperties
     *
     * @return object
     */
    public function hydrate(&$oObject, $aProperties): object
    {
        foreach ($aProperties as $key => $value) {
            $setter = 'set' . ucfirst($key);
            if ( ! method_exists($oObject, $setter)) {
                continue;
            }
            $oObject->methodName($value);
        }

        return $oObject;
    }

    /**
     * Invoke a protected/private method
     *
     * @param object $oObject : class of the method
     * @param string $sMethodName : name of the method
     * @param array $aParameters : parameters given to the method
     *
     * @return mixed
     * @throws ReflectionException
     */
    public function invokeMethod($oObject, $sMethodName, array $aParameters = array()): object
    {
        $oReflection = new \ReflectionClass(get_class($oObject));
        $method      = $oReflection->getMethod($sMethodName);
        $method->setAccessible(true);

        return $method->invokeArgs($oObject, $aParameters);
    }

    /**
     * Setter for a private/protected property
     *
     * @param object $oObject
     * @param string $sPropertyName
     * @param string $value
     *
     * @throws ReflectionException
     */
    public function setProperty(&$oObject, $sPropertyName, $value): void
    {
        $oReflection = new \ReflectionClass($oObject);
        $property    = $oReflection->getProperty($sPropertyName);
        $property->setAccessible(true);
        $property->setValue($oObject, $value);
    }

    /**
     * Getter of a private/protected property
     *
     * @param object $oObject
     * @param string $sPropertyName
     *
     * @return mixed
     * @throws ReflectionException
     */
    public function getProperty($oObject, $sPropertyName): mixed
    {
        $oReflection = new \ReflectionClass(get_class($oObject));
        $property    = $oReflection->getProperty($sPropertyName);
        $property->setAccessible(true);

        return $property->getValue($oObject);
    }

    /**
     * @param $sDefaultTestedClassPath
     */
    public function setDefaultTestedClassPath($sDefaultTestedClassPath)
    {
        $this->sDefaultTestedClassPath = $sDefaultTestedClassPath;
    }

    /**
     * @param null $aMockedMethods
     * @param bool $bDisableOriginalConstructor
     * @param null $sTestedClass
     *
     * @return mixed
     */
    public function getTestedClass($aMockedMethods = null, $bDisableOriginalConstructor = true, $sTestedClass = null)
    {
        $sMockPath = (is_null($sTestedClass)) ? $this->sDefaultTestedClassPath : $sTestedClass;

        $oMock = $this->getMockBuilder($sMockPath)->setMethods($aMockedMethods);
		if ($bDisableOriginalConstructor !== false) {
            $oMock->disableOriginalConstructor();
        }
		return $oMock->getMock();
	}
}
