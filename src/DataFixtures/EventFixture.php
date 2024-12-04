<?php

namespace App\DataFixtures;

use App\Entity\Event;
use App\Factory\EventFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class EventFixture extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        EventFactory::createMany(20);
    }
}
