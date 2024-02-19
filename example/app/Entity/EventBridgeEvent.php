<?php

declare(strict_types=1);

/*
 * This file is part of the Doctrine Behavioral Extensions package.
 * (c) Gediminas Morkevicius <gediminas.morkevicius@gmail.com> http://www.gediminasm.org
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Entity;


use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Ramsey\Uuid\Doctrine\UuidGenerator;

#[ORM\Entity]
#[ORM\Table(name: "event_bridge_event")]
class EventBridgeEvent
{
    #[ORM\Id]
    #[ORM\Column(type: "guid", length: 255)]
    #[ORM\GeneratedValue(strategy: "CUSTOM")]
    #[ORM\CustomIdGenerator(class: UuidGenerator::class)]
    private string $id;

    #[ORM\Column(type: "string", length: 255)]
    private string $source;

    #[ORM\Column(type: "string", length: 255)]
    private string $account;

    #[ORM\Column(type: "datetime")]
    private \DateTimeInterface $time;

    #[ORM\Column(type: "string", length: 255)]
    private string $region;

    #[ORM\Column(type: "json")]
    private array $resources;

    #[ORM\Column(type: "string", length: 255)]
    private string $detailType;

    #[ORM\Column(type: "json")]
    private array $detail;

    private function __construct(array $properties)
    {
        foreach (array_keys($properties) as $key) {
            $this->{$key} = $properties[$key];
        }
    }

    public static function createTestEvent(): self
    {
        return new self([
            'source' => "source",
            'detailType' => "detailType",
            'detail' => ['a' => 'hello'],
            'region' => 'us-east-1',
            'account' => '123',
            'resources' => ['b' => 'resources'],
            'time' => new \DateTimeImmutable(),
        ]);
    }

    // Getters and setters for all properties
}