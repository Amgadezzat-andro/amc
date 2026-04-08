<?php

namespace App\Filament\Forms\Components;

use CactusGalaxy\FilamentAstrotomic\Forms\Components\TranslatableTabs;
use CactusGalaxy\FilamentAstrotomic\FilamentAstrotomicTranslatablePlugin;

class TranslatableTabsNoArabic extends TranslatableTabs
{
    public function localeTabSchema(callable $tabSchema): self
    {
        /** @var FilamentAstrotomicTranslatablePlugin $plugin */
        $plugin = filament('filament-astrotomic-translatable');
        $allLocales = $plugin->allLocales();
        $this->availableLocales = array_values(array_filter($allLocales, fn (string $locale): bool => $locale !== 'ar'));
        return parent::localeTabSchema($tabSchema);
    }
}
