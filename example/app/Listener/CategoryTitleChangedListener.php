<?php

namespace App\Listener;

use App\Entity\EventBridgeEvent;
use Doctrine\Bundle\DoctrineBundle\Attribute\AsEntityListener;
use Doctrine\ORM\Event\PostUpdateEventArgs;
use Doctrine\ORM\Events;
use App\Entity\Category;
use Gedmo\Loggable\LogEntryInterface;
use Gedmo\Loggable\Mapping\Event\LoggableAdapter;
use Gedmo\Tool\Wrapper\AbstractWrapper;

/**
 * We can subscribe this to the Doctrine event and the Symfony TERMINATE event
 * to dispatch the events.
 */
#[AsEntityListener(event: Events::postUpdate, method: 'postUpdate', entity: Category::class)]
class CategoryTitleChangedListener
{
    private $events;

    // the entity listener methods receive two arguments:
    // the entity instance and the lifecycle event
    public function postUpdate(Category $category, PostUpdateEventArgs $event): void
    {
        $om = $event->getObjectManager();
        $uow = $om->getUnitOfWork();
        $changes = $uow->getEntityChangeSet($event->getObject());
        if (\array_key_exists('title', $changes)) {
            echo "\nTitle has changed from " . $changes['title'][0] . " to " . $changes['title'][1] . "\n\n";
        }

        $ebe = EventBridgeEvent::createTestEvent();
        $ebeMeta = $om->getClassMetadata(get_class($ebe));
        $om->persist($ebe);
        $uow->computeChangeSet($ebeMeta, $ebe);
        $persister = $uow->getEntityPersister(get_class($ebe));
        $persister->addInsert($ebe);
        $persister->executeInserts();

        $this->events[] = $ebe;
    }

    private function removeOldValues(array $changes): array
    {
        $onlyNew = [];
        foreach ($changes as $field => $change) {
            $newChange = $change[1];
            if (is_array($newChange)) {
                $newChange = json_encode($newChange);
            }
            if ($newChange instanceof \DateTimeInterface) {
                $newChange = $newChange->format('c');
            }
            $onlyNew[$field] = $newChange;
        }
        return $onlyNew;
    }

    public function onTerminate()
    {
        // get the EB service, foreach $this->events EMIT event
        // change the sent_at in the db
    }
}