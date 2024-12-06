<?php

namespace App\Factory;

use App\Entity\Event;
use App\Repository\EventRepository;
use Zenstruck\Foundry\ModelFactory;
use Zenstruck\Foundry\Persistence\PersistentProxyObjectFactory;
use Zenstruck\Foundry\Proxy;
use Zenstruck\Foundry\RepositoryProxy;

/**
 * @extends ModelFactory<Event>
 *
 * @method        Event|Proxy create(array|callable $attributes = [])
 * @method static Event|Proxy createOne(array $attributes = [])
 * @method static Event|Proxy find(object|array|mixed $criteria)
 * @method static Event|Proxy findOrCreate(array $attributes)
 * @method static Event|Proxy first(string $sortedField = 'id')
 * @method static Event|Proxy last(string $sortedField = 'id')
 * @method static Event|Proxy random(array $attributes = [])
 * @method static Event|Proxy randomOrCreate(array $attributes = [])
 * @method static EventRepository|RepositoryProxy repository()
 * @method static Event[]|Proxy[] all()
 * @method static Event[]|Proxy[] createMany(int $number, array|callable $attributes = [])
 * @method static Event[]|Proxy[] createSequence(iterable|callable $sequence)
 * @method static Event[]|Proxy[] findBy(array $attributes)
 * @method static Event[]|Proxy[] randomRange(int $min, int $max, array $attributes = [])
 * @method static Event[]|Proxy[] randomSet(int $number, array $attributes = [])
 */
final class EventFactory extends PersistentProxyObjectFactory
{
    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#factories-as-services
     *
     * @todo inject services if required
     */
    public function __construct() {}

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#model-factories
     *
     * @todo add your default values here
     */
    protected function defaults(): array|callable
    {
        return [
            'body' => self::faker()->text(),
            'createdAt' => \DateTimeImmutable::createFromMutable(self::faker()->dateTime()),
            'endDate' => self::faker()->dateTime(),
            'slug' => self::faker()->slug(2),
            'startDate' => self::faker()->dateTime(),
            'title' => self::faker()->text(255),
            'updatedAt' => \DateTimeImmutable::createFromMutable(self::faker()->dateTime()),
            'description' => self::faker()->sentence
        ];
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#initialization
     */
    protected function initialize(): self
    {
        return $this
            // ->afterInstantiate(function(Event $event): void {})
        ;
    }

    public static function class(): string
    {
        return Event::class;
    }
}
