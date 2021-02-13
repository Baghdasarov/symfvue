<?php

namespace App\Factory;

use App\Entity\Review;
use App\Repository\ReviewRepository;
use Zenstruck\Foundry\ModelFactory;
use Zenstruck\Foundry\Proxy;
use Zenstruck\Foundry\RepositoryProxy;

/**
 * @method static Review|Proxy createOne(array $attributes = [])
 * @method static Review[]|Proxy[] createMany(int $number, $attributes = [])
 * @method static Review|Proxy findOrCreate(array $attributes)
 * @method static Review|Proxy random(array $attributes = [])
 * @method static Review|Proxy randomOrCreate(array $attributes = [])
 * @method static Review[]|Proxy[] randomSet(int $number, array $attributes = [])
 * @method static Review[]|Proxy[] randomRange(int $min, int $max, array $attributes = [])
 * @method static ReviewRepository|RepositoryProxy repository()
 * @method Review|Proxy create($attributes = [])
 */
final class ReviewFactory extends ModelFactory
{

    protected function getDefaults(): array
    {
        return [
            'score' => self::faker()->numberBetween(1, 10),
            'comment' => self::faker()->paragraph(random_int(1, 3)),
            'created_date' => self::faker()->dateTimeBetween('-2 years')
        ];
    }

    protected static function getClass(): string
    {
        return Review::class;
    }
}
