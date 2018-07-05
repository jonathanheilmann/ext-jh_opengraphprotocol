.. ==================================================
.. FOR YOUR INFORMATION
.. --------------------------------------------------
.. -*- coding: utf-8 -*- with BOM.

.. include:: ../Includes.txt


.. _howto:

How to
======


.. _fbappid:

Add fb:app_id
-------------

If your website requires a facebook App-ID (`fb:app_id`), these two TypoScript setup lines are required:

```
    config.htmlTag_setParams := appendString( xmlns:fb="http://ogp.me/ns/fb#")
    page.headerData.1530764736 = <meta property="fb:app_id" content="0123456789" />
```

