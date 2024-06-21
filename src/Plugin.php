<?php

namespace Asapo\RemoveVendorPlugin;

use Composer\Composer;
use Composer\EventDispatcher\EventSubscriberInterface;
use Composer\IO\IOInterface;
use Composer\Plugin\PluginInterface;
use Composer\Script\Event;

class Plugin implements PluginInterface, EventSubscriberInterface
{
    public function activate(Composer $composer, IOInterface $io)
    {
    }

    public function deactivate(Composer $composer, IOInterface $io)
    {
    }

    public function uninstall(Composer $composer, IOInterface $io)
    {
    }

    public static function getSubscribedEvents()
    {
        return [
            'post-update-cmd' => 'onPostUpdate',
            'post-install-cmd' => 'onPostInstall',
        ];
    }

    public static function onPostUpdate(Event $event)
    {
        self::removeVendorFolders($event);
    }

    public static function onPostInstall(Event $event)
    {
        self::removeVendorFolders($event);
    }

    private static function removeVendorFolders(Event $event)
    {
        $composer = $event->getComposer();
        $extra = $composer->getPackage()->getExtra();
        $vendorDir = $composer->getConfig()->get('vendor-dir');

        if (isset($extra['remove-folders'])) {
            foreach ($extra['remove-folders'] as $pattern) {
                $packageDirs = glob($vendorDir . '/' . $pattern);

                foreach ($packageDirs as $dir) {
                    self::removeDirectory($dir);
                }
            }
        }
    }

    private static function removeDirectory($dir)
    {
        if (!is_dir($dir)) {
            return;
        }

        $objects = scandir($dir);
        foreach ($objects as $object) {
            if ($object != "." && $object != "..") {
                if (is_dir($dir . "/" . $object)) {
                    self::removeDirectory($dir . "/" . $object);
                } else {
                    unlink($dir . "/" . $object);
                }
            }
        }
        rmdir($dir);
    }
}
