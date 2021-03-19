<?php


namespace Core\Utilities;


use Exception;
use ReflectionException;
use ReflectionObject;

abstract class Explorer
{
    public static function getValue($tabOrObj, string $key, $default = null)
    {
        try {
            if (is_array($tabOrObj)) {
                return $tabOrObj[$key] ?? $default;
            }

            if (!is_object($tabOrObj)) {
                throw new Exception('Should be an object or an array.');
            }

            $reflectionObject = new ReflectionObject($tabOrObj);

            if ($reflectionObject->hasProperty($key) && $reflectionObject->getProperty($key)->isPublic()) {
                return $tabOrObj->$key;
            }

            foreach (['', 'is', 'has', 'get'] as $startMethodName) {
                $methodName = $startMethodName . ((strlen($startMethodName) === 0) ? $key : ucfirst($key));

                if ($reflectionObject->hasMethod($methodName) && $reflectionObject->getMethod($methodName)->isPublic(
                    )) {
                    return $tabOrObj->$methodName();
                }
            }

            return $default;
        } catch (ReflectionException $e) {
            throw new Exception('Should be an object or an array.');
        }
    }

    public static function setValue($tabOrObj, string $key, $value)
    {
        try {
            if (is_array($tabOrObj)) {
                $tabOrObj[$key] = $value;
                return;
            }

            if (!is_object($tabOrObj)) {
                throw new Exception('Should be an object or an array.');
            }

            $reflectionObject = new ReflectionObject($tabOrObj);

            if ($reflectionObject->hasProperty($key) && $reflectionObject->getProperty($key)->isPublic()) {
                $tabOrObj->$key = $value;
                return;
            }

            foreach (['', 'set'] as $startMethodName) {
                $methodName = $startMethodName . ((strlen($startMethodName) === 0) ? $key : ucfirst($key));

                if ($reflectionObject->hasMethod($methodName) && $reflectionObject->getMethod($methodName)->isPublic(
                    )) {
                    $tabOrObj->$methodName($value);
                    return;
                }
            }
        } catch (ReflectionException $e) {
            throw new Exception('Should be an object or an array.');
        }
    }

}