<?php

declare(strict_types=1);

namespace App\Enums\Post;

enum PostHistoryAction: string
{
    case Created = 'created';

    case Delayed = 'delayed';

    case Updated = 'updated';

    case SavedAsDraft = 'savedAsDraft';

    case Archived = 'archived';

    case Deleted = 'deleted';

    case Restored = 'restored';

    case ForceDeleted = 'forceDeleted';

    case Unpublished = 'unpublished';

    case Published = 'published';

    case Closed = 'closed';

    public function label(): string
    {
        return match($this) {
            self::ForceDeleted => 'Forced deleted',
            self::SavedAsDraft => 'Saved as draft',
            default => str($this->value)->ucfirst(),
        };
    }
}
