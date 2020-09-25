<?php

namespace Core\Router;

class Route
{
    /**
     * @var string
     */
    private $urlPattern;
    /**
     * @var string
     */
    private $controllerClass;
    /**
     * @var string
     */
    private $actionName;
    /**
     * @var string[]
     */
    private $parameters;

    /**
     * Route constructor.
     * @param $url
     * @param $controllerClass
     * @param $actionName
     */
    public function __construct($url, $controllerClass, $actionName)
    {
        $this->parameters = [];
        $this->urlPattern = $url;
        $this->controllerClass = $controllerClass;
        $this->actionName = $actionName;
    }

    /**
     * @return string
     */
    public function getUrlPattern(): string
    {
        return $this->urlPattern;
    }

    /**
     * @param string $urlPattern
     * @return Route
     */
    public function setUrlPattern(string $urlPattern): Route
    {
        $this->urlPattern = $urlPattern;
        return $this;
    }

    /**
     * @return string
     */
    public function getControllerClass(): string
    {
        return $this->controllerClass;
    }

    /**
     * @param string $controllerClass
     * @return Route
     */
    public function setControllerClass(string $controllerClass): Route
    {
        $this->controllerClass = $controllerClass;
        return $this;
    }

    /**
     * @return string
     */
    public function getActionName(): string
    {
        return $this->actionName;
    }

    /**
     * @param string $actionName
     * @return Route
     */
    public function setActionName(string $actionName): Route
    {
        $this->actionName = $actionName;
        return $this;
    }

    /**
     * @return string[]
     */
    public function getParameters(): array
    {
        return $this->parameters;
    }

    /**
     * @param string[] $parameters
     * @return Route
     */
    public function setParameters(array $parameters): Route
    {
        $this->parameters = $parameters;
        return $this;
    }
}