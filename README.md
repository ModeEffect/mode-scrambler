# ModeEffect Scrambler 
Run WP CLI command to wipe sensitive user data and WooCommerce customer data.

## Usage

`wp scramble`

## Subcommands

- `wp scramble wp`
- `wp scramble wc`
- `wp scramble version`

## Options

`--email`
- Any string in `user_email` to ignore. 
- Default: modeeffect.com

## Examples

```
$ wp scramble wp --emal=some-string
WordPress use data scrambled successfully!

$ wp scramble wc --emal=some-string
WooCommerce customer data scrambled successfully!
