<?php

namespace App\Traits;

use App\Enums\AppThemeEnum;
use App\Models\AppSettings;
use Illuminate\Database\Eloquent\Relations\HasOne;

trait HasSettings
{
    public function settings(): HasOne
    {
        return $this->hasOne(AppSettings::class);
    }

    public function getTheme(): string
    {
        return $this->settings()
            ->firstWhere('id', $this->getKey())
            ->theme;
    }

    public function updateTheme(AppThemeEnum $theme): bool
    {
        return $this->settings()
            ->update(['theme' => $theme->value]);
    }
}
