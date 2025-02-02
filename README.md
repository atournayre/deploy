# Deploy Symfony application

Use [Castor](https://castor.jolicode.com/) to deploy Symfony application.

## Installation

1. `composer require atournayre/deploy`
2. `cp vendor/atournayre/deploy/install/.env.dist tools/castor/.env`
3. `cp vendor/atournayre/deploy/install/castor.php castor.php`
4. Run `castor list` to see available commands.

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

#### Prerequisites

- You must have a `composer.json` file in your working directory.
- Your app must use semantic versioning.

#### How it works?

1. Check if there are uncommitted changes in your working directory, if so, abort.
2. Update main branch
3. Get current version
4. Create hotfix branch
5. Update version
6. Run hotfix-post-update-version hook
7. Commit
8. Push
9. Ask for creation of a sub-branch in the hotfix branch
10. Create the branch
11. Done!

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
