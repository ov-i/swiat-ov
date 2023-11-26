<?php

declare(strict_types=1);

namespace App\Lib\SwiatOv;

use Illuminate\Routing\Route;
use Illuminate\Routing\Router;
use Livewire\Component;

class RouteCreator
{
    private static string $prefix;

    protected function __construct(
        string $prefix
    ) {
        self::$prefix = $prefix;
    }

    /**
     * Groups the routes with passed prefix
     * 
     * @param string $prefix
     * @param callable $callback
     * 
     * @return void
     */
    public static function group(string $prefix, callable $callback): void
    {
        $resource = new static($prefix);

        $callback($resource);
    }

    /**
     * Add a new resource.
     * 
     * @param class-string<Component> $resource The Livewire class.
     */
    public function make(string $resource): void
    {        
        if (false === is_subclass_of($resource, Component::class)) {
            throw new \Exception('Resource must be an instance of Livewire\Component');
        } else {
            $resource = new $resource();
        }

        if (str_contains($resource::class, 'View')) {
            $this->getRoute($resource::class, isSingular: true);
        } else {
            $this->getRoute($resource::class);
        }
    }

    /**
     * Get the name of the resource.
     * 
     * @param string $resource
     * @param bool $isSingular
     * 
     * @return string
     */
    public function getName(string $resource, bool $isSingular = false): string
    {
        $resourceName = \Illuminate\Support\Str::kebab(class_basename($resource));

        if (true === $isSingular) {
            $resourceName = substr($resourceName, 0, -5);
            return \Illuminate\Support\Str::singular($resourceName);
        }

        return $resourceName;
    }

    /**
     * Get the singular name of the resource.
     * 
     * @param string $resource
     * 
     * @return string
     */
    public function getSingular(string $resource): string
    {
        $singular = \Illuminate\Support\Str::singular($this->getName($resource));

        $singular = substr($singular, 0, -5);

        return $singular;
    }

    public function getSingularPrefix(): string
    {
        return \Illuminate\Support\Str::singular(self::$prefix);
    }

    /**
     * Get the route name of the resource.
     * 
     * @param string $resource
     * @param bool $isSingular
     * 
     * @return string
     */
    protected function getRouteName(string $resource, bool $isSingular = false): string
    {
        $singular = $this->getSingular($resource);
        $name = $this->getName($resource);

        if (true === $isSingular) {
            return sprintf('swiat-ov.%s.%s', self::$prefix, $singular);
        }

        return sprintf('swiat-ov.%s.%s', self::$prefix, $name);
    }

    /**
     * Get the route of the resource.
     * 
     * @param string $resource
     * @param bool $isSingular
     * 
     * @return Route
     */
    protected function getRoute(string $resource, bool $isSingular = false): Route
    {
        $resourceName = $this->getName($resource, $isSingular);

        $routeLocation = sprintf('resources/%s/%s', self::$prefix, $resourceName);

        if (true === $isSingular) {
            $singular = $this->getSingular($resource);

            $routeLocation = sprintf('%s/{%s}', $routeLocation, $singular);
        }

        /** @var Router $router */
        $router = app(Router::class);

        return $router->get($routeLocation, $resource)->name($this->getRouteName($resource, $isSingular));
    }
    
}
