<?php

namespace App\Traits;

use App\Enums\AppTheme;
use App\Models\AppSettings;
use Illuminate\Database\Eloquent\Relations\HasOne;

trait HasSettings
{
    public function settings(): HasOne
    {
        return $this->hasOne(AppSettings::class);
    }

    public function getTheme(): AppTheme
    {
        return $this->settings()
            ->firstWhere('id', $this->getKey())
            ->theme;
    }

    public function updateTheme(AppTheme $theme): bool
    {
        return $this->settings()
            ->update(['theme' => $theme->value]);
    }
}
