<?php


namespace Core\Router;


use App\Config\Routes;

class Router
{

    public function findRoute(string $uri): ?Route
    {
        foreach (Routes::getRoutes() as $route) {
            $routePattern = str_replace('/', '\/', $route->getUrlPattern());

            $routePattern = '/^' . preg_replace('/{.*}/U', '([\w|-]*)', $routePattern) . '$/';

            if (preg_match($routePattern, $uri, $parametersRaw) === 0) {
                continue;
            }

            if (count($parametersRaw) > 1) {
      
                $parameters = [];
                preg_match_all('/{(.*)}/U', $route->getUrlPattern(), $parametersName);

                foreach ($parametersName[1] as $index => $value) {
                    $parameters[$value] = $parametersRaw[$index + 1];
                }

                $route->setParameters($parameters);
            }

            return $route;
        }

        return null;
    }
}