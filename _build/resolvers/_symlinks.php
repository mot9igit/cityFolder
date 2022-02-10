<?php
/** @var xPDOTransport $transport */
/** @var array $options */
/** @var modX $modx */
if ($transport->xpdo) {
    $modx =& $transport->xpdo;

    $dev = MODX_BASE_PATH . 'Extras/cityFolder/';
    /** @var xPDOCacheManager $cache */
    $cache = $modx->getCacheManager();
    if (file_exists($dev) && $cache) {
        if (!is_link($dev . 'assets/components/cityfolder')) {
            $cache->deleteTree(
                $dev . 'assets/components/cityfolder/',
                ['deleteTop' => true, 'skipDirs' => false, 'extensions' => []]
            );
            symlink(MODX_ASSETS_PATH . 'components/cityfolder/', $dev . 'assets/components/cityfolder');
        }
        if (!is_link($dev . 'core/components/cityfolder')) {
            $cache->deleteTree(
                $dev . 'core/components/cityfolder/',
                ['deleteTop' => true, 'skipDirs' => false, 'extensions' => []]
            );
            symlink(MODX_CORE_PATH . 'components/cityfolder/', $dev . 'core/components/cityfolder');
        }
    }
}

return true;