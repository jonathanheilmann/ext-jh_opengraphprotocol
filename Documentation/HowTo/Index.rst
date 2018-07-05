.. ==================================================
.. FOR YOUR INFORMATION
.. --------------------------------------------------
.. -*- coding: utf-8 -*- with BOM.

.. include:: ../Includes.txt


.. _howto:

How to
======

.. _namespacedeclaration

Open Graph namespace declaration: HTML with XMLNS or head prefix?
-----------------------------------------------------------------

Using the prefix-attribute is the new and recommended way of declaring the Open Graph namespace.

```
    <html prefix="og: http://ogp.me/ns#">
```

But as the prefix attribute is not extendable by TypoScript without overriding the complete html-tag parameters, this
extension uses still the old approach of declaring a XMLNS to create a result like this

```
    <html xmlns:og="http://ogp.me/ns#">
```

If you want to use the prefix attribute, make sure to collect all used html-tag parameters and set them like this

```
    config.htmlTag_setParams = prefix="og: http://ogp.me/ns# fb: http://ogp.me/ns/fb#" class="your-own-class"
```

.. _fbappid:

Add fb:app_id
-------------

If your website requires a facebook App-ID (`fb:app_id`), these two TypoScript setup lines are required:

```
    config.htmlTag_setParams := appendString( xmlns:fb="http://ogp.me/ns/fb#")
    page.headerData.1530764736 = <meta property="fb:app_id" content="0123456789" />
```

