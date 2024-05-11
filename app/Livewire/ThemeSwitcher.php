<?php

namespace App\Livewire;

use App\Enums\AppTheme;
use App\Models\User;
use Livewire\Attributes\Computed;
use Livewire\Component;

class ThemeSwitcher extends Component
{
    public AppTheme|string $theme;

    public function mount(): void
    {
        $user = $this->getLoggedInUser();

        if (filled($user)) {
            $this->theme = $user->getTheme();
        } else {
            $this->theme = AppTheme::Light;
        }
    }

    #[Computed]
    public function theme(): AppTheme|string
    {
        return $this->theme;
    }

    public function toggleTheme(): void
    {
        $user = $this->getLoggedInUser();
        $theme = match($this->theme) {
            AppTheme::Light => AppTheme::Dark,
            AppTheme::Dark => AppTheme::Light,
        };

        if(filled($user)) {
            $user->updateTheme($theme);
        }

        $this->theme = $theme;

        $this->dispatch('app.theme-change', ['theme' => $theme]);
    }

    public function getLoggedInUser(): ?User
    {
        return auth()->user();
    }
}
