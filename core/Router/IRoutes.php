<?php


namespace Core\Router;


interface IRoutes
{
    /**
     * @return Route[]
     */
    public static function getRoutes(): array;
}