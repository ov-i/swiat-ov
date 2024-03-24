<?php

namespace App\Livewire;

use App\Enums\AppThemeEnum;
use App\Models\User;
use Livewire\Component;

class ThemeSwitcher extends Component
{
    public string $theme;

    public function mount()
    {
        $user = $this->getLoggedInUser();

        $this->theme = filled($user) ? $user->getTheme() : 'light';
    }

    public function render()
    {
        return view('livewire.theme-switcher', ['theme' => $this->theme]);
    }

    public function toggleTheme()
    {
        $user = $this->getLoggedInUser();
        $theme = match($this->theme) {
            AppThemeEnum::LIGHT->value => AppThemeEnum::DARK->value,
            AppThemeEnum::DARK->value => AppThemeEnum::LIGHT->value,
        };

        if(filled($user)) {
            $user->updateTheme(AppThemeEnum::from($theme));
        }

        $this->dispatch('app.theme-change', ['theme' => $theme]);
    }

    public function getLoggedInUser(): ?User
    {
        return auth()->user();
    }
}
