import preset from '../../../../vendor/filament/filament/tailwind.config.preset'

export default {
    presets: [preset],
    content: [
        './app/Filament/**/*.php',
        './resources/views/filament/**/*.blade.php',
        './vendor/filament/**/*.blade.php',
        './vendor/kenepa/translation-manager/resources/**/*.blade.php',
        './vendor/awcodes/filament-curator/resources/**/*.blade.php',
        './vendor/solution-forest/filament-tree/resources/**/*.blade.php',
        './resources/views/vendor/custom/**/*.blade.php',
    ],
}
