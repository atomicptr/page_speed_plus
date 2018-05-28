# pagespeed+

Improve your TYPO3 page speed by using common best practices and other shenanigans :).

## Download

[page\_speed\_plus on TER](https://extensions.typo3.org/extension/page_speed_plus/)

Or just install it via composer:

```shell
$ composer require atomicptr/page_speed_plus
```

## Features

* HTTP/2 Server Push
* HTML Compression via [wyrihaximus/html-compress](https://github.com/WyriHaximus/HtmlCompress)
* JavaScript Compression via [tedious/JShrink](https://github.com/tedious/JShrink)

## Configuration

You can use the constants editor or just overwrite the TypoScript like this:

```typoscript
plugin.tx_page_speed_plus {
    settings {
        http2 {
            serverPushEnable = 1
            maxHeaderLength = 8190
        }

        htmlCompress {
            enable = 1
        }
    }
}
```

### How to enable JavaScript compression

You can enable JavaScript compression by adding this to your configuration:

```typoscript
config.compressJs = 1
```

## Other ways to improve your website performance

* Set your FE compression level to 9 in the install tool (and also add this to your .htaccess)
    ```
    <FilesMatch "\.js\.gzip$">
        AddType "text/javascript" .gzip
    </FilesMatch>
    <FilesMatch "\.css\.gzip$">
        AddType "text/css" .gzip
    </FilesMatch>
    AddEncoding gzip .gzip
    ```
* Optimize your images, this is **REALLY important**!

## Support me

<a href="https://www.buymeacoffee.com/atomicptr" target="_blank"><img src="https://www.buymeacoffee.com/assets/img/custom_images/orange_img.png" alt="Buy Me A Coffee" style="height: auto !important;width: auto !important;" ></a>

## License

MIT