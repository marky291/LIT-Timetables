<?php

namespace App\Actions\Search;

use App\Models\Search;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Lorisleiva\Actions\Concerns\AsAction;

class DeleteSearchesAfterDate
{
    use AsAction;

    public string $commandSignature = 'search:purge {days_old}';

    public string $commandDescription = 'Purge cookie searches from the database.';

    public function handle(Carbon $carbon): void
    {
        Search::whereDate('created_at', '<', $carbon)->delete();
    }

    public function asCommand(Command $command, Carbon $carbon)
    {
        $this->handle($carbon->subDays($command->argument('days_old')));

        $command->info("Purged cookie searches that were {$command->argument('days_old')} days old successfully.");
    }
}
