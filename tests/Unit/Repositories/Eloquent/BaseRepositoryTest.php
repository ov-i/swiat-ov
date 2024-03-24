<?php

use App\Contracts\EloquentRepository;
use App\Repositories\Eloquent\BaseRepository;

use function Pest\Laravel\mock;

describe('Base Repository', function () {
    beforeEach(function () {
        $this->baseRepository = mock(BaseRepository::class);
    });

    it('implements Eloquent Repository Contract', function () {
        $eloquentContract = class_implements($this->baseRepository);

        expect($eloquentContract)->toContain(EloquentRepository::class);
    });

    it('contains abstract protected static method called getModelFqcn', function () {
        $reflector = new \ReflectionClass($this->baseRepository);

        $reflectionMethod = $reflector->getMethod('getModelFqcn');

        expect($reflectionMethod->getName())->toBeString();
        expect($reflectionMethod->getName())->toBeAbstract();
    });
});
