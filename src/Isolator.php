<?php

namespace SimplifiedIsolator;

class Isolator
{
    /**
     * @var array<string, callable>
     */
    private array $replacements = [];

    /**
     * @param array<string, callable> $replacements
     */
    function __construct(array $replacements = [])
    {
        foreach ($replacements as $methodName => $callable) {
            $this->replacements[strtolower($methodName)] = $callable;
        }
    }

    function __call(string $name, array $arguments)
    {
        $name = strtolower($name);
        $fun = $this->replacements[$name] ?? "\\$name";
        return call_user_func_array($fun, $arguments);
    }
}