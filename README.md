# Remove Vendor Plugin

A Composer plugin to remove specific folders inside the `vendor` directory after installation or updating.

## Installation

1. Add the plugin to your project's `composer.json`:

    ```json
    {
      "require": {
        "asapo/remove-vendor-plugin": "*"
      },
      "config": {
        "allow-plugins": {
          "asapo/remove-vendor-plugin": true
        }
      }
    }
    ```

2. Run Composer install or update:

    ```sh
    composer install
    ```

   or

    ```sh
    composer update
    ```

## Configuration

To configure the folders to be removed, add the `remove-folders` option under the `extra` key in your `composer.json`:

```json
{
    "extra": {
        "remove-folders": [
            "modelflow-ai/*/vendor"
        ]
    }
}
```

You can specify multiple patterns if needed.

## Usage

This plugin hooks into Composer's `post-install-cmd` and `post-update-cmd` events. After running `composer install`
or `composer update`, it will automatically remove the specified folders.

## Development

### Directory Structure

```
remove-vendor-plugin/
├── composer.json
├── src/
│   ├── Plugin.php
│   ├── EventSubscriber.php
└── README.md
```

### Namespaces

Ensure that the namespaces in your PHP files match the directory structure and autoload configuration
in `composer.json`.
