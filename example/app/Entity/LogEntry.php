<?php

declare(strict_types=1);

/*
 * This file is part of the Doctrine Behavioral Extensions package.
 * (c) Gediminas Morkevicius <gediminas.morkevicius@gmail.com> http://www.gediminasm.org
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Entity;


use Gedmo\Loggable\Entity\MappedSuperclass\AbstractLogEntry;
use Gedmo\Loggable\Entity\Repository\LogEntryRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * App\Entity\LogEntry
 *
 * @ORM\Table(
 *     name="ext_log_entries",
 *     options={"row_format": "DYNAMIC"},
 *     indexes={
 *         @ORM\Index(name="log_class_lookup_idx", columns={"object_class"}),
 *         @ORM\Index(name="log_date_lookup_idx", columns={"logged_at"}),
 *         @ORM\Index(name="log_user_lookup_idx", columns={"username"}),
 *         @ORM\Index(name="log_version_lookup_idx", columns={"object_id", "object_class", "version"})
 *     }
 * )
 * @ORM\Entity(repositoryClass="Gedmo\Loggable\Entity\Repository\LogEntryRepository")
 */
#[ORM\Entity(repositoryClass: LogEntryRepository::class)]
#[ORM\Table(name: 'ext_log_entries', options: ['row_format' => 'DYNAMIC'])]
#[ORM\Index(name: 'log_class_lookup_idx', columns: ['object_class'])]
#[ORM\Index(name: 'log_date_lookup_idx', columns: ['logged_at'])]
#[ORM\Index(name: 'log_user_lookup_idx', columns: ['username'])]
#[ORM\Index(name: 'log_version_lookup_idx', columns: ['object_id', 'object_class', 'version'])]
class LogEntry extends AbstractLogEntry
{
}
