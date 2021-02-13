<?php

namespace App\Factory;

use App\Entity\Hotel;
use App\Repository\HotelRepository;
use Zenstruck\Foundry\RepositoryProxy;
use Zenstruck\Foundry\ModelFactory;
use Zenstruck\Foundry\Proxy;

/**
 * @method static Hotel|Proxy createOne(array $attributes = [])
 * @method static Hotel[]|Proxy[] createMany(int $number, $attributes = [])
 * @method static Hotel|Proxy findOrCreate(array $attributes)
 * @method static Hotel|Proxy random(array $attributes = [])
 * @method static Hotel|Proxy randomOrCreate(array $attributes = [])
 * @method static Hotel[]|Proxy[] randomSet(int $number, array $attributes = [])
 * @method static Hotel[]|Proxy[] randomRange(int $min, int $max, array $attributes = [])
 * @method static HotelRepository|RepositoryProxy repository()
 * @method Hotel|Proxy create($attributes = [])
 */
final class HotelFactory extends ModelFactory
{
    protected function getDefaults(): array
    {
        return [
            'name' => ucfirst(self::faker()->name)
        ];
    }

    protected static function getClass(): string
    {
        return Hotel::class;
    }
}
