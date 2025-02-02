# Deploy Symfony application

Use [Castor](https://castor.jolicode.com/) to deploy Symfony application.

## Features

- Hotfix
    - deploy
    - create
    - merge


## Hotfix

### Deploy
Run a specific deployment script.
```bash
castor hotfix:deploy
```

### How it works?

1. Ask for confirmation
2. Run pre-deploy hook
3. Update code
4. Run post-update-code hook
5. Clear cache
6. Run post-deploy hook
7. It's done!

#### Events
- hook:pre-deploy
- hook:post-update-code (e.g. Grunt)
- hook:post-deploy

### Create
Generate a hotfix branch and optionally create a sub-branch for a specific issue.
```bash
castor hotfix:generate
```

### Merge
Merge the hotfix branch into main, develop and releases.
```bash
castor hotfix:merge
```


## Hooks

To use hooks, you must create listeners in `tools/castor/events`.

```php
<?php
declare(strict_types=1);

namespace App\Tools\Castor\Events;

use Castor\Attribute\AsListener;
use Castor\Event\AfterExecuteTaskEvent;
use function Castor\context;
use function Castor\io;

#[AsListener(event: AfterExecuteTaskEvent::class)]
function afterExecutePostDeploy(AfterExecuteTaskEvent $event): void
{
    if ($event->task->getName() !== 'hook:post-deploy') {
        return;
    }

    // do something
}
```

