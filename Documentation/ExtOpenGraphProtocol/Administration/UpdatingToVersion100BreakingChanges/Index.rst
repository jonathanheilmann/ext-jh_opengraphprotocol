

.. ==================================================
.. FOR YOUR INFORMATION
.. --------------------------------------------------
.. -*- coding: utf-8 -*- with BOM.

.. ==================================================
.. DEFINE SOME TEXTROLES
.. --------------------------------------------------
.. role::   underline
.. role::   typoscript(code)
.. role::   ts(typoscript)
   :class:  typoscript
.. role::   php(code)


Updating to version 1.0.0 – Breaking changes
^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^

With version 1.0.0 some changes has been done.To still provide the old
behavior, functionalities and support TYPO3 CMS 4.5 the old code is
available through the template “Open Graph protocol v0.3.0”.

If you use a TYPO3 CMS installation at version 4.5 or 4.7 nothing
changed except the included template title (now “Open Graph protocol
v0.3.0”)

If you use a TYPO3 CMS installation at version 6.0 to 6.1 you could
still use the included template “Open Graph protocol v0.3.0”, and
everything works as in past.

**Breaking changes apply to two cases:**

- You updated your TYPO3 CMS installation to version 6.2: you will need
  to re-include the template “Open Graph protocol”

- You removed the included template “Open Graph protocol v0.3.0” and add
  the new template “Open Graph protocol v0.3.0” in TYPO3 CMS version 6.0
  to 6.1.

**In these both cases you may respect some breaking changes:**

- Constants changed from “plugin.jh\_opengraphprotocol” to
  “plugin.tx\_jhopengraphprotocol”

- Constant “plugin.tx\_jhopengraphprotocol.title” has been removed.
  There is no sense of a global title.

- Constants default of Open Graph property
  “plugin.tx\_jhopengraphprotocol.type” has been set to “website”

- Priority of Open Graph property “title” has changed (see chapter
  “Users manual” → “Operating Instructions”)

