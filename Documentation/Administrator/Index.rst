.. ==================================================
.. FOR YOUR INFORMATION
.. --------------------------------------------------
.. -*- coding: utf-8 -*- with BOM.

.. include:: ../Includes.txt


.. _admin-manual:

Administrator Manual
====================

.. _admin-installation:

Installation
------------

- import and install the extension

- include static template “Open Graph protocol”

- use the Constant-Editor to edit the global Open Graph properties

- use the page-settings for setting the local Open Graph properties



.. _admin-updating:

Updating
--------

Some extension versions requires some special attention when updating.
Please read the introductions carefully and follow each step.

.. only:: html

   .. contents::
      :local:
      :depth: 1


.. _admin-updating-toVersion120:

To version 1.2.0
^^^^^^^^^^^^^^^^

Skips tx_jhopengraphprotocol for single news view, as EXT:news adds dedicated og-properties.
   
.. _admin-updating-toVersion110:

To version 1.1.0
^^^^^^^^^^^^^^^^

In version 1.1.0 the related media files for meta tag "og:image" has been moved to FAL.

To migrate existing relations follow these steps:

#. Go to Install tool

#. Open Upgrade Wizard

   .. figure:: ../Images/FalUpdateWizard_01.png
      :width: 500

#. Execute "Migrate file relations of EXT:jh\_opengraphprotocol"

   .. figure:: ../Images/FalUpdateWizard_02.png
      :width: 500
   
#. Migration has been done and FAL related images will be used
   
   .. figure:: ../Images/FalUpdateWizard_03.png
      :width: 500
 
      
.. _admin-updating-toVersion100:

.. important::

   Since version 1.1.0 the template “Open Graph protocol v0.3.0”
   is not provided anymore. Please respect 1.0.0 breaking changes
   below, when updating.

To version 1.0.0 – Breaking changes
^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^
   
With version 1.0.0 some changes has been done. To still provide the old
behavior, functionalities and support TYPO3 CMS 4.5 the old code is
available through template “Open Graph protocol v0.3.0”.

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